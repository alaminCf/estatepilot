<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionPayout;
use App\Models\User;
use App\Services\CommissionService;
use App\Services\EmailService;
use App\Services\SmsService;
use Illuminate\Http\Request;

class CommissionPayoutController extends Controller
{
    /**
     * Export commission payouts to CSV.
     */
    public function export(Request $request)
    {
        $payouts = $this->filteredQuery($request)->get();

        $filename = 'commission_payouts_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($payouts) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Payout ID',
                'Name',
                'Type',
                'Referral Code',
                'Phone',
                'Booking Ref',
                'Amount',
                'Payout Date',
                'Notes',
            ]);

            foreach ($payouts as $payout) {
                fputcsv($file, [
                    $payout->id,
                    $payout->user->name ?? 'N/A',
                    $payout->user?->commissionTypeLabel() ?? 'N/A',
                    $payout->user->referral_code ?? 'N/A',
                    $payout->user->phone ?? 'N/A',
                    $payout->booking_id ? '#' . $payout->booking_id : '-',
                    number_format($payout->amount, 2, '.', ''),
                    $payout->created_at->format('Y-m-d'),
                    $payout->payment_note ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Display a listing of commission payouts.
     */
    public function index(Request $request)
    {
        $perPage = $request->per_page ?? 25;
        $payouts = $this->filteredQuery($request)->paginate($perPage)->appends($request->except('page'));

        // Commission users for the filter dropdown
        $commissionUsers = User::commissionUsers()->where('status', 'active')->orderBy('name')->get();

        return view('Accounts.Admin.commission-payouts.index', compact('payouts', 'commissionUsers'));
    }

    /**
     * Show the form for creating a new commission payout.
     */
    public function create(Request $request)
    {
        // Commission users with any earnings/legacy activity can receive payouts
        $commissionUsers = User::commissionUsers()
            ->where('status', 'active')
            ->orderBy('name')
            ->get();

        $selectedUserId = $request->user_id;

        return view('Accounts.Admin.commission-payouts.create', compact('commissionUsers', 'selectedUserId'));
    }

    /**
     * AJAX: balance breakdown for a commission user.
     */
    public function balance(User $user)
    {
        $service = new CommissionService();

        $summary = $service->earningsSummaryFor($user);
        $legacy = $service->legacyCommissionFor($user);
        $paid = $service->payoutTotalFor($user);
        $balance = $service->balanceFor($user);

        return response()->json([
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'type' => $user->commissionTypeLabel(),
                'referral_code' => $user->referral_code,
            ],
            'earnings' => $summary,
            'legacy' => $legacy,
            'total_earned' => round($summary['total'] + $legacy, 2),
            'total_paid' => $paid,
            'balance' => $balance,
        ]);
    }

    /**
     * Store a newly created commission payout.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'payment_note' => 'nullable|string',
        ]);

        $user = User::findOrFail($validated['user_id']);

        if (! $user->isCommissionUser()) {
            return back()->withErrors(['user_id' => 'The selected user is not a commission user.'])->withInput();
        }

        // Block paying more than the accrued balance
        $balance = (new CommissionService())->balanceFor($user);
        if ($validated['amount'] > $balance + 0.01) {
            return back()->withErrors([
                'amount' => 'Amount (৳' . number_format($validated['amount'], 2) . ') exceeds the outstanding balance (৳' . number_format($balance, 2) . ').',
            ])->withInput();
        }

        $payout = CommissionPayout::create($validated);

        // Send SMS to the commission user
        if ($user->phone) {
            $smsService = new SmsService();
            $message = "Dear {$user->name}, your commission payout of ৳" . number_format($validated['amount'], 2) .
                       " has been processed. Thank you! - " . site_legal_name();

            try {
                $smsService->send($user->phone, $message);
            } catch (\Exception $e) {
                \Log::error('Failed to send SMS to commission user', [
                    'user_id' => $user->id,
                    'payout_id' => $payout->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        // Send email with invoice link
        if ($user->email) {
            try {
                $payout->load(['user', 'booking.plot', 'booking.user']);
                $emailService = new EmailService();
                $emailService->sendCommissionPayoutEmail($payout, $user);
            } catch (\Exception $e) {
                \Log::error('Failed to send commission payout email', [
                    'user_id' => $user->id,
                    'payout_id' => $payout->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('admin.commission-payouts.index')->with('success', 'Commission payout recorded successfully.');
    }

    /**
     * Remove the specified commission payout.
     */
    public function destroy(CommissionPayout $commissionPayout)
    {
        $commissionPayout->delete();

        return redirect()->route('admin.commission-payouts.index')->with('success', 'Commission payout deleted successfully.');
    }

    /**
     * Base query with shared index/export filters.
     */
    private function filteredQuery(Request $request)
    {
        $query = CommissionPayout::with(['user', 'booking.plot', 'booking.user'])->latest();

        if ($request->search) {
            $query->whereHas('user', function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('referral_code', 'like', '%' . $request->search . '%');
            });
        }

        if ($request->user_id) {
            $query->where('user_id', $request->user_id);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        return $query;
    }
}
