@extends('Website.commission.layouts.account')

@section('title', 'Plot Payment Details - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-6 flex items-center justify-between flex-wrap gap-3">
        <div>
            <a href="{{ route('commission.sales') }}" class="text-purple-600 hover:text-purple-800 text-sm font-medium inline-flex items-center gap-1 mb-2">
                <i class="fas fa-arrow-left"></i> Back to My Sales
            </a>
            <h1 class="text-3xl font-bold text-gray-900">Plot Payment Details</h1>
            <p class="text-gray-600 mt-1">Plot #{{ $booking->plot->plot_no }} &mdash; {{ $booking->user->name }}</p>
        </div>
        <span class="px-4 py-2 rounded-full text-sm font-semibold
            @if($booking->status === 'approved') bg-green-100 text-green-700
            @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
            @elseif($booking->status === 'pre-booked') bg-blue-100 text-blue-700
            @else bg-red-100 text-red-700
            @endif">
            {{ ucfirst($booking->status) }}
        </span>
    </div>

    <!-- Plot & Customer Info -->
    <div class="grid md:grid-cols-2 gap-6 mb-6">
        <!-- Plot Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-map-marked-alt text-purple-500"></i> Plot Information
            </h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Plot No.</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->plot->plot_no }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Block</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->plot->block }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Size</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->plot->size_katha }} Katha</dd>
                </div>
                @if($booking->plot->road_no)
                <div class="flex justify-between">
                    <dt class="text-gray-500">Road No.</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->plot->road_no }}</dd>
                </div>
                @endif
                <div class="flex justify-between">
                    <dt class="text-gray-500">Booked On</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->created_at->format('d M Y') }}</dd>
                </div>
            </dl>
        </div>

        <!-- Customer Info -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
                <i class="fas fa-user text-purple-500"></i> Customer Information
            </h2>
            <dl class="space-y-3 text-sm">
                <div class="flex justify-between">
                    <dt class="text-gray-500">Name</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->user->name }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Phone</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->user->phone ?? '—' }}</dd>
                </div>
                <div class="flex justify-between">
                    <dt class="text-gray-500">Email</dt>
                    <dd class="font-semibold text-gray-900">{{ $booking->user->email }}</dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Financial Summary Cards -->
    <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-6">
        <!-- Total Plot Price -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Plot Price</p>
            <p class="text-2xl font-bold text-gray-900">৳{{ format_bd_number($booking->price, 0) }}</p>
        </div>
        <!-- Total Paid -->
        <div class="bg-white rounded-xl shadow-sm border border-green-100 p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Total Paid</p>
            <p class="text-2xl font-bold text-green-600">৳{{ format_bd_number($totalPaid, 0) }}</p>
        </div>
        <!-- Outstanding Balance -->
        <div class="bg-white rounded-xl shadow-sm border {{ $outstandingBalance > 0 ? 'border-red-100' : 'border-gray-200' }} p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Outstanding Balance</p>
            <p class="text-2xl font-bold {{ $outstandingBalance > 0 ? 'text-red-600' : 'text-green-600' }}">
                ৳{{ format_bd_number($outstandingBalance, 0) }}
            </p>
        </div>
        <!-- Booking Payment -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5">
            <p class="text-xs text-gray-500 uppercase tracking-wide mb-1">Booking Advance Paid</p>
            <p class="text-2xl font-bold text-purple-600">৳{{ format_bd_number($bookingPayment, 0) }}</p>
        </div>
    </div>

    <!-- Installment Status -->
    @if($booking->installment_plan && $totalInstallments > 0)
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-6">
        <h2 class="text-lg font-bold text-gray-900 mb-2 flex items-center gap-2">
            <i class="fas fa-calendar-check text-purple-500"></i> Installment Plan
            <span class="ml-2 text-sm font-normal text-gray-500 capitalize">({{ $booking->installment_plan }})</span>
        </h2>

        <!-- Summary Chips -->
        <div class="flex flex-wrap gap-4 mb-5">
            <div class="bg-gray-50 border border-gray-200 rounded-lg px-4 py-3 text-center min-w-[110px]">
                <p class="text-xs text-gray-500">Total</p>
                <p class="text-xl font-bold text-gray-900">{{ $totalInstallments }}</p>
                <p class="text-xs text-gray-500">installments</p>
            </div>
            <div class="bg-green-50 border border-green-200 rounded-lg px-4 py-3 text-center min-w-[110px]">
                <p class="text-xs text-gray-500">Paid</p>
                <p class="text-xl font-bold text-green-600">{{ $paidInstallmentsCount }}</p>
                <p class="text-xs text-gray-500">installments</p>
            </div>
            <div class="bg-{{ $dueInstallments > 0 ? 'red' : 'gray' }}-50 border border-{{ $dueInstallments > 0 ? 'red' : 'gray' }}-200 rounded-lg px-4 py-3 text-center min-w-[110px]">
                <p class="text-xs text-gray-500">Due</p>
                <p class="text-xl font-bold text-{{ $dueInstallments > 0 ? 'red' : 'gray' }}-600">{{ $dueInstallments }}</p>
                <p class="text-xs text-gray-500">installments</p>
            </div>
            <div class="bg-{{ $dueAmount > 0 ? 'red' : 'gray' }}-50 border border-{{ $dueAmount > 0 ? 'red' : 'gray' }}-200 rounded-lg px-4 py-3 text-center min-w-[130px]">
                <p class="text-xs text-gray-500">Due Amount</p>
                <p class="text-xl font-bold text-{{ $dueAmount > 0 ? 'red' : 'gray' }}-600">৳{{ format_bd_number($dueAmount, 0) }}</p>
                <p class="text-xs text-gray-500">@include('partials.installment-amount', ['adjusted' => $booking->adjusted_installment, 'original' => $booking->installment_payment, 'decimals' => 0])/installment</p>
            </div>
        </div>

        @if($dueInstallments > 0)
        <div class="flex items-start gap-3 bg-red-50 border border-red-200 rounded-lg p-4 mb-5">
            <i class="fas fa-exclamation-triangle text-red-500 mt-0.5 flex-shrink-0"></i>
            <div>
                <p class="text-sm font-semibold text-red-700">{{ $dueInstallments }} installment(s) overdue</p>
                <p class="text-xs text-red-600 mt-0.5">Please follow up with the customer to clear outstanding installments totalling ৳{{ format_bd_number($dueAmount, 0) }}.</p>
            </div>
        </div>
        @endif

        <!-- Progress Bar -->
        @php $progress = $totalInstallments > 0 ? round(($paidInstallmentsCount / $totalInstallments) * 100) : 0; @endphp
        <div class="mb-5">
            <div class="flex justify-between text-xs text-gray-500 mb-1">
                <span>Payment Progress</span>
                <span>{{ $progress }}%</span>
            </div>
            <div class="w-full h-3 bg-gray-100 rounded-full overflow-hidden">
                <div class="h-3 rounded-full {{ $dueInstallments > 0 ? 'bg-gradient-to-r from-purple-500 to-red-400' : 'bg-gradient-to-r from-purple-500 to-green-500' }}" style="width: {{ $progress }}%"></div>
            </div>
        </div>

        <!-- Installment Breakdown Table -->
        @if(count($installmentRows) > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Installment #</th>
                        <th class="text-right px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                        <th class="text-center px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Status</th>
                        <th class="text-right px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Paid On</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($installmentRows as $row)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 font-medium text-gray-900">Installment {{ $row['number'] }}</td>
                        <td class="px-4 py-3 text-right text-gray-900">৳{{ format_bd_number($row['amount'], 0) }}</td>
                        <td class="px-4 py-3 text-center">
                            @if($row['paid'])
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                                    <i class="fas fa-check-circle"></i> Paid
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                                    <i class="fas fa-clock"></i> Due
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right text-gray-500 text-xs">
                            {{ $row['paid_on'] ? $row['paid_on']->format('d M Y') : '—' }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @endif
    </div>
    @endif

    <!-- Payment History -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-bold text-gray-900 mb-4 flex items-center gap-2">
            <i class="fas fa-history text-purple-500"></i> Payment History
        </h2>
        @if($booking->payments->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-200">
                        <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">#</th>
                        <th class="text-left px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="text-right px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Amount</th>
                        <th class="text-center px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Installments</th>
                        <th class="text-right px-4 py-2 text-xs font-semibold text-gray-500 uppercase">My Earning</th>
                        <th class="text-right px-4 py-2 text-xs font-semibold text-gray-500 uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($booking->payments->sortByDesc('created_at') as $index => $payment)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-500">{{ $index + 1 }}</td>
                        <td class="px-4 py-3">
                            @if($payment->payment_type === 'Booking Payment')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-blue-100 text-blue-700 text-xs font-semibold">
                                    <i class="fas fa-home"></i> Booking
                                </span>
                            @elseif($payment->payment_type === 'Installment Payment')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-purple-100 text-purple-700 text-xs font-semibold">
                                    <i class="fas fa-calendar-check"></i> Installment
                                </span>
                            @elseif($payment->payment_type === 'Part Of Installment')
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                                    <i class="fas fa-clock"></i> Part Of Installment
                                </span>
                            @else
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-gray-100 text-gray-700 text-xs font-semibold">
                                    {{ $payment->payment_type }}
                                </span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right font-semibold text-gray-900">৳{{ format_bd_number($payment->amount, 0) }}</td>
                        <td class="px-4 py-3 text-center text-gray-600">
                            {{ $payment->instalment_quantity ? $payment->instalment_quantity : '—' }}
                        </td>
                        <td class="px-4 py-3 text-right">
                            @if(isset($myEarnings[$payment->id]))
                                <span class="font-semibold text-purple-600">৳{{ format_bd_number($myEarnings[$payment->id]->amount, 2) }}</span>
                                <span class="text-xs text-gray-400 block">{{ rtrim(rtrim(number_format($myEarnings[$payment->id]->percentage, 2), '0'), '.') }}%</span>
                            @else
                                <span class="text-gray-400">—</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-right text-gray-500 text-xs">{{ $payment->created_at->format('d M Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                    <tr>
                        <td colspan="2" class="px-4 py-3 font-bold text-gray-900">Total Paid</td>
                        <td class="px-4 py-3 text-right font-bold text-green-600">৳{{ format_bd_number($totalPaid, 0) }}</td>
                        <td></td>
                        <td class="px-4 py-3 text-right font-bold text-purple-600">৳{{ format_bd_number($myEarnings->sum('amount'), 2) }}</td>
                        <td></td>
                    </tr>
                </tfoot>
            </table>
        </div>
        @else
            <div class="text-center py-8 text-gray-500">
                <i class="fas fa-receipt text-4xl text-gray-300 mb-3"></i>
                <p>No payments recorded yet.</p>
            </div>
        @endif
    </div>
@endsection
