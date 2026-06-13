<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Plot;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'plot_id' => 'required|exists:plots,id',
            'referral_agent_id' => 'nullable|exists:users,id',
            'additional_info' => 'nullable|string|max:1000',
            'payment_type' => 'required|in:one_time,installment',
            'booking_money_option' => 'required|in:full,custom',
            'custom_booking_amount' => 'nullable|required_if:booking_money_option,custom|numeric|min:1',
            'installment_plan' => 'nullable|required_if:payment_type,installment|in:monthly,quarterly',
            'total_installments' => 'nullable|required_if:payment_type,installment|integer|min:1',
            'terms_accepted' => 'required|accepted',
            'owners' => 'nullable|array',
            'owners.*.name' => 'required_with:owners|string|max:255',
            'owners.*.phone' => 'required_with:owners|string|max:20',
            'owners.*.address' => 'required_with:owners|string|max:500',
            'owners.*.nid' => 'required_with:owners|string|max:50',
            'owners.*.father_name' => 'nullable|string|max:255',
            'owners.*.mother_name' => 'nullable|string|max:255',
            'owners.*.spouse_name' => 'nullable|string|max:255',
            'owners.*.nominee_info' => 'nullable|string|max:2000',
        ]);

        // Check if user is authenticated
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => 'You must be logged in to book a plot.'
            ], 401);
        }

        // Check if plot is available
        $plot = Plot::findOrFail($request->plot_id);
        
        if ($plot->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'This plot is no longer available for booking.'
            ], 400);
        }

        // Check if user already has a pending/confirmed booking for this plot
        $existingBooking = Booking::where('user_id', Auth::id())
            ->where('plot_id', $request->plot_id)
            ->whereIn('status', ['pending', 'confirmed', 'pre-booked'])
            ->first();

        if ($existingBooking) {
            return response()->json([
                'success' => false,
                'message' => 'You already have a booking for this plot.'
            ], 400);
        }

        // Calculate remaining payment
        $remainingPayment = $plot->price - ($plot->booking_payment ?? 0);

        // Calculate installment payment if payment type is installment
        $installmentPayment = null;
        $installmentPlan = null;
        $totalInstallments = null;
        
        if ($request->payment_type === 'installment' && $request->total_installments > 0) {
            $installmentPayment = $remainingPayment / $request->total_installments;
            $installmentPlan = $request->installment_plan;
            $totalInstallments = $request->total_installments;
        }

        // Determine booking status and custom amount based on booking money option
        $bookingStatus = 'pending';
        $customBookingAmount = null;
        $preBookingExpiresAt = null;

        if ($request->booking_money_option === 'custom') {
            $bookingStatus = 'pre-booked';
            $customBookingAmount = $request->custom_booking_amount;
            $preBookingExpiresAt = now()->addDays(15);
        }

        // Create the booking (commission is distributed per the hierarchy chart at payment time)
        $booking = Booking::create([
            'user_id' => Auth::id(),
            'plot_id' => $request->plot_id,
            'referral_agent_id' => $request->referral_agent_id,
            'agent_commission' => null,
            'commission_scheme' => 'hierarchy',
            'additional_info' => $request->additional_info,
            'price' => $plot->price,
            'booking_payment' => $plot->booking_payment ?? 0,
            'custom_booking_amount' => $customBookingAmount,
            'remaining_payment' => $remainingPayment,
            'installment_plan' => $installmentPlan,
            'total_installments' => $totalInstallments,
            'installment_payment' => $installmentPayment,
            'status' => $bookingStatus,
            'booking_date' => now(),
            'pre_booking_expires_at' => $preBookingExpiresAt,
            'owners' => $request->owners,
        ]);

        // Update plot status to pending
        $plot->update(['status' => 'pending']);

        $message = 'Your booking has been submitted successfully! Our team will contact you soon.';
        if ($bookingStatus === 'pre-booked') {
            $message = 'Your pre-booking has been submitted successfully! Please pay the full booking money within 15 days to confirm your booking.';
        }

        return response()->json([
            'success' => true,
            'message' => $message,
            'booking_id' => $booking->id,
            'is_pre_booked' => $bookingStatus === 'pre-booked',
        ]);
    }

    /**
     * Show the form for editing a pending booking.
     */
    public function edit(Booking $booking)
    {
        // Ensure booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only pending or pre-booked bookings can be edited
        if (!in_array($booking->status, ['pending', 'pre-booked'])) {
            return redirect()->route('account.bookings')
                ->with('error', 'Only pending or pre-booked bookings can be edited.');
        }

        $booking->load('plot', 'agent');

        $plots = Plot::where('status', 'available')
            ->orWhere('id', $booking->plot_id)
            ->orderBy('plot_no')
            ->get();

        $agents = User::where('role', 'agent')
            ->whereNotNull('commission_type')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        return view('Website.user.booking-edit', compact('booking', 'plots', 'agents'));
    }

    /**
     * Update a pending booking.
     */
    public function update(Request $request, Booking $booking)
    {
        // Ensure booking belongs to the authenticated user
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Only pending or pre-booked bookings can be updated
        if (!in_array($booking->status, ['pending', 'pre-booked'])) {
            return redirect()->route('account.bookings')
                ->with('error', 'Only pending or pre-booked bookings can be edited.');
        }

        $request->validate([
            'plot_id' => 'required|exists:plots,id',
            'referral_agent_id' => 'nullable|exists:users,id',
            'additional_info' => 'nullable|string|max:1000',
            'payment_type' => 'required|in:one_time,installment',
            'booking_money_option' => 'required|in:full,custom',
            'custom_booking_amount' => 'nullable|required_if:booking_money_option,custom|numeric|min:1',
            'installment_plan' => 'nullable|required_if:payment_type,installment|in:monthly,quarterly',
            'total_installments' => 'nullable|required_if:payment_type,installment|integer|min:1',
            'owners' => 'nullable|array',
            'owners.*.name' => 'required_with:owners|string|max:255',
            'owners.*.phone' => 'required_with:owners|string|max:20',
            'owners.*.address' => 'required_with:owners|string|max:500',
            'owners.*.nid' => 'required_with:owners|string|max:50',
            'owners.*.father_name' => 'nullable|string|max:255',
            'owners.*.mother_name' => 'nullable|string|max:255',
            'owners.*.spouse_name' => 'nullable|string|max:255',
            'owners.*.nominee_info' => 'nullable|string|max:2000',
        ]);

        $newPlot = Plot::findOrFail($request->plot_id);

        // If changing plot, verify new plot is available
        if ($request->plot_id != $booking->plot_id) {
            if ($newPlot->status !== 'available') {
                return redirect()->back()
                    ->with('error', 'The selected plot is not available.')
                    ->withInput();
            }

            // Release old plot
            $booking->plot->update(['status' => 'available']);

            // Reserve new plot
            $newPlot->update(['status' => 'pending']);
        }

        // Recalculate payment details based on new plot
        $remainingPayment = $newPlot->price - ($newPlot->booking_payment ?? 0);

        $installmentPayment = null;
        $installmentPlan = null;
        $totalInstallments = null;

        if ($request->payment_type === 'installment' && $request->total_installments > 0) {
            $installmentPayment = $remainingPayment / $request->total_installments;
            $installmentPlan = $request->installment_plan;
            $totalInstallments = $request->total_installments;
        }

        // Determine booking status and custom amount based on booking money option
        $bookingStatus = 'pending';
        $customBookingAmount = null;
        $preBookingExpiresAt = null;

        if ($request->booking_money_option === 'custom') {
            $bookingStatus = 'pre-booked';
            $customBookingAmount = $request->custom_booking_amount;
            // Only set new expiry if changing to pre-booked from pending, or keep existing
            if ($booking->status === 'pending') {
                $preBookingExpiresAt = now()->addDays(15);
            } else {
                $preBookingExpiresAt = $booking->pre_booking_expires_at;
            }
        }

        // Legacy flat bookings keep their snapshot rate; hierarchy bookings never store one.
        $agentCommission = null;
        if ($booking->isFlatScheme() && $request->referral_agent_id) {
            $referralAgent = User::find($request->referral_agent_id);
            if ($referralAgent) {
                $agentCommission = $referralAgent->commission_rate;
            }
        }

        $booking->update([
            'plot_id' => $newPlot->id,
            'referral_agent_id' => $request->referral_agent_id,
            'agent_commission' => $agentCommission,
            'additional_info' => $request->additional_info,
            'owners' => $request->owners,
            'price' => $newPlot->price,
            'booking_payment' => $newPlot->booking_payment ?? 0,
            'custom_booking_amount' => $customBookingAmount,
            'remaining_payment' => $remainingPayment,
            'installment_plan' => $installmentPlan,
            'total_installments' => $totalInstallments,
            'installment_payment' => $installmentPayment,
            'status' => $bookingStatus,
            'pre_booking_expires_at' => $preBookingExpiresAt,
        ]);

        return redirect()->route('account.bookings')
            ->with('success', 'Booking updated successfully!');
    }
}
