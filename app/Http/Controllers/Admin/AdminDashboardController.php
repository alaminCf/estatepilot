<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Plot;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Defaults
        $totalPlots = 0;
        $bookedPlots = 0;
        $pendingPlots = 0;
        $availablePlots = 0;
        $totalCollections = 0;
        $pendingAmount = 0;
        $totalCustomers = 0;
        $totalAgents = 0;
        $pendingDocs = 0;
        $recentBookings = collect();
        $recentPayments = collect();
        $monthlyCollections = [];
        $monthlyPending = [];
        $monthLabels = [];
        $paidAmount = 0;
        $pendingPayments = 0;
        $overdueAmount = 0;

        // Plot stats - requires manage_plots
        if ($user->hasPermission('manage_plots')) {
            $totalPlots = Plot::count();
            $bookedPlots = Plot::where('status', 'booked')->count();
            $pendingPlots = Plot::where('status', 'pending')->count();
            $availablePlots = Plot::where('status', 'available')->count();
        }

        // Payment stats - requires manage_payments
        if ($user->hasPermission('manage_payments')) {
            $totalCollections = Payment::sum('amount');
            $pendingAmount = Booking::where('status', 'approved')->sum('remaining_payment');

            $recentPayments = Payment::with(['booking.plot', 'booking.user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();

            $paidAmount = $totalCollections;
            $pendingPayments = $pendingAmount;
            $overdueAmount = Booking::whereIn('status', ['confirmed', 'approved'])
                ->where('booking_date', '<', Carbon::now()->subDays(30))
                ->sum('remaining_payment');

            // Monthly chart data
            for ($i = 11; $i >= 0; $i--) {
                $startOfMonth = Carbon::now()->subMonthsNoOverflow($i)->startOfMonth();
                $endOfMonth = Carbon::now()->subMonthsNoOverflow($i)->endOfMonth();

                $monthlyCollections[] = Payment::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('amount');
                $monthlyPending[] = Booking::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->where('status', 'approved')
                    ->sum('remaining_payment');
                $monthLabels[] = $startOfMonth->format('M Y');
            }
        }

        // Customer stats - requires manage_customers
        if ($user->hasPermission('manage_customers')) {
            $totalCustomers = User::where('role', 'user')->count();
        }

        // Commission user stats - requires manage_commission_users
        if ($user->hasPermission('manage_commission_users')) {
            $totalAgents = User::where('role', 'agent')->count();
        }

        // Booking stats - requires manage_bookings
        if ($user->hasPermission('manage_bookings')) {
            $pendingDocs = Booking::where('status', 'pending')->count();

            $recentBookings = Booking::with(['plot', 'user'])
                ->orderBy('created_at', 'desc')
                ->limit(5)
                ->get();
        }
        
        return view('Accounts.Admin.dashboard', compact(
            'totalPlots',
            'bookedPlots',
            'pendingPlots',
            'availablePlots',
            'totalCollections',
            'pendingAmount',
            'totalCustomers',
            'totalAgents',
            'pendingDocs',
            'recentBookings',
            'recentPayments',
            'monthlyCollections',
            'monthlyPending',
            'monthLabels',
            'paidAmount',
            'pendingPayments',
            'overdueAmount'
        ));
    }
}
