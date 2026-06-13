@extends('Accounts.Admin.reports.report-layout')

@section('title', 'Bookings Report')
@section('report-title', 'Bookings Report')

@section('content')
    <!-- Summary Section -->
    <div class="grid grid-cols-4 gap-3 mb-4">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Bookings</div>
            <div class="text-xl font-bold text-gray-800">{{ $summary['total'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Approved</div>
            <div class="text-xl font-bold text-green-600">{{ $summary['approved'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Pending</div>
            <div class="text-xl font-bold text-yellow-600">{{ $summary['pending'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Pre-Booked</div>
            <div class="text-xl font-bold text-indigo-600">{{ $summary['pre_booked'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-4 gap-3 mb-5">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Cancelled</div>
            <div class="text-xl font-bold text-red-600">{{ $summary['cancelled'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Value</div>
            <div class="text-lg font-bold text-gray-800">৳{{ format_bd_number($summary['total_value'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Paid</div>
            <div class="text-lg font-bold text-green-600">৳{{ format_bd_number($summary['total_paid'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Due</div>
            <div class="text-lg font-bold text-red-600">৳{{ format_bd_number($summary['total_due'], 0) }}</div>
        </div>
    </div>

    <!-- Data Table -->
    @if($bookings->count() > 0)
    <table class="w-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Booking ID</th>
                <th>Plot No</th>
                <th>Customer</th>
                <th>Additional Owners</th>
                <th>Phone</th>
                <th>Agent</th>
                <th>Booking Date</th>
                <th>Total Price (৳)</th>
                <th>Paid (৳)</th>
                <th>Due (৳)</th>
                <th>Installment</th>
                <th>Status</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach($bookings as $index => $booking)
            @php
                $totalPaid = $booking->payments->sum('amount');
                $totalDue = $booking->price - $totalPaid;
            @endphp
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="font-semibold">#{{ $booking->id }}</td>
                <td>{{ $booking->plot->plot_no ?? 'N/A' }}</td>
                <td>{{ $booking->user->name ?? 'N/A' }}</td>
                <td>{{ count($booking->owners ?? []) }}</td>
                <td>{{ $booking->user->phone ?? 'N/A' }}</td>
                <td>{{ $booking->agent ? $booking->agent->name : '-' }}</td>
                <td>{{ $booking->booking_date ? $booking->booking_date->format('d M Y') : '-' }}</td>
                <td class="text-right">{{ format_bd_number($booking->price, 0) }}</td>
                <td class="text-right">{{ format_bd_number($totalPaid, 0) }}</td>
                <td class="text-right {{ $totalDue > 0 ? 'text-red-600 font-semibold' : 'text-green-600' }}">{{ format_bd_number($totalDue, 0) }}</td>
                <td>{{ $booking->installment_plan ? ucfirst($booking->installment_plan) : '-' }}</td>
                <td>
                    <span class="badge badge-{{ $booking->status }}">{{ ucfirst($booking->status) }}</span>
                </td>
                <td>{{ $booking->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-8 text-gray-500">
        <p class="text-lg">No bookings found matching the selected filters.</p>
    </div>
    @endif
@endsection
