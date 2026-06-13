<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class UserController extends Controller
{
    /**
     * Display the user dashboard with overview stats.
     */
    public function dashboard()
    {
        $userId = Auth::id();

        // Get all user bookings with payments
        $userBookings = Booking::where('user_id', $userId)->with('payments')->get();

        // Calculate total paid installments across all bookings
        $totalPaidInstallments = 0;
        $totalPendingInstallments = 0;
        $nextInstallmentDate = null;

        foreach ($userBookings as $booking) {
            if ($booking->installment_plan && $booking->total_installments) {
                $installmentsPaid = (int) $booking->payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sum('instalment_quantity');
                $totalPaidInstallments += $installmentsPaid;
                $totalPendingInstallments += ($booking->total_installments - $installmentsPaid);

                // Calculate next installment date for active bookings
                if ($booking->status === 'approved' && $booking->total_installments > $installmentsPaid) {
                    $lastPayment = $booking->payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sortByDesc('created_at')->first();
                    $baseDate = $lastPayment ? $lastPayment->created_at : $booking->created_at;
                    
                    switch($booking->installment_plan) {
                        case 'monthly':
                            $nextDate = $baseDate->copy()->addMonth();
                            break;
                        case 'quarterly':
                            $nextDate = $baseDate->copy()->addMonths(3);
                            break;
                        default:
                            $nextDate = null;
                    }

                    // Get the earliest upcoming installment date
                    if ($nextDate && (!$nextInstallmentDate || $nextDate->lt($nextInstallmentDate))) {
                        $nextInstallmentDate = $nextDate;
                    }
                }
            }
        }

        // Calculate aggregate totals from all bookings
        $totalBookingPayment = $userBookings->sum(function ($b) {
            return $b->custom_booking_amount ?: $b->booking_payment;
        });
        $totalInstalmentPayment = $userBookings->sum('installment_payment');
        $totalInstalmentDueAmount = 0;
        $totalPlotPrice = $userBookings->sum('price');

        foreach ($userBookings as $booking) {
            if ($booking->installment_plan && $booking->total_installments) {
                $paidPayments = $booking->payments->where('payment_type', 'Installment Payment');
                $paidQty = $paidPayments->sum('instalment_quantity') ?: $paidPayments->count();
                $dueQty = max(0, $booking->total_installments - $paidQty);
                $totalInstalmentDueAmount += $dueQty * ($booking->installment_payment ?? 0);
            }
        }

        $totalPaid = Payment::whereHas('booking', function($query) use ($userId) {
            $query->where('user_id', $userId);
        })->sum('amount');

        // Calculate stats
        $stats = [
            'total_bookings' => $userBookings->count(),
            'pending_bookings' => $userBookings->where('status', 'pending')->count(),
            'total_paid' => $totalPaid,
            'total_payments' => Payment::whereHas('booking', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count(),
            'paid_installments' => $totalPaidInstallments,
            'pending_installments' => $totalPendingInstallments,
            'next_installment_date' => $nextInstallmentDate,
            'total_plot_price' => $totalPlotPrice,
            'total_booking_payment' => $totalBookingPayment,
            'total_instalment_payment' => $totalInstalmentPayment,
            'total_instalment_due_amount' => $totalInstalmentDueAmount,
            'total_remaining' => $totalPlotPrice - $totalPaid,
        ];

        // Get recent bookings with plot and payments
        $recentBookings = Booking::where('user_id', $userId)
            ->with(['plot', 'payments'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        // Compute per-booking installment stats
        foreach ($recentBookings as $booking) {
            $instalmentPayments = $booking->payments->where('payment_type', 'Installment Payment');
            $paidQty = $instalmentPayments->sum('instalment_quantity') ?: $instalmentPayments->count();
            $booking->instalments_paid = $paidQty;
            $booking->instalments_due_qty = max(0, ($booking->total_installments ?? 0) - $paidQty);
            $booking->instalment_due_amount = $booking->instalments_due_qty * ($booking->installment_payment ?? 0);
            $booking->total_paid_amount = $booking->payments->sum('amount');
        }

        return view('Website.user.account-dashboard', compact('stats', 'recentBookings'));
    }

    /**
     * Display all user bookings.
     */
    public function bookings()
    {
        $bookings = Booking::where('user_id', Auth::id())
            ->with('plot')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('Website.user.dashboard', compact('bookings'));
    }

    /**
     * Display a specific booking detail.
     */
    public function bookingShow(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $booking->load(['plot', 'agent', 'payments']);

        return view('Website.user.booking-show', compact('booking'));
    }

    /**
     * Display all user payments.
     */
    public function payments()
    {
        $userId = Auth::id();

        // Get payment statistics
        $paymentStats = [
            'total_paid' => Payment::whereHas('booking', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->sum('amount'),
            'total_transactions' => Payment::whereHas('booking', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->count(),
            'this_month' => Payment::whereHas('booking', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })->whereMonth('created_at', now()->month)
              ->whereYear('created_at', now()->year)
              ->count(),
        ];

        // Get all payments with booking and plot details
        $payments = Payment::whereHas('booking', function($query) use ($userId) {
                $query->where('user_id', $userId);
            })
            ->with(['booking.plot'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('Website.user.payments', compact('payments', 'paymentStats'));
    }

    /**
     * Display payment invoice with complete booking financial summary.
     */
    public function paymentInvoice(Payment $payment)
    {
        $userId = Auth::id();
        
        // Ensure the payment belongs to the authenticated user
        if ($payment->booking->user_id !== $userId) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $payment->load(['booking.plot', 'booking.user', 'booking.agent', 'booking.payments']);
        
        // Calculate financial summary
        $booking = $payment->booking;
        $totalPaid = $booking->payments->sum('amount');
        $bookingPayments = $booking->payments->where('payment_type', 'Booking Payment')->sum('amount');
        $installmentPayments = $booking->payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sum('amount');
        $otherPayments = $totalPaid - $bookingPayments - $installmentPayments;
        $outstandingBalance = $booking->price - $totalPaid;
        $paidInstallments = (int) $booking->payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sum('instalment_quantity');
        
        $remainingInstallments = max(0, ($booking->total_installments ?? 0) - $paidInstallments);
        $adjustedInstallment = $remainingInstallments > 0 ? round($outstandingBalance / $remainingInstallments, 2) : 0;

        $financialSummary = [
            'total_price' => $booking->price,
            'booking_payment_expected' => $booking->booking_payment,
            'booking_payments_received' => $bookingPayments,
            'installment_payments_received' => $installmentPayments,
            'installment_payment' => (float) $booking->installment_payment,
            'adjusted_installment' => $adjustedInstallment,
            'other_payments' => $otherPayments,
            'total_paid' => $totalPaid,
            'outstanding_balance' => $outstandingBalance,
            'remaining_payment' => $booking->remaining_payment,
            'installment_plan' => $booking->installment_plan,
            'total_installments' => $booking->total_installments,
            'installment_amount' => $booking->installment_payment,
            'paid_installments' => $paidInstallments,
            'remaining_installments' => $remainingInstallments,
            'payment_progress' => $booking->price > 0 ? round(($totalPaid / $booking->price) * 100, 2) : 0,
        ];

        // Calculate extra invoice details for instalment payments
        $invoiceExtra = [];
        if (in_array($payment->payment_type, ['Installment Payment', 'Part Of Installment'])) {
            $qty = $payment->instalment_quantity;
            $amount = (float) $payment->amount;

            if ($payment->payment_type === 'Part Of Installment') {
                $allPartials = $booking->payments
                    ->where('payment_type', 'Part Of Installment')
                    ->where('created_at', '<=', $payment->created_at)
                    ->sum('amount');

                $emiForCalc = $adjustedInstallment > 0 ? $adjustedInstallment : (float) $booking->installment_payment;
                $partialAccumulated = $emiForCalc > 0 ? fmod($allPartials, $emiForCalc) : 0;
                if ($partialAccumulated < 0.01) $partialAccumulated = 0;
                $remainingToComplete = max(0, $emiForCalc - $partialAccumulated);
                $instalmentNumber = $paidInstallments + 1;

                $invoiceExtra['is_partial'] = true;
                $invoiceExtra['partial_accumulated'] = round($partialAccumulated, 2);
                $invoiceExtra['remaining_to_complete'] = round($remainingToComplete, 2);
                $invoiceExtra['instalment_number'] = $instalmentNumber;
                $invoiceExtra['emi_amount'] = $emiForCalc;
            } else {
                $invoiceExtra['is_partial'] = false;
                $invoiceExtra['instalment_qty'] = $qty;
                $expectedAmount = $qty * $adjustedInstallment;
                $invoiceExtra['expected_amount'] = round($expectedAmount, 2);
                $invoiceExtra['emi_amount'] = $adjustedInstallment;

                $overpayment = $amount - $expectedAmount;
                if ($overpayment > 0.01 && $remainingInstallments > 0) {
                    $newEMI = $outstandingBalance / $remainingInstallments;
                    $invoiceExtra['overpayment'] = round($overpayment, 2);
                    $invoiceExtra['new_emi'] = round($newEMI, 2);
                }
            }
        }
        
        return view('Accounts.Admin.payments.invoice', compact('payment', 'financialSummary', 'invoiceExtra'));
    }

    /**
     * Display user profile.
     */
    public function profile()
    {
        return view('Website.user.profile');
    }

    /**
     * Update user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'emergency_phone' => ['nullable', 'string', 'max:20'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'spouse_name' => ['nullable', 'string', 'max:255'],
            'nid' => ['nullable', 'string', 'max:50'],
            'address' => ['nullable', 'string', 'max:500'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'nominee_name' => ['nullable', 'string', 'max:255'],
            'nominee_nid' => ['nullable', 'string', 'max:50'],
            'nominee_photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
            'nominee_relation' => ['nullable', 'string', 'max:255'],
        ];

        $validated = $request->validate($rules);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }
        if (array_key_exists('emergency_phone', $validated)) {
            $user->emergency_phone = $validated['emergency_phone'];
        }
        if (isset($validated['address'])) {
            $user->address = $validated['address'];
        }
        if (isset($validated['father_name'])) {
            $user->father_name = $validated['father_name'];
        }
        if (isset($validated['mother_name'])) {
            $user->mother_name = $validated['mother_name'];
        }
        if (array_key_exists('spouse_name', $validated)) {
            $user->spouse_name = $validated['spouse_name'];
        }
        if (isset($validated['nid'])) {
            $user->nid = $validated['nid'];
        }
        if (isset($validated['nominee_name'])) {
            $user->nominee_name = $validated['nominee_name'];
        }
        if (isset($validated['nominee_nid'])) {
            $user->nominee_nid = $validated['nominee_nid'];
        }
        if (isset($validated['nominee_relation'])) {
            $user->nominee_relation = $validated['nominee_relation'];
        }

        // Handle nominee photo upload
        if ($request->hasFile('nominee_photo')) {
            if ($user->nominee_photo && file_exists(public_path($user->nominee_photo))) {
                unlink(public_path($user->nominee_photo));
            }
            $file = $request->file('nominee_photo');
            $filename = time() . '_nominee_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $user->nominee_photo = 'uploads/user/' . $filename;
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $user->photo = 'uploads/user/' . $filename;
        }

        $user->save();

        return redirect()->route('account.profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Change user password (separate form).
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'confirmed', PasswordRule::defaults()],
        ]);

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('account.profile')->with('success', 'Password changed successfully!');
    }
}
