@extends('Website.commission.layouts.account')

@section('title', 'My Earnings - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Earnings</h1>
        <p class="text-gray-600">Every commission you earned — from your own sales and from your team's sales.</p>
    </div>

    <!-- Pool Summary Cards -->
    <div class="grid md:grid-cols-3 gap-6 mb-8">
        @foreach(['booking' => ['Booking Money', 'fa-file-signature', 'blue'], 'down' => ['Down Payment', 'fa-money-check-alt', 'emerald'], 'instalment' => ['Instalments', 'fa-calendar-check', 'purple']] as $poolKey => [$label, $icon, $color])
        @php $pool = $summary['pools'][$poolKey] ?? ['own' => 0, 'override' => 0, 'total' => 0]; @endphp
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-{{ $color }}-100 rounded-lg flex items-center justify-center">
                    <i class="fas {{ $icon }} text-{{ $color }}-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-{{ $color }}-600 bg-{{ $color }}-100 px-2 py-1 rounded-full">{{ config('commission.pools.' . $poolKey) }}% pool</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($pool['total'], 2) }}</h3>
            <p class="text-sm text-gray-600">{{ $label }}</p>
            <p class="text-xs text-gray-400 mt-1">Own: ৳{{ format_bd_number($pool['own'], 2) }} • Team: ৳{{ format_bd_number($pool['override'], 2) }}</p>
        </div>
        @endforeach
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 mb-6">
        <form method="GET" action="{{ route('commission.earnings') }}" class="flex flex-wrap items-center gap-3">
            <select name="pool_type" class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-purple-500 focus:border-purple-500">
                <option value="">All Pools</option>
                <option value="booking" {{ request('pool_type') == 'booking' ? 'selected' : '' }}>Booking Money</option>
                <option value="down" {{ request('pool_type') == 'down' ? 'selected' : '' }}>Down Payment</option>
                <option value="instalment" {{ request('pool_type') == 'instalment' ? 'selected' : '' }}>Instalment</option>
            </select>
            <input type="date" name="date_from" value="{{ request('date_from') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <input type="date" name="date_to" value="{{ request('date_to') }}" class="border border-gray-300 rounded-lg px-3 py-2 text-sm">
            <button type="submit" class="px-4 py-2 bg-purple-600 text-white rounded-lg text-sm font-semibold hover:bg-purple-700 transition">Filter</button>
            @if(request()->hasAny(['pool_type', 'date_from', 'date_to']))
                <a href="{{ route('commission.earnings') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-50 transition">Clear</a>
            @endif
        </form>
    </div>

    <!-- Earnings Table -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 mb-8">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Earnings Ledger</h2>
        </div>
        @if($earnings->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pool</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Source</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Share</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($earnings as $earning)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $earning->created_at->format('M d, Y') }}</td>
                        <td class="px-6 py-4 text-sm">
                            <span class="font-medium text-gray-900">#{{ str_pad($earning->booking_id, 5, '0', STR_PAD_LEFT) }}</span>
                            @if($earning->booking && $earning->booking->plot)
                                <span class="text-gray-500">• Plot {{ $earning->booking->plot->plot_no }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                @if($earning->pool_type === 'booking') bg-blue-100 text-blue-700
                                @elseif($earning->pool_type === 'down') bg-emerald-100 text-emerald-700
                                @else bg-purple-100 text-purple-700
                                @endif">
                                {{ ucfirst($earning->pool_type) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm">
                            @if($earning->isOwnSale())
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">My sale</span>
                            @else
                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-full text-xs font-semibold">Team — {{ $earning->seller->name ?? 'N/A' }}</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-right text-gray-600">{{ rtrim(rtrim(number_format($earning->percentage, 2), '0'), '.') }}%</td>
                        <td class="px-6 py-4 text-sm text-right font-bold text-green-600">৳{{ format_bd_number($earning->amount, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="p-6 border-t border-gray-200">
            {{ $earnings->links() }}
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-coins text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">No earnings found</p>
            <p class="text-sm text-gray-400">Earnings appear when payments are recorded on your sales or your team's sales</p>
        </div>
        @endif
    </div>

    <!-- Legacy Commission (old flat-rate bookings) -->
    @if($legacyBookings->count() > 0)
    <div class="bg-white rounded-xl shadow-sm border border-amber-200">
        <div class="p-6 border-b border-amber-200 bg-amber-50 rounded-t-xl">
            <div class="flex items-center justify-between">
                <div>
                    <h2 class="text-xl font-bold text-gray-900">Legacy Commission</h2>
                    <p class="text-sm text-gray-600">Bookings made under the previous flat-rate system</p>
                </div>
                <div class="text-2xl font-bold text-amber-600">৳{{ format_bd_number($legacyTotal, 2) }}</div>
            </div>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Booking</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Customer</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Rate</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Customer Paid</th>
                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Commission</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($legacyBookings as $row)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm">
                            <span class="font-medium text-gray-900">#{{ str_pad($row['booking']->id, 5, '0', STR_PAD_LEFT) }}</span>
                            <span class="text-gray-500">• Plot {{ $row['booking']->plot->plot_no ?? 'N/A' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $row['booking']->user->name ?? 'N/A' }}</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-600">{{ rtrim(rtrim(number_format($row['commission_rate'], 2), '0'), '.') }}%</td>
                        <td class="px-6 py-4 text-sm text-right text-gray-600">৳{{ format_bd_number($row['customer_paid'], 2) }}</td>
                        <td class="px-6 py-4 text-sm text-right font-bold text-amber-600">৳{{ format_bd_number($row['commission'], 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
@endsection
