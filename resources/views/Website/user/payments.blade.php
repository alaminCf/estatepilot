@extends('Website.user.layouts.account')

@section('title', 'My Payments - ' . site_name())

@section('account_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Payments</h1>
        <p class="text-gray-600">Track all your payment transactions</p>
    </div>

    <!-- Payment Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-3">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($paymentStats['total_paid'], 2) }}</h3>
            <p class="text-sm text-gray-600">Total Paid</p>
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
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-orange-600 text-xl"></i>
                </div>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">{{ $paymentStats['this_month'] }}</h3>
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
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Plot</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Payment Type</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Amount</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">Note</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">Invoice</th>
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
                                    <div class="text-sm font-semibold text-gray-900">Plot #{{ $payment->booking->plot->plot_no }}</div>
                                    <div class="text-xs text-gray-500">Block {{ $payment->booking->plot->block }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($payment->payment_type === 'Booking Payment') bg-blue-100 text-blue-700
                                        @elseif($payment->payment_type === 'Down Payment') bg-green-100 text-green-700
                                        @elseif($payment->payment_type === 'Installment Payment') bg-purple-100 text-purple-700
                                        @elseif($payment->payment_type === 'Part Of Installment') bg-amber-100 text-amber-700
                                        @else bg-gray-100 text-gray-700
                                        @endif">
                                        {{ $payment->payment_type }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-lg font-bold text-primary">৳{{ format_bd_number($payment->amount, 2) }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm text-gray-600">{{ $payment->payment_note ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <a href="{{ route('account.payments.invoice', $payment->id) }}" target="_blank"
                                       class="inline-flex items-center justify-center w-10 h-10 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-lg transition-all duration-200"
                                       title="View Invoice">
                                        <i class="fas fa-file-invoice text-lg"></i>
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
                                <div class="font-semibold text-gray-900 mb-1">Plot #{{ $payment->booking->plot->plot_no }}</div>
                                <div class="text-xs text-gray-500">{{ $payment->created_at->format('M d, Y • h:i A') }}</div>
                            </div>
                            <div class="text-right">
                                <div class="text-lg font-bold text-primary">৳{{ format_bd_number($payment->amount, 2) }}</div>
                            </div>
                        </div>
                        <div class="flex items-center justify-between">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                @if($payment->payment_type === 'Booking Payment') bg-blue-100 text-blue-700
                                @elseif($payment->payment_type === 'Installment Payment') bg-purple-100 text-purple-700
                                @elseif($payment->payment_type === 'Part Of Installment') bg-amber-100 text-amber-700
                                @else bg-gray-100 text-gray-700
                                @endif">
                                {{ $payment->payment_type }}
                            </span>
                            <a href="{{ route('account.payments.invoice', $payment->id) }}" target="_blank"
                               class="inline-flex items-center gap-1 px-3 py-1.5 bg-primary/10 hover:bg-primary text-primary hover:text-white rounded-lg text-sm font-medium transition-all duration-200">
                                <i class="fas fa-file-invoice"></i>
                                <span>Invoice</span>
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
                    <i class="fas fa-credit-card text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Payments Yet</h3>
                <p class="text-gray-600 mb-6">You haven't made any payments yet. Book a plot to get started!</p>
                <a href="{{ route('plots.index') }}" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition-colors duration-300">
                    <i class="fas fa-search"></i>
                    <span>Browse Plots</span>
                </a>
            </div>
        @endif
    </div>
@endsection
