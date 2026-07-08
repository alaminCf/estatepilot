<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionPayout;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Plot;
use App\Models\User;
use App\Models\WebsiteSetting;
use App\Services\CommissionService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    /**
     * Get company info from platform settings for report headers.
     */
    private function getCompanyInfo(): array
    {
        $contactSettings = WebsiteSetting::getGroup('contact');

        return [
            'site_name' => WebsiteSetting::get('site_name', 'London Abason Real Estate'),
            'site_logo' => WebsiteSetting::get('site_logo', ''),
            'phone' => $contactSettings['phone_primary'] ?? '',
            'email' => $contactSettings['contact_email'] ?? '',
            'address' => $contactSettings['office_address'] ?? '',
        ];
    }

    // ──────────────────────────────────────────────
    // PLOTS REPORT
    // ──────────────────────────────────────────────

    /**
     * Show plots report filter form.
     */
    public function plotsFilter()
    {
        $blocks = Plot::distinct()->pluck('block')->filter()->sort()->values();
        $roadNumbers = Plot::distinct()->pluck('road_no')->filter()->sort()->values();
        $facings = Plot::distinct()->pluck('facing')->filter()->sort()->values();
        $categories = Plot::distinct()->pluck('plot_category')->filter()->sort()->values();

        return view('Accounts.Admin.reports.plots-filter', compact('blocks', 'roadNumbers', 'facings', 'categories'));
    }

    /**
     * Generate plots report.
     */
    public function plotsReport(Request $request)
    {
        $query = Plot::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('block')) {
            $query->where('block', $request->block);
        }
        if ($request->filled('road_no')) {
            $query->where('road_no', $request->road_no);
        }
        if ($request->filled('facing')) {
            $query->where('facing', $request->facing);
        }
        if ($request->filled('plot_category')) {
            $query->where('plot_category', $request->plot_category);
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('size_min')) {
            $query->where('size_katha', '>=', $request->size_min);
        }
        if ($request->filled('size_max')) {
            $query->where('size_katha', '<=', $request->size_max);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('sort_by')) {
            $direction = $request->get('sort_direction', 'asc');
            $query->orderBy($request->sort_by, $direction);
        } else {
            $query->orderBy('plot_no', 'asc');
        }

        $plots = $query->get();
        $filters = $request->all();
        $company = $this->getCompanyInfo();

        $summary = [
            'total' => $plots->count(),
            'available' => $plots->where('status', 'available')->count(),
            'pending' => $plots->where('status', 'pending')->count(),
            'booked' => $plots->where('status', 'booked')->count(),
            'total_value' => $plots->sum('price'),
            'avg_price' => $plots->avg('price'),
            'total_area' => $plots->sum('size_katha'),
        ];

        return view('Accounts.Admin.reports.plots-report', compact('plots', 'filters', 'company', 'summary'));
    }

    // ──────────────────────────────────────────────
    // BOOKINGS REPORT
    // ──────────────────────────────────────────────

    /**
     * Show bookings report filter form.
     */
    public function bookingsFilter()
    {
        $agents = User::where('role', 'agent')->where('status', 'active')->orderBy('name')->get();
        $blocks = Plot::distinct()->pluck('block')->filter()->sort()->values();

        return view('Accounts.Admin.reports.bookings-filter', compact('agents', 'blocks'));
    }

    /**
     * Generate bookings report.
     */
    public function bookingsReport(Request $request)
    {
        $query = Booking::with(['plot', 'user', 'agent', 'payments']);

        if ($request->filled('client_id')) {
            $clientIdSearch = $request->client_id;
            $clientIdNum = null;
            if (preg_match('/^CID-0*(\d+)$/i', $clientIdSearch, $m)) {
                $clientIdNum = (int) $m[1];
            } elseif (is_numeric($clientIdSearch)) {
                $clientIdNum = (int) $clientIdSearch;
            }
            if ($clientIdNum !== null) {
                $query->whereHas('user', function ($q) use ($clientIdNum) {
                    $q->where('client_id', $clientIdNum);
                });
            }
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('referral_agent_id')) {
            $query->where('referral_agent_id', $request->referral_agent_id);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('booking_date', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('booking_date', '<=', $request->date_to);
        }
        if ($request->filled('created_from')) {
            $query->whereDate('created_at', '>=', $request->created_from);
        }
        if ($request->filled('created_to')) {
            $query->whereDate('created_at', '<=', $request->created_to);
        }
        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }
        if ($request->filled('block')) {
            $query->whereHas('plot', function ($q) use ($request) {
                $q->where('block', $request->block);
            });
        }
        if ($request->filled('installment_plan')) {
            $query->where('installment_plan', $request->installment_plan);
        }
        if ($request->filled('has_agent')) {
            if ($request->has_agent === 'yes') {
                $query->whereNotNull('referral_agent_id');
            } else {
                $query->whereNull('referral_agent_id');
            }
        }

        // Payment Status filter
        if ($request->filled('payment_status')) {
            if ($request->payment_status === 'due_installment_this_month') {
                $query->where('status', 'approved')
                    ->whereNotNull('installment_plan')
                    ->whereHas('payments', function ($q) {
                        $q->where('payment_type', 'Booking Payment');
                    })
                    ->whereRaw('price > (SELECT COALESCE(SUM(amount), 0) FROM payments WHERE payments.booking_id = bookings.id)');
            } elseif ($request->payment_status === 'due_booking_payment') {
                $query->whereDoesntHave('payments', function ($q) {
                    $q->where('payment_type', 'Booking Payment');
                });
            }
        }

        // Max Installment Paid: bookings with installment payment count <= given value
        if ($request->filled('max_installment_paid')) {
            $max = (int) $request->max_installment_paid;
            $query->withCount(['payments as installment_payments_count' => function ($q) {
                $q->where('payment_type', 'Installment Payment');
            }])->having('installment_payments_count', '<=', $max);
        }

        // Min Installment Paid: bookings with installment payment count >= given value
        if ($request->filled('min_installment_paid')) {
            $min = (int) $request->min_installment_paid;
            $query->withCount(['payments as installment_payments_count' => function ($q) {
                $q->where('payment_type', 'Installment Payment');
            }])->having('installment_payments_count', '>=', $min);
        }

        if ($request->filled('sort_by')) {
            $direction = $request->get('sort_direction', 'desc');
            $query->orderBy($request->sort_by, $direction);
        } else {
            $query->latest();
        }

        $bookings = $query->get();
        $filters = $request->all();
        $company = $this->getCompanyInfo();

        $summary = [
            'total' => $bookings->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'pre_booked' => $bookings->where('status', 'pre-booked')->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
            'total_value' => $bookings->sum('price'),
            'total_paid' => $bookings->sum(fn($b) => $b->payments->sum('amount')),
            'total_due' => $bookings->sum('price') - $bookings->sum(fn($b) => $b->payments->sum('amount')),
        ];

        return view('Accounts.Admin.reports.bookings-report', compact('bookings', 'filters', 'company', 'summary'));
    }

    // ──────────────────────────────────────────────
    // PAYMENTS REPORT
    // ──────────────────────────────────────────────

    /**
     * Show payments report filter form.
     */
    public function paymentsFilter()
    {
        return view('Accounts.Admin.reports.payments-filter');
    }

    /**
     * Generate payments report.
     */
    public function paymentsReport(Request $request)
    {
        $query = Payment::with(['booking.plot', 'booking.user', 'booking.agent']);

        if ($request->filled('client_id')) {
            $clientIdSearch = $request->client_id;
            $clientIdNum = null;
            if (preg_match('/^CID-0*(\d+)$/i', $clientIdSearch, $m)) {
                $clientIdNum = (int) $m[1];
            } elseif (is_numeric($clientIdSearch)) {
                $clientIdNum = (int) $clientIdSearch;
            }
            if ($clientIdNum !== null) {
                $query->whereHas('booking.user', function ($q) use ($clientIdNum) {
                    $q->where('client_id', $clientIdNum);
                });
            }
        }

        if ($request->filled('payment_type')) {
            $query->where('payment_type', $request->payment_type);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }
        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }
        if ($request->filled('plot_no')) {
            $query->whereHas('booking.plot', function ($q) use ($request) {
                $q->where('plot_no', 'like', '%' . $request->plot_no . '%');
            });
        }
        if ($request->filled('customer_search')) {
            $custSearch = $request->customer_search;
            $custClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $custSearch, $m)) {
                $custClientId = (int) $m[1];
            }
            $query->whereHas('booking.user', function ($q) use ($custSearch, $custClientId) {
                $q->where('name', 'like', '%' . $custSearch . '%')
                  ->orWhere('phone', 'like', '%' . $custSearch . '%');
                if ($custClientId !== null) {
                    $q->orWhere('client_id', $custClientId);
                }
            });
        }
        if ($request->filled('sort_by')) {
            $direction = $request->get('sort_direction', 'desc');
            $query->orderBy($request->sort_by, $direction);
        } else {
            $query->latest();
        }

        $payments = $query->get();
        $filters = $request->all();
        $company = $this->getCompanyInfo();

        $summary = [
            'total_count' => $payments->count(),
            'total_value' => $payments->unique('booking_id')->sum(fn($p) => optional($p->booking)->price),
            'total_amount' => $payments->sum('amount'),
            'booking_payments' => $payments->where('payment_type', 'Booking Payment')->sum('amount'),
            'booking_payments_count' => $payments->where('payment_type', 'Booking Payment')->count(),
            'down_payments' => $payments->where('payment_type', 'Down Payment')->sum('amount'),
            'down_payments_count' => $payments->where('payment_type', 'Down Payment')->count(),
            'installment_payments' => $payments->where('payment_type', 'Installment Payment')->sum('amount'),
            'installment_payments_count' => $payments->where('payment_type', 'Installment Payment')->count(),
            'part_payments' => $payments->where('payment_type', 'Part Of Installment')->sum('amount'),
            'part_payments_count' => $payments->where('payment_type', 'Part Of Installment')->count(),
        ];

        return view('Accounts.Admin.reports.payments-report', compact('payments', 'filters', 'company', 'summary'));
    }

    // ──────────────────────────────────────────────
    // AGENTS REPORT
    // ──────────────────────────────────────────────

    /**
     * Show agents report filter form.
     */
    public function agentsFilter()
    {
        $agents = User::where('role', 'agent')->orderBy('name')->get();

        return view('Accounts.Admin.reports.agents-filter', compact('agents'));
    }

    /**
     * Generate agents report.
     */
    public function agentsReport(Request $request)
    {
        $query = User::where('role', 'agent')
            ->with(['referredBookings.plot', 'referredBookings.payments', 'commissionPayouts']);

        if ($request->filled('agent_id')) {
            $query->where('id', $request->agent_id);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        if ($request->filled('commission_rate_min')) {
            $query->where('commission_rate', '>=', $request->commission_rate_min);
        }
        if ($request->filled('commission_rate_max')) {
            $query->where('commission_rate', '<=', $request->commission_rate_max);
        }
        if ($request->filled('min_bookings')) {
            $query->has('referredBookings', '>=', $request->min_bookings);
        }
        if ($request->filled('client_id')) {
            $query->whereHas('referredBookings', function ($q) use ($request) {
                $q->where('user_id', $request->client_id);
            });
        }
        if ($request->filled('sort_by')) {
            $direction = $request->get('sort_direction', 'asc');
            $query->orderBy($request->sort_by, $direction);
        } else {
            $query->orderBy('name', 'asc');
        }

        $agents = $query->get();

        // Commission earned per user, computed live from the commission chart so
        // flat-scheme bookings (which never generated ledger rows) also count.
        $commissionTotals = (new CommissionService())->chartCommissionTotals();

        // Apply booking date filter on agent bookings
        $bookingDateFrom = $request->filled('booking_date_from') ? $request->booking_date_from : null;
        $bookingDateTo = $request->filled('booking_date_to') ? $request->booking_date_to : null;
        $clientId = $request->filled('client_id') ? $request->client_id : null;

        $agents->each(function ($agent) use ($bookingDateFrom, $bookingDateTo, $clientId, $commissionTotals) {
            $bookings = $agent->referredBookings;

            if ($bookingDateFrom) {
                $bookings = $bookings->filter(fn($b) => $b->created_at->gte($bookingDateFrom));
            }
            if ($bookingDateTo) {
                $bookings = $bookings->filter(fn($b) => $b->created_at->lte($bookingDateTo . ' 23:59:59'));
            }
            if ($clientId) {
                $bookings = $bookings->filter(fn($b) => (int) $b->user_id === (int) $clientId);
            }

            $agent->filtered_bookings = $bookings;
            $agent->total_booking_value = $bookings->sum('price');
            $agent->total_earned_commission = $agent->commissionPayouts->sum('amount');
            $agent->total_commission = $commissionTotals[$agent->id] ?? 0;
            $agent->total_bookings_count = $bookings->count();
            $agent->approved_bookings = $bookings->where('status', 'approved')->count();
            $agent->pending_bookings = $bookings->where('status', 'pending')->count();
        });

        $filters = $request->all();
        $company = $this->getCompanyInfo();

        $summary = [
            'total_agents' => $agents->count(),
            'active_agents' => $agents->where('status', 'active')->count(),
            'inactive_agents' => $agents->where('status', '!=', 'active')->count(),
            'total_bookings' => $agents->sum('total_bookings_count'),
            'total_booking_value' => $agents->sum('total_booking_value'),
            'total_commission_value' => $agents->sum('total_commission'),
            'total_commission_paid' => $agents->sum('total_earned_commission'),
        ];

        return view('Accounts.Admin.reports.agents-report', compact('agents', 'filters', 'company', 'summary'));
    }
}
