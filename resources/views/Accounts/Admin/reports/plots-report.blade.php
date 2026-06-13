@extends('Accounts.Admin.reports.report-layout')

@section('title', 'Plots Report')
@section('report-title', 'Plots Report')

@section('content')
    <!-- Summary Section -->
    <div class="grid grid-cols-4 gap-3 mb-5">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Plots</div>
            <div class="text-xl font-bold text-gray-800">{{ $summary['total'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Available</div>
            <div class="text-xl font-bold text-green-600">{{ $summary['available'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Pending</div>
            <div class="text-xl font-bold text-yellow-600">{{ $summary['pending'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Booked</div>
            <div class="text-xl font-bold text-blue-600">{{ $summary['booked'] }}</div>
        </div>
    </div>

    <div class="grid grid-cols-3 gap-3 mb-5">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Value</div>
            <div class="text-lg font-bold text-gray-800">৳{{ format_bd_number($summary['total_value'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Average Price</div>
            <div class="text-lg font-bold text-gray-800">৳{{ format_bd_number($summary['avg_price'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Area</div>
            <div class="text-lg font-bold text-gray-800">{{ number_format($summary['total_area'], 2) }} Katha</div>
        </div>
    </div>

    <!-- Data Table -->
    @if($plots->count() > 0)
    <table class="w-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Plot No</th>
                <th>Title</th>
                <th>Block</th>
                <th>Road</th>
                <th>Facing</th>
                <th>Category</th>
                <th>Size (Katha)</th>
                <th>Price (৳)</th>
                <th>Booking Amt (৳)</th>
                <th>Installment Plan</th>
                <th>Status</th>
                <th>Date Added</th>
            </tr>
        </thead>
        <tbody>
            @foreach($plots as $index => $plot)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="font-semibold">{{ $plot->plot_no }}</td>
                <td>{{ $plot->title }}</td>
                <td>{{ $plot->block }}</td>
                <td>{{ $plot->road_no }}</td>
                <td>{{ $plot->facing }}</td>
                <td>{{ $plot->plot_category ?? '-' }}</td>
                <td class="text-right">{{ number_format($plot->size_katha, 2) }}</td>
                <td class="text-right">{{ format_bd_number($plot->price, 0) }}</td>
                <td class="text-right">{{ $plot->booking_payment ? format_bd_number($plot->booking_payment, 0) : '-' }}</td>
                <td>{{ $plot->installment_plan ? ucfirst($plot->installment_plan) . ' (' . $plot->total_installments . ')' : '-' }}</td>
                <td>
                    <span class="badge badge-{{ $plot->status }}">{{ ucfirst($plot->status) }}</span>
                </td>
                <td>{{ $plot->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-8 text-gray-500">
        <p class="text-lg">No plots found matching the selected filters.</p>
    </div>
    @endif
@endsection
