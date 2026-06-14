@extends('Website.user.layouts.account')

@section('title', 'Dashboard - My Account')

@section('account_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}! Here's your account overview.</p>
    </div>

    <!-- Next Installment Date Banner -->
    @if($stats['next_installment_date'])
    <div class="bg-gradient-to-r {{ $stats['next_installment_date']->isPast() ? 'from-red-50 to-orange-50 border-red-200' : 'from-blue-50 to-indigo-50 border-blue-200' }} border rounded-xl shadow-sm p-5 mb-8">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 {{ $stats['next_installment_date']->isPast() ? 'bg-red-600' : 'bg-blue-600' }} rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-white text-lg"></i>
                </div>
                <div>
                    <p class="text-sm font-medium text-gray-600">Next Installment Due</p>
                    <h3 class="text-xl font-bold {{ $stats['next_installment_date']->isPast() ? 'text-red-600' : 'text-blue-700' }}">
                        {{ $stats['next_installment_date']->format('d M, Y') }}
                    </h3>
                </div>
            </div>
            @if($stats['next_installment_date']->isPast())
                <span class="inline-flex items-center gap-1 px-3 py-1.5 bg-red-100 text-red-700 rounded-full text-xs font-semibold">
                    <i class="fas fa-exclamation-circle"></i> Overdue
                </span>
            @else
                <span class="text-sm text-gray-500">{{ $stats['next_installment_date']->diffForHumans() }}</span>
            @endif
        </div>
    </div>
    @endif

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Bookings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-bookmark text-blue-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">Total</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_bookings'] }}</h3>
            <p class="text-sm text-gray-600">Total Bookings</p>
        </div>

        <!-- Total Plot Price -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-map text-indigo-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">Price</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['total_plot_price'], 0) }}</h3>
            <p class="text-sm text-gray-600">Total Plot Price</p>
        </div>

        <!-- Total Booking Payment -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-cyan-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hand-holding-usd text-cyan-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-cyan-600 bg-cyan-100 px-2 py-1 rounded-full">Booking</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['total_booking_payment'], 0) }}</h3>
            <p class="text-sm text-gray-600">Total Booking Payment</p>
        </div>

        <!-- Total Paid -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-check-circle text-green-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-green-600 bg-green-100 px-2 py-1 rounded-full">Paid</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['total_paid'], 0) }}</h3>
            <p class="text-sm text-gray-600">Total Paid Amount</p>
        </div>
    </div>

    <!-- Second Row Stats -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Installment Per Month -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-teal-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-money-bill-wave text-teal-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-teal-600 bg-teal-100 px-2 py-1 rounded-full">Installment</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['total_instalment_payment'], 0) }}</h3>
            <p class="text-sm text-gray-600">Installment Paid Amount</p>
        </div>

        <!-- Paid Installments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-calendar-check text-emerald-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">Paid</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['paid_installments'] }}</h3>
            <p class="text-sm text-gray-600">Installments Paid</p>
        </div>

        <!-- Pending Installments -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-hourglass-half text-orange-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-orange-600 bg-orange-100 px-2 py-1 rounded-full">Due</span>
            </div>
            <h3 class="text-3xl font-bold {{ $stats['pending_installments'] > 0 ? 'text-orange-600' : 'text-gray-900' }} mb-1">{{ $stats['pending_installments'] }}</h3>
            <p class="text-sm text-gray-600">Installments Due</p>
        </div>

        <!-- Total Due Amount -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-red-600 bg-red-100 px-2 py-1 rounded-full">Due</span>
            </div>
            <h3 class="text-2xl font-bold {{ $stats['total_instalment_due_amount'] > 0 ? 'text-red-600' : 'text-gray-900' }} mb-1">৳{{ format_bd_number($stats['total_instalment_due_amount'], 0) }}</h3>
            <p class="text-sm text-gray-600">Installment Due Amount</p>
        </div>
    </div>

    

    <!-- Recent Bookings -->
    <div>
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">Recent Bookings</h2>
                <a href="{{ route('account.bookings') }}" class="text-primary hover:text-primary-dark font-medium text-sm">
                    View All <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            @if($recentBookings->count() > 0)
                <div class="space-y-6">
                    @foreach($recentBookings as $booking)
                        <div class="border border-gray-200 rounded-xl overflow-hidden hover:shadow-md transition">
                            {{-- Header --}}
                            <div class="flex items-center justify-between px-5 py-4 bg-gray-50">
                                <div class="flex items-center space-x-4">
                                    <div class="w-12 h-12 bg-gradient-to-br from-primary to-primary-dark rounded-lg flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-map-marked-alt text-white"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">Plot #{{ $booking->plot->plot_no }}</h4>
                                        <p class="text-sm text-gray-600">{{ $booking->plot->size_katha }} Katha &bull; Block {{ $booking->plot->block }} &bull; Road {{ $booking->plot->road_no }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold
                                        @if($booking->status === 'confirmed' || $booking->status === 'approved') bg-green-100 text-green-700
                                        @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                        @elseif($booking->status === 'pre-booked') bg-blue-100 text-blue-700
                                        @else bg-red-100 text-red-700
                                        @endif">
                                        {{ ucfirst(str_replace('-', ' ', $booking->status)) }}
                                    </span>
                                    <p class="text-xs text-gray-500 mt-1">{{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}</p>
                                </div>
                            </div>

                            {{-- Details Grid --}}
                            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 divide-x divide-y lg:divide-y-0 divide-gray-100">
                                {{-- Plot Price --}}
                                <div class="px-4 py-3 text-center">
                                    <p class="text-xs text-gray-500 mb-1">Plot Price</p>
                                    <p class="text-sm font-bold text-gray-900">৳{{ format_bd_number($booking->price, 0) }}</p>
                                </div>

                                {{-- Booking Payment --}}
                                <div class="px-4 py-3 text-center">
                                    <p class="text-xs text-gray-500 mb-1">Booking Payment</p>
                                    <p class="text-sm font-bold text-gray-900">৳{{ format_bd_number($booking->display_booking_amount, 0) }}</p>
                                    @if($booking->custom_booking_amount)
                                        <p class="text-[10px] text-blue-600">(Custom)</p>
                                    @endif
                                </div>

                                {{-- Installment Payment --}}
                                <div class="px-4 py-3 text-center">
                                    <p class="text-xs text-gray-500 mb-1">Installment Amt</p>
                                    @if($booking->installment_payment)
                                        <p class="text-sm font-bold text-gray-900">@include('partials.installment-amount', ['adjusted' => $booking->adjusted_installment, 'original' => $booking->installment_payment, 'decimals' => 0])</p>
                                        <p class="text-[10px] text-gray-500">{{ ucfirst($booking->installment_plan ?? '') }}</p>
                                    @else
                                        <p class="text-sm font-semibold text-gray-400">N/A</p>
                                    @endif
                                </div>

                                {{-- Installments Paid --}}
                                <div class="px-4 py-3 text-center">
                                    <p class="text-xs text-gray-500 mb-1">Installments Paid</p>
                                    @if($booking->total_installments)
                                        <p class="text-sm font-bold text-green-600">{{ $booking->instalments_paid }} <span class="text-gray-400 font-normal">/ {{ $booking->total_installments }}</span></p>
                                    @else
                                        <p class="text-sm font-semibold text-gray-400">N/A</p>
                                    @endif
                                </div>

                                {{-- Installments Due --}}
                                <div class="px-4 py-3 text-center">
                                    <p class="text-xs text-gray-500 mb-1">Installments Due</p>
                                    @if($booking->total_installments)
                                        <p class="text-sm font-bold {{ $booking->instalments_due_qty > 0 ? 'text-orange-600' : 'text-green-600' }}">{{ $booking->instalments_due_qty }}</p>
                                    @else
                                        <p class="text-sm font-semibold text-gray-400">N/A</p>
                                    @endif
                                </div>

                                {{-- Installment Due Amount --}}
                                <div class="px-4 py-3 text-center">
                                    <p class="text-xs text-gray-500 mb-1">Due Amount</p>
                                    @if($booking->total_installments)
                                        <p class="text-sm font-bold {{ $booking->instalment_due_amount > 0 ? 'text-red-600' : 'text-green-600' }}">৳{{ format_bd_number($booking->instalment_due_amount, 0) }}</p>
                                    @else
                                        <p class="text-sm font-semibold text-gray-400">N/A</p>
                                    @endif
                                </div>
                            </div>

                            {{-- Pre-booking expiry notice --}}
                            @if($booking->status === 'pre-booked' && $booking->pre_booking_expires_at)
                                <div class="px-5 py-2 bg-blue-50 border-t border-blue-100 text-xs text-blue-700">
                                    <i class="fas fa-info-circle mr-1"></i>
                                    Pre-booking expires on <strong>{{ $booking->pre_booking_expires_at->format('M d, Y') }}</strong>
                                    ({{ $booking->pre_booking_expires_at->diffForHumans() }})
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-bookmark text-gray-400 text-2xl"></i>
                    </div>
                    <p class="text-gray-600 mb-4">No bookings yet</p>
                    <a href="{{ route('plots.index') }}" class="inline-flex items-center gap-2 px-6 py-2.5 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition">
                        <i class="fas fa-search"></i>
                        <span>Browse Plots</span>
                    </a>
                </div>
            @endif
        </div>
    </div>
@endsection
