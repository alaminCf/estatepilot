<?php

namespace App\Services;

use App\Models\Booking;
use App\Models\CommissionEarning;
use App\Models\CommissionPayout;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\Log;

class CommissionService
{
    /**
     * Maximum chain length when walking parents (cycle guard).
     */
    private const MAX_CHAIN_DEPTH = 10;

    /**
     * Resolve the commission pool for a payment type, or null if the type
     * does not participate in commission distribution.
     */
    public function poolForPaymentType(string $paymentType): ?string
    {
        return config("commission.payment_type_pools.{$paymentType}");
    }

    /**
     * The seller followed by their uplines, bottom → top: [seller, parent, grandparent, ...].
     *
     * @return User[]
     */
    public function uplineChain(User $seller): array
    {
        $chain = [$seller];
        $seen = [$seller->id => true];
        $current = $seller;

        while ($current->parent_id && count($chain) < self::MAX_CHAIN_DEPTH) {
            $current = $current->parent;

            if (! $current || isset($seen[$current->id])) {
                break;
            }

            $chain[] = $current;
            $seen[$current->id] = true;
        }

        return $chain;
    }

    /**
     * A user's override percentage for a pool: their stored value,
     * falling back to the chart default for their commission type.
     */
    public function overrideFor(User $user, string $poolType): float
    {
        $column = [
            'booking' => 'booking_pct',
            'down' => 'down_pct',
            'instalment' => 'instalment_pct',
        ][$poolType];

        $stored = $user->{$column};

        if ($stored !== null) {
            return (float) $stored;
        }

        return (float) config("commission.types.{$user->commission_type}.defaults.{$poolType}", 0);
    }

    /**
     * Pure distribution math for one payment amount on one pool.
     *
     * The seller receives pool − sum(upline overrides); each upline receives
     * their own override percentage.
     *
     * @return array<int, array{user_id:int, level:int, beneficiary_type:string, percentage:float, amount:float}>
     */
    public function computeDistribution(User $seller, string $poolType, float $amount): array
    {
        $poolRate = (float) config("commission.pools.{$poolType}", 0);
        $chain = $this->uplineChain($seller);
        $uplines = array_slice($chain, 1);

        $uplineTotal = 0.0;
        $rows = [];

        foreach ($uplines as $index => $upline) {
            $pct = $this->overrideFor($upline, $poolType);
            $uplineTotal += $pct;

            $rows[] = [
                'user_id' => $upline->id,
                'level' => $index + 1,
                'beneficiary_type' => $upline->commission_type,
                'percentage' => round($pct, 2),
                'amount' => round($amount * $pct / 100, 2),
            ];
        }

        $sellerPct = $poolRate - $uplineTotal;

        if ($sellerPct < 0) {
            Log::warning('Commission overrides exceed pool; seller share clamped to 0', [
                'seller_id' => $seller->id,
                'pool_type' => $poolType,
                'pool_rate' => $poolRate,
                'upline_total' => $uplineTotal,
            ]);
            $sellerPct = 0.0;
        }

        array_unshift($rows, [
            'user_id' => $seller->id,
            'level' => 0,
            'beneficiary_type' => $seller->commission_type,
            'percentage' => round($sellerPct, 2),
            'amount' => round($amount * $sellerPct / 100, 2),
        ]);

        return $rows;
    }

    /**
     * Write ledger rows for a customer payment. Call inside the caller's
     * transaction, after any custom created_at has been persisted.
     *
     * No-op for flat-scheme bookings, bookings without a seller, sellers
     * without a commission type, and payment types outside the chart.
     */
    public function recordEarningsForPayment(Payment $payment): void
    {
        $booking = $payment->booking;

        if (! $booking || $booking->isFlatScheme()) {
            return;
        }

        $seller = $booking->seller;

        if (! $seller || ! $seller->commission_type) {
            return;
        }

        $poolType = $this->poolForPaymentType($payment->payment_type);

        if (! $poolType) {
            return;
        }

        $poolRate = (float) config("commission.pools.{$poolType}", 0);
        $rows = $this->computeDistribution($seller, $poolType, (float) $payment->amount);

        foreach ($rows as $row) {
            CommissionEarning::create($row + [
                'payment_id' => $payment->id,
                'booking_id' => $booking->id,
                'seller_id' => $seller->id,
                'pool_type' => $poolType,
                'pool_rate' => $poolRate,
                // Mirror the payment date so date-filtered reports align
                'created_at' => $payment->created_at,
            ]);
        }
    }

    /**
     * Remove the ledger rows for a payment (FK cascade is the backstop).
     */
    public function reverseEarningsForPayment(Payment $payment): void
    {
        CommissionEarning::where('payment_id', $payment->id)->delete();
    }

    /**
     * Earnings totals for panels and payout forms.
     *
     * @return array{total:float, own:float, override:float, pools:array<string, array{own:float, override:float, total:float}>}
     */
    public function earningsSummaryFor(User $user): array
    {
        $grouped = CommissionEarning::where('user_id', $user->id)
            ->selectRaw('pool_type, SUM(CASE WHEN level = 0 THEN amount ELSE 0 END) as own, SUM(CASE WHEN level > 0 THEN amount ELSE 0 END) as override_amount')
            ->groupBy('pool_type')
            ->get();

        $pools = [];
        $own = 0.0;
        $override = 0.0;

        foreach ($grouped as $row) {
            $pools[$row->pool_type] = [
                'own' => (float) $row->own,
                'override' => (float) $row->override_amount,
                'total' => (float) $row->own + (float) $row->override_amount,
            ];
            $own += (float) $row->own;
            $override += (float) $row->override_amount;
        }

        return [
            'total' => $own + $override,
            'own' => $own,
            'override' => $override,
            'pools' => $pools,
        ];
    }

    /**
     * Legacy flat commission across the user's old (flat-scheme) bookings.
     * Exact copy of the original agent formula: (paid − base) × rate / 100.
     */
    public function legacyCommissionFor(User $user): float
    {
        $bookings = $user->referredBookings()
            ->where('commission_scheme', '!=', 'hierarchy')
            ->whereIn('status', ['approved', 'pre-booked'])
            ->with('payments')
            ->get();

        $total = 0.0;

        foreach ($bookings as $booking) {
            $customerPaid = (float) $booking->payments->sum('amount');
            $basePaid = (float) ($booking->agent_commission_base_paid ?? 0);
            $eligiblePaid = max(0, $customerPaid - $basePaid);
            $rate = (float) ($booking->agent_commission ?? 0);
            $total += ($eligiblePaid * $rate) / 100;
        }

        return round($total, 2);
    }

    /**
     * Commission earned by every user, computed live from the commission chart
     * across all qualifying bookings and payments — regardless of whether the
     * booking was recorded under the flat or hierarchy scheme.
     *
     * For every customer payment that maps to a pool, the seller's own share and
     * each upline's override are distributed per their current commission setting.
     * This unifies flat-scheme bookings (which never generated ledger rows) with
     * hierarchy-scheme bookings, so a commission user's earnings reflect their
     * settings applied to the paid balance.
     *
     * @return array<int, float> Map of user_id => total commission earned.
     */
    public function chartCommissionTotals(array $statuses = ['approved', 'pre-booked']): array
    {
        $totals = [];

        Booking::whereNotNull('referral_agent_id')
            ->whereIn('status', $statuses)
            ->with(['seller', 'payments'])
            ->chunk(200, function ($bookings) use (&$totals) {
                foreach ($bookings as $booking) {
                    $seller = $booking->seller;

                    if (! $seller || ! $seller->commission_type) {
                        continue;
                    }

                    foreach ($booking->payments as $payment) {
                        $poolType = $this->poolForPaymentType($payment->payment_type);

                        if (! $poolType) {
                            continue;
                        }

                        foreach ($this->computeDistribution($seller, $poolType, (float) $payment->amount) as $row) {
                            $totals[$row['user_id']] = round(($totals[$row['user_id']] ?? 0) + $row['amount'], 2);
                        }
                    }
                }
            });

        return $totals;
    }

    /**
     * Commission a single user earns from one booking, computed live from the
     * chart across that booking's pool-mapped payments. Returns 0 for bookings
     * outside the eligible statuses or without a commission-type seller.
     */
    public function chartCommissionForBooking(Booking $booking, int $userId, array $statuses = ['approved', 'pre-booked']): float
    {
        if (! in_array($booking->status, $statuses, true)) {
            return 0.0;
        }

        $seller = $booking->seller;

        if (! $seller || ! $seller->commission_type) {
            return 0.0;
        }

        $total = 0.0;

        foreach ($booking->payments as $payment) {
            $poolType = $this->poolForPaymentType($payment->payment_type);

            if (! $poolType) {
                continue;
            }

            foreach ($this->computeDistribution($seller, $poolType, (float) $payment->amount) as $row) {
                if ($row['user_id'] === $userId) {
                    $total += $row['amount'];
                }
            }
        }

        return round($total, 2);
    }

    /**
     * Total payouts made to a user.
     */
    public function payoutTotalFor(User $user): float
    {
        return (float) CommissionPayout::where('user_id', $user->id)->sum('amount');
    }

    /**
     * Outstanding balance: hierarchy earnings + legacy commission − payouts.
     */
    public function balanceFor(User $user): float
    {
        $earned = $this->earningsSummaryFor($user)['total'] + $this->legacyCommissionFor($user);

        return round($earned - $this->payoutTotalFor($user), 2);
    }
}
