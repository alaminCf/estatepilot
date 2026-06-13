@extends('Website.commission.layouts.account')

@section('title', 'My Sales - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Sales</h1>
        <p class="text-gray-600">View all bookings made with your referral code</p>
    </div>

    <!-- Search & Filter Bar -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-5 mb-6">
        <form method="GET" action="{{ route('commission.sales') }}" class="flex flex-col sm:flex-row gap-3">
            <div class="flex-1 relative">
                <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                    <i class="fas fa-search"></i>
                </span>
                <input
                    type="text"
                    name="search"
                    value="{{ $search ?? '' }}"
                    placeholder="Search by plot no, block, or customer name…"
                    class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                />
            </div>
            <div class="sm:w-44">
                <select name="status" class="w-full px-3 py-2 border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-purple-500">
                    <option value="">All Statuses</option>
                    <option value="pending"     {{ ($status ?? '') === 'pending'     ? 'selected' : '' }}>Pending</option>
                    <option value="pre-booked"  {{ ($status ?? '') === 'pre-booked'  ? 'selected' : '' }}>Pre-Booked</option>
                    <option value="approved"    {{ ($status ?? '') === 'approved'    ? 'selected' : '' }}>Approved</option>
                    <option value="rejected"    {{ ($status ?? '') === 'rejected'    ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="px-5 py-2 bg-purple-600 text-white rounded-lg text-sm font-semibold hover:bg-purple-700 transition flex items-center gap-2">
                <i class="fas fa-search"></i> Search
            </button>
            @if($search || $status)
                <a href="{{ route('commission.sales') }}" class="px-4 py-2 border border-gray-300 text-gray-600 rounded-lg text-sm font-semibold hover:bg-gray-50 transition flex items-center gap-2">
                    <i class="fas fa-times"></i> Clear
                </a>
            @endif
        </form>
        @if($search || $status)
            <p class="text-xs text-gray-500 mt-2">
                Showing {{ $bookings->total() }} result(s)
                @if($search) for "<strong>{{ $search }}</strong>"@endif
                @if($status) with status "<strong>{{ ucfirst($status) }}</strong>"@endif
            </p>
        @endif
    </div>

    <!-- Bookings List -->
    @if($bookings->count() > 0)
        <div class="space-y-6">
            @foreach($bookings as $booking)
                <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
                    <div class="p-6">
                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                            <!-- Left: Plot & Customer Details -->
                            <div class="flex-1">
                                <div class="flex items-start gap-4">
                                    <!-- Plot Image/Placeholder -->
                                    <div class="w-20 h-20 rounded-lg bg-gradient-to-br from-purple-500 to-purple-700 flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                                    </div>
                                    
                                    <!-- Info -->
                                    <div class="flex-1">
                                        <div class="flex items-center gap-3 mb-2">
                                            <h3 class="text-xl font-bold text-gray-900">Plot #{{ $booking->plot->plot_no }}</h3>
                                            <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                @if($booking->status === 'approved') bg-green-100 text-green-700
                                                @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                                @elseif($booking->status === 'pre-booked') bg-blue-100 text-blue-700
                                                @else bg-red-100 text-red-700
                                                @endif">
                                                {{ ucfirst($booking->status) }}
                                            </span>
                                        </div>
                                        
                                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3 text-sm mb-3">
                                            <div>
                                                <span class="text-gray-500">Size:</span>
                                                <span class="font-semibold text-gray-900 ml-1">{{ $booking->plot->size_katha }} Katha</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Block:</span>
                                                <span class="font-semibold text-gray-900 ml-1">{{ $booking->plot->block }}</span>
                                            </div>
                                            <div>
                                                <span class="text-gray-500">Price:</span>
                                                <span class="font-semibold text-gray-900 ml-1">৳{{ format_bd_number($booking->price, 0) }}</span>
                                            </div>
                                        </div>

                                        <!-- Customer Info -->
                                        <div class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg">
                                            <div class="w-10 h-10 bg-purple-100 rounded-full flex items-center justify-center">
                                                <span class="text-purple-600 font-bold">{{ strtoupper(substr($booking->user->name, 0, 1)) }}</span>
                                            </div>
                                            <div>
                                                <p class="font-semibold text-gray-900">{{ $booking->user->name }}</p>
                                                <p class="text-sm text-gray-600">{{ $booking->user->phone ?? $booking->user->email }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Right: Payment & Commission Info -->
                            <div class="lg:text-right flex-shrink-0 lg:w-48">
                                @php
                                    $customerPaid = $booking->payments->sum('amount');
                                    if ($booking->isHierarchyScheme()) {
                                        $commission = $earningsByBooking[$booking->id] ?? 0;
                                        $commissionLabel = 'Your Earnings';
                                    } else {
                                        $basePaid = $booking->agent_commission_base_paid ?? 0;
                                        $eligiblePaid = max(0, $customerPaid - $basePaid);
                                        $commissionRate = $booking->agent_commission ?? 0;
                                        $commission = ($eligiblePaid * $commissionRate) / 100;
                                        $commissionLabel = 'Your Commission (' . rtrim(rtrim(number_format($commissionRate, 2), '0'), '.') . '%)';
                                    }
                                @endphp
                                <div class="space-y-2">
                                    <div>
                                        <p class="text-xs text-gray-500">Customer Paid</p>
                                        <p class="text-lg font-bold text-gray-900">৳{{ format_bd_number($customerPaid, 0) }}</p>
                                    </div>
                                    @if($booking->status === 'approved' || $commission > 0)
                                    <div class="pt-2 border-t border-gray-200">
                                        <p class="text-xs text-gray-500">{{ $commissionLabel }}</p>
                                        <p class="text-xl font-bold text-purple-600">৳{{ format_bd_number($commission, 2) }}</p>
                                    </div>
                                    @endif
                                </div>
                                <p class="text-xs text-gray-400 mt-3">
                                    <i class="far fa-calendar mr-1"></i>
                                    {{ $booking->created_at->format('M d, Y') }}
                                </p>
                                <a href="{{ route('commission.sales.payment-detail', $booking) }}"
                                   class="mt-3 inline-flex items-center gap-1 px-4 py-2 bg-purple-600 text-white text-xs font-semibold rounded-lg hover:bg-purple-700 transition">
                                    <i class="fas fa-file-invoice-dollar"></i> Payment Details
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        @if($bookings->hasPages())
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @endif
    @else
        <!-- Empty State -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
            <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-gray-400 text-4xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Sales Yet</h3>
            <p class="text-gray-600 mb-6">Share your referral code with customers to start earning commissions!</p>
            <div class="inline-flex items-center gap-3 bg-purple-50 border-2 border-dashed border-purple-300 rounded-lg px-6 py-4">
                <span class="text-sm text-gray-600">Your Code:</span>
                <span class="text-2xl font-bold text-purple-600 tracking-widest">{{ auth()->user()->referral_code }}</span>
            </div>
        </div>
    @endif
@endsection
