@extends('Accounts.Admin.reports.report-layout')

@section('title', 'Payments Report')
@section('report-title', 'Payments Report')

@section('content')
    <!-- Summary Section -->
    <div class="grid grid-cols-4 gap-3 mb-4">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Payments</div>
            <div class="text-xl font-bold text-gray-800">{{ $summary['total_count'] }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Total Amount</div>
            <div class="text-lg font-bold text-green-600">৳{{ format_bd_number($summary['total_amount'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Booking Payments ({{ $summary['booking_payments_count'] }})</div>
            <div class="text-lg font-bold text-blue-600">৳{{ format_bd_number($summary['booking_payments'], 0) }}</div>
        </div>
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Installment ({{ $summary['installment_payments_count'] }})</div>
            <div class="text-lg font-bold text-yellow-600">৳{{ format_bd_number($summary['installment_payments'], 0) }}</div>
        </div>
    </div>

    @if($summary['part_payments_count'] > 0)
    <div class="grid grid-cols-4 gap-3 mb-5">
        <div class="summary-box text-center">
            <div class="text-gray-500 text-xs">Part Payments ({{ $summary['part_payments_count'] }})</div>
            <div class="text-lg font-bold text-purple-600">৳{{ format_bd_number($summary['part_payments'], 0) }}</div>
        </div>
    </div>
    @endif

    <!-- Data Table -->
    @if($payments->count() > 0)
    <table class="w-full">
        <thead>
            <tr>
                <th>#</th>
                <th>Payment ID</th>
                <th>Plot No</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Payment Type</th>
                <th>Amount (৳)</th>
                <th>Installment Qty</th>
                <th>Note</th>
                <th>Agent</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td class="font-semibold">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</td>
                <td>{{ $payment->booking->plot->plot_no ?? 'N/A' }}</td>
                <td>{{ $payment->booking->user->name ?? 'N/A' }}</td>
                <td>{{ $payment->booking->user->phone ?? 'N/A' }}</td>
                <td>
                    @if($payment->payment_type == 'Booking Payment')
                        <span class="badge" style="background:#dbeafe;color:#1e40af;">Booking</span>
                    @elseif($payment->payment_type == 'Installment Payment')
                        <span class="badge" style="background:#fef9c3;color:#854d0e;">Installment</span>
                    @else
                        <span class="badge" style="background:#f3e8ff;color:#6b21a8;">Part Payment</span>
                    @endif
                </td>
                <td class="text-right font-semibold">{{ format_bd_number($payment->amount, 0) }}</td>
                <td class="text-center">{{ $payment->instalment_quantity ?? '-' }}</td>
                <td>{{ $payment->payment_note ? \Illuminate\Support\Str::limit($payment->payment_note, 30) : '-' }}</td>
                <td>{{ $payment->booking->agent->name ?? '-' }}</td>
                <td>{{ $payment->created_at->format('d M Y') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    @else
    <div class="text-center py-8 text-gray-500">
        <p class="text-lg">No payments found matching the selected filters.</p>
    </div>
    @endif
@endsection
