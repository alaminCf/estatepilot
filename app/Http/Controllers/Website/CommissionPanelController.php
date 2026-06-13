<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\CommissionEarning;
use App\Models\CommissionPayout;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password as PasswordRule;

class CommissionPanelController extends Controller
{
    /**
     * Display the commission user dashboard with overview stats.
     */
    public function dashboard()
    {
        $user = Auth::user();
        $service = new CommissionService();

        $referredBookings = Booking::where('referral_agent_id', $user->id)->get();

        $earningsSummary = $service->earningsSummaryFor($user);
        $legacyCommission = $service->legacyCommissionFor($user);
        $totalPaid = $service->payoutTotalFor($user);
        $balance = $service->balanceFor($user);

        $stats = [
            'total_sales' => $referredBookings->count(),
            'approved_sales' => $referredBookings->where('status', 'approved')->count(),
            'pending_sales' => $referredBookings->where('status', 'pending')->count(),
            'team_size' => $user->children()->count(),
            'earned_own' => $earningsSummary['own'],
            'earned_override' => $earningsSummary['override'],
            'earned_total' => $earningsSummary['total'] + $legacyCommission,
            'legacy_commission' => $legacyCommission,
            'total_paid' => $totalPaid,
            'balance' => $balance,
        ];

        $recentEarnings = CommissionEarning::where('user_id', $user->id)
            ->with(['booking.plot', 'seller'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $recentPayouts = CommissionPayout::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('Website.commission.dashboard', compact('stats', 'recentEarnings', 'recentPayouts'));
    }

    /**
     * Display all own sales (referred bookings) with search/filter support.
     */
    public function sales(Request $request)
    {
        $user = Auth::user();
        $search = $request->get('search');
        $status = $request->get('status');

        $query = Booking::where('referral_agent_id', $user->id)
            ->with(['plot', 'user', 'payments'])
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('plot', function ($pq) use ($search) {
                    $pq->where('plot_no', 'like', "%{$search}%")
                        ->orWhere('block', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                })->orWhereHas('user', function ($uq) use ($search) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $bookings = $query->paginate(10)->withQueryString();

        // My earnings per booking on this page (own-sale ledger rows)
        $earningsByBooking = CommissionEarning::where('user_id', $user->id)
            ->whereIn('booking_id', $bookings->pluck('id'))
            ->selectRaw('booking_id, SUM(amount) as total')
            ->groupBy('booking_id')
            ->pluck('total', 'booking_id');

        return view('Website.commission.sales', compact('bookings', 'search', 'status', 'earningsByBooking'));
    }

    /**
     * Display detailed payment and installment status for a specific sale.
     */
    public function salePaymentDetail(Booking $booking)
    {
        $user = Auth::user();

        // Ensure this booking was sold by the authenticated commission user
        if ($booking->referral_agent_id !== $user->id) {
            abort(403, 'Unauthorized access to this booking.');
        }

        $booking->load(['plot', 'user', 'payments']);

        $totalPaid        = $booking->payments->sum('amount');
        $bookingPayment   = $booking->payments->where('payment_type', 'Booking Payment')->sum('amount');
        $installmentsPaid = $booking->payments->where('payment_type', 'Installment Payment');
        $paidInstallmentsCount = $installmentsPaid->sum('instalment_quantity') ?: $installmentsPaid->count();
        $totalInstallments     = $booking->total_installments ?? 0;
        $dueInstallments       = max(0, $totalInstallments - $paidInstallmentsCount);
        $dueAmount             = $dueInstallments * ($booking->installment_payment ?? 0);
        $outstandingBalance    = max(0, $booking->price - $totalPaid);

        // Build per-installment breakdown rows
        $installmentRows = [];
        if ($totalInstallments > 0) {
            $paidNumbers = [];
            foreach ($booking->payments->where('payment_type', 'Installment Payment') as $p) {
                $qty = $p->instalment_quantity ?? 1;
                for ($i = 0; $i < $qty; $i++) {
                    $paidNumbers[] = $p;
                }
            }
            for ($i = 1; $i <= $totalInstallments; $i++) {
                $paymentRecord = $paidNumbers[$i - 1] ?? null;
                $installmentRows[] = [
                    'number'  => $i,
                    'amount'  => $booking->installment_payment,
                    'paid'    => $paymentRecord !== null,
                    'paid_on' => $paymentRecord ? $paymentRecord->created_at : null,
                ];
            }
        }

        // My ledger rows on this booking, keyed by payment
        $myEarnings = CommissionEarning::where('user_id', $user->id)
            ->where('booking_id', $booking->id)
            ->get()
            ->keyBy('payment_id');

        return view('Website.commission.plot-payment-detail', compact(
            'booking', 'totalPaid', 'bookingPayment',
            'paidInstallmentsCount', 'totalInstallments', 'dueInstallments',
            'dueAmount', 'outstandingBalance', 'installmentRows', 'myEarnings'
        ));
    }

    /**
     * Display the earnings ledger with pool/date filters and legacy commission.
     */
    public function earnings(Request $request)
    {
        $user = Auth::user();
        $service = new CommissionService();

        $query = CommissionEarning::where('user_id', $user->id)
            ->with(['booking.plot', 'seller'])
            ->orderBy('created_at', 'desc');

        if ($request->pool_type) {
            $query->where('pool_type', $request->pool_type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $earnings = $query->paginate(15)->withQueryString();

        $summary = $service->earningsSummaryFor($user);

        // Legacy flat-rate commission per old booking (pre-hierarchy)
        $legacyBookings = Booking::where('referral_agent_id', $user->id)
            ->where('commission_scheme', '!=', 'hierarchy')
            ->whereIn('status', ['approved', 'pre-booked'])
            ->with(['plot', 'user', 'payments'])
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($booking) {
                $customerPaid = $booking->payments->sum('amount');
                $basePaid = $booking->agent_commission_base_paid ?? 0;
                $eligiblePaid = max(0, $customerPaid - $basePaid);
                $rate = $booking->agent_commission ?? 0;

                return [
                    'booking' => $booking,
                    'commission_rate' => $rate,
                    'customer_paid' => $eligiblePaid,
                    'commission' => ($eligiblePaid * $rate) / 100,
                ];
            });

        $legacyTotal = $service->legacyCommissionFor($user);

        return view('Website.commission.earnings', compact('earnings', 'summary', 'legacyBookings', 'legacyTotal'));
    }

    /**
     * Display the direct downline team.
     */
    public function team()
    {
        $user = Auth::user();

        $team = $user->children()
            ->withCount('referredBookings')
            ->orderBy('name')
            ->get();

        return view('Website.commission.team', compact('team'));
    }

    /**
     * Display all commission payouts received.
     */
    public function payouts()
    {
        $user = Auth::user();

        $paymentStats = [
            'total_received' => CommissionPayout::where('user_id', $user->id)->sum('amount'),
            'total_transactions' => CommissionPayout::where('user_id', $user->id)->count(),
            'this_month' => CommissionPayout::where('user_id', $user->id)
                ->whereMonth('created_at', now()->month)
                ->whereYear('created_at', now()->year)
                ->sum('amount'),
        ];

        $payments = CommissionPayout::where('user_id', $user->id)
            ->with(['booking.plot', 'booking.user'])
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('Website.commission.payouts', compact('payments', 'paymentStats'));
    }

    /**
     * Display the commission payout invoice.
     */
    public function payoutInvoice(CommissionPayout $commissionPayout)
    {
        // Ensure the payout belongs to the authenticated commission user
        if ($commissionPayout->user_id !== Auth::id()) {
            abort(403, 'Unauthorized access to this invoice.');
        }

        $commissionPayout->load(['user', 'booking.plot', 'booking.user', 'booking.payments']);

        return view('Website.commission.payout-invoice', compact('commissionPayout'));
    }

    /**
     * Display commission user profile.
     */
    public function profile()
    {
        return view('Website.commission.profile');
    }

    /**
     * Update commission user profile.
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'father_name' => ['nullable', 'string', 'max:255'],
            'mother_name' => ['nullable', 'string', 'max:255'],
            'nid' => ['nullable', 'string', 'max:50'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,jpg,png', 'max:2048'],
        ];

        // Only validate password if provided
        if ($request->filled('current_password')) {
            $rules['current_password'] = ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }];
            $rules['password'] = ['required', 'confirmed', PasswordRule::defaults()];
        }

        $validated = $request->validate($rules);

        // Update basic info
        $user->name = $validated['name'];
        $user->email = $validated['email'];
        if (isset($validated['phone'])) {
            $user->phone = $validated['phone'];
        }

        // Handle photo upload
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/agent'), $filename);
            $user->photo = 'uploads/agent/' . $filename;
        }

        // Update password if provided
        if ($request->filled('password')) {
            $user->password = Hash::make($validated['password']);
        }

        $user->save();

        return redirect()->route('commission.profile')->with('success', 'Profile updated successfully!');
    }
}
