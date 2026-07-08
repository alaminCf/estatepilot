@extends('Accounts.Admin.reports.report-layout')

@section('title', 'Commission Report')
@section('report-title', 'Commission Report')

@section('content')
    <!-- Summary Section -->
    <div class="grid grid-cols-3 gap-3 mb-4">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Agents</div>
            <div class="text-xl font-bold text-gray-800">{{ $summary['total_agents'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Active Agents</div>
            <div class="text-xl font-bold text-green-600">{{ $summary['active_agents'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Inactive Agents</div>
            <div class="text-xl font-bold text-red-600">{{ $summary['inactive_agents'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-3 mb-5">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Bookings Referred</div>
            <div class="text-xl font-bold text-gray-800">{{ $summary['total_bookings'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Booking Value</div>
            <div class="text-lg font-bold text-blue-600">৳{{ format_bd_number($summary['total_booking_value'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Commission Value</div>
            <div class="text-lg font-bold text-green-700">৳{{ format_bd_number($summary['total_commission_value'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Commission Paid</div>
            <div class="text-lg font-bold text-green-600">৳{{ format_bd_number($summary['total_commission_paid'], 0) }}</div>
        </div>
    </div>

    <!-- Data Table -->
    @if($agents->count() > 0)
    <table class="w-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Agent Name</th>
                <th>Phone</th>
                <th>Email</th>
                <th>Referral Code</th>
                <th>Total Bookings</th>
                <th>Approved</th>
                <th>Pending</th>
                <th>Booking Value (৳)</th>
                <th>Commission (৳)</th>
                <th>Commission Paid (৳)</th>
                <th>Status</th>
                <th>Joined</th>
            </tr>
        </thead>
        <tbody>
            @foreach($agents as $index => $agent)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="font-semibold">{{ $agent->name }}</td>
                <td>{{ $agent->phone ?? 'N/A' }}</td>
                <td>{{ $agent->email }}</td>
                <td>{{ $agent->referral_code ?? '-' }}</td>
                <td class="text-center font-semibold">{{ $agent->total_bookings_count }}</td>
                <td class="text-center text-green-600">{{ $agent->approved_bookings }}</td>
                <td class="text-center text-yellow-600">{{ $agent->pending_bookings }}</td>
                <td class="text-right">{{ format_bd_number($agent->total_booking_value, 0) }}</td>
                <td class="text-right font-semibold text-green-700">{{ format_bd_number($agent->total_commission, 0) }}</td>
                <td class="text-right font-semibold text-green-700">{{ format_bd_number($agent->total_earned_commission, 0) }}</td>
                <td>
                    <span class="badge badge-{{ $agent->status }}">{{ ucfirst($agent->status) }}</span>
                </td>
                <td>{{ $agent->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Per-Agent Booking Details (if single agent selected) -->
    @if($agents->count() == 1)
        @php $singleAgent = $agents->first(); @endphp
        @if($singleAgent->filtered_bookings->count() > 0)
        <div class="mt-6">
            <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-300 pb-1 mb-3">Booking Details for {{ $singleAgent->name }}</h3>
            <table class="w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Booking ID</th>
                        <th>Plot No</th>
                        <th>Customer</th>
                        <th>Price (৳)</th>
                        <th>Paid (৳)</th>
                        <th>Due (৳)</th>
                        <th>Commission (৳)</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @php $commissionService = new \App\Services\CommissionService(); @endphp
                    @foreach($singleAgent->filtered_bookings as $bIndex => $booking)
                    @php
                        $paid = $booking->payments->sum('amount');
                        $due = $booking->price - $paid;
                        $bookingCommission = $commissionService->chartCommissionForBooking($booking, $singleAgent->id);
                    @endphp
                    <tr>
                        <td>{{ $bIndex + 1 }}</td>
                        <td>#{{ $booking->id }}</td>
                        <td>{{ $booking->plot->plot_no ?? 'N/A' }}</td>
                        <td>{{ $booking->user->name ?? 'N/A' }}</td>
                        <td class="text-right">{{ format_bd_number($booking->price, 0) }}</td>
                        <td class="text-right">{{ format_bd_number($paid, 0) }}</td>
                        <td class="text-right {{ $due > 0 ? 'text-red-600' : 'text-green-600' }}">{{ format_bd_number($due, 0) }}</td>
                        <td class="text-right font-semibold text-green-700">{{ format_bd_number($bookingCommission, 0) }}</td>
                        <td><span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span></td>
                        <td>{{ $booking->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    @endif
    @else
    <div class="text-center py-8 text-gray-500">
        <p class="text-lg">No agents found matching the selected filters.</p>
    </div>
    @endif
@endsection
