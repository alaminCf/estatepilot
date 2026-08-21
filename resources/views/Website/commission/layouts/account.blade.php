@extends('Website.layouts.app')

@section('title', 'Commission User Panel - ' . site_name())

@section('content')
    @php
        $commissionBalance = (new \App\Services\CommissionService())->balanceFor(auth()->user());
    @endphp
    <!-- Account Container -->
    <div class="pt-20 min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Navigation -->
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                        <!-- Account Header -->
                        <div class="bg-gradient-to-r from-purple-600 to-purple-800 p-6 text-white">
                            <div class="flex items-center space-x-3">
                                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-white/30 flex-shrink-0">
                                    <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg">{{ auth()->user()->name }}</h3>
                                    @if(auth()->user()->commission_type)
                                        <span class="inline-block mt-1 px-2 py-0.5 bg-white/20 border border-white/30 rounded-full text-xs font-bold">{{ auth()->user()->commissionTypeLabel() }}</span>
                                    @else
                                        <p class="text-xs text-purple-100">{{ auth()->user()->phone ?? 'No phone number' }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="mt-4 bg-white/10 rounded-lg px-3 py-2 flex items-center justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="text-xs text-purple-100">Your Balance</p>
                                    <p class="font-bold text-xl leading-tight truncate">৳{{ format_bd_number($commissionBalance, 2) }}</p>
                                </div>
                                <span class="w-9 h-9 rounded-full bg-white/15 flex items-center justify-center flex-shrink-0">
                                    <i class="fas fa-wallet text-white"></i>
                                </span>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="p-4">
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('commission.dashboard') }}"
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('commission.dashboard') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-th-large w-5"></i>
                                        <span class="font-medium">Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('commission.sales') }}"
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('commission.sales') || request()->routeIs('commission.sales.payment-detail') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-bookmark w-5"></i>
                                        <span class="font-medium">My Sales</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('commission.earnings') }}"
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('commission.earnings') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-percentage w-5"></i>
                                        <span class="font-medium">My Earnings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('commission.team') }}"
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('commission.team') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-users w-5"></i>
                                        <span class="font-medium">My Team</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('commission.payouts') }}"
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('commission.payouts') || request()->routeIs('commission.payouts.invoice') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-wallet w-5"></i>
                                        <span class="font-medium">My Payouts</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('commission.profile') }}"
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('commission.profile') ? 'bg-purple-600 text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-user-circle w-5"></i>
                                        <span class="font-medium">My Profile</span>
                                    </a>
                                </li>
                            </ul>

                            <hr class="my-4 border-gray-200">

                            <div class="px-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center space-x-3 px-4 py-3 rounded-lg border-2 border-purple-600 text-purple-600 hover:bg-purple-600 hover:text-white transition font-semibold">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <main class="flex-1">
                    @yield('commission_content')
                </main>
            </div>
        </div>
    </div>
@endsection
