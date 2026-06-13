@extends('Website.commission.layouts.account')

@section('title', 'My Payouts - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Payouts</h1>
        <p class="text-gray-600">Track all commission payouts you've received</p>
    </div>

    <!-- Payment Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($paymentStats['total_received'], 2) }}</h3>
            <p class="text-sm text-gray-600">Total Received</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-receipt text-blue-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $paymentStats['total_transactions'] }}</h3>
            <p class="text-sm text-gray-600">Total Transactions</p>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-purple-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($paymentStats['this_month'], 2) }}</h3>
            <p class="text-sm text-gray-600">This Month</p>
        </div>
    </div>

    <!-- Payments List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Payment History</h2>
                    <p class="text-sm text-gray-600 mt-1">{{ $payments->total() }} total payment(s)</p>
                </div>
            </div>
        </div>

        @if($payments->count() > 0)
            <!-- Desktop Table View -->
            <div class="hidden md:block overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Booking</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Note</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($payments as $payment)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center text-sm text-gray-900">
                                        <i class="far fa-calendar text-gray-400 mr-2"></i>
                                        {{ $payment->created_at->format('M d, Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">{{ $payment->created_at->format('h:i A') }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    @if($payment->booking)
                                        <div class="text-sm font-semibold text-gray-900">Plot #{{ $payment->booking->plot->plot_no ?? 'N/A' }}</div>
                                        <div class="text-xs text-gray-500">Booking #{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</div>
                                    @else
                                        <div class="text-sm text-gray-500">Balance payout</div>
                                    @endif
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-medium text-gray-900">{{ $payment->booking->user->name ?? '—' }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-lg font-bold text-green-600">৳{{ format_bd_number($payment->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600 max-w-xs truncate">{{ $payment->payment_note ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('commission.payouts.invoice', $payment->id) }}" class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700 hover:bg-purple-200 transition">
                                        <i class="fas fa-file-invoice mr-1"></i> Invoice
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Mobile Card View -->
            <div class="md:hidden divide-y divide-gray-200">
                @foreach($payments as $payment)
                    <div class="p-4 hover:bg-gray-50 transition">
                        <div class="flex items-start justify-between mb-3">
                            <div>
                                <div class="font-semibold text-gray-900 mb-1">{{ $payment->booking ? 'Plot #' . ($payment->booking->plot->plot_no ?? 'N/A') : 'Balance payout' }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y • h:i A') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-green-600">৳{{ format_bd_number($payment->amount, 2) }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <div class="text-sm text-gray-600">{{ $payment->booking->user->name ?? '' }}</div>
                            <a href="{{ route('commission.payouts.invoice', $payment->id) }}" class="inline-flex items-center px-2 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-700">
                                <i class="fas fa-file-invoice mr-1"></i> Invoice
                            </a>
                        </div>
                        @if($payment->payment_note)
                            <div class="mt-2 text-sm text-gray-600 bg-gray-50 rounded p-2">
                                {{ $payment->payment_note }}
                            </div>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="p-6 border-t border-gray-200">
                {{ $payments->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-wallet text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Payouts Yet</h3>
                <p class="text-gray-600 mb-6">You haven't received any commission payouts yet. Keep selling!</p>
                <a href="{{ route('commission.earnings') }}"
                   class="inline-flex items-center gap-2 px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors duration-300">
                    <i class="fas fa-coins"></i>
                    <span>View Earnings</span>
                </a>
            </div>
        @endif
    </div>
@endsection
