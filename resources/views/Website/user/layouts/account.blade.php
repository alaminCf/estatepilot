@extends('Website.layouts.app')

@section('title', 'My Account - London Abason')

@section('content')
    <!-- Account Container -->
    <div class="pt-20 min-h-screen bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="flex flex-col lg:flex-row gap-6">
                <!-- Sidebar Navigation -->
                <aside class="lg:w-64 flex-shrink-0">
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden sticky top-24">
                        <!-- Account Header -->
                        <div class="bg-gradient-to-r from-primary to-primary-dark p-6 text-white">
                            <div class="flex items-center space-x-3">
                                <div class="w-14 h-14 rounded-full overflow-hidden border-2 border-white/30 flex-shrink-0">
                                    <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <h3 class="font-semibold text-lg">{{ auth()->user()->name }}</h3>
                                    <p class="text-xs text-green-100">{{ auth()->user()->formatted_client_id ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>

                        <!-- Navigation Menu -->
                        <nav class="p-4">
                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('account.dashboard') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('account.dashboard') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-th-large w-5"></i>
                                        <span class="font-medium">Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('account.bookings') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('account.bookings') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-bookmark w-5"></i>
                                        <span class="font-medium">My Bookings</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('account.payments') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('account.payments') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-credit-card w-5"></i>
                                        <span class="font-medium">My Payments</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('account.profile') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg transition {{ request()->routeIs('account.profile') ? 'bg-primary text-white' : 'text-gray-700 hover:bg-gray-100' }}">
                                        <i class="fas fa-user-circle w-5"></i>
                                        <span class="font-medium">My Profile</span>
                                    </a>
                                </li>
                            </ul>

                            <hr class="my-4 border-gray-200">

                            <ul class="space-y-1">
                                <li>
                                    <a href="{{ route('plots.index') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                        <i class="fas fa-map-marked-alt w-5"></i>
                                        <span class="font-medium">Browse Plots</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ route('contact') }}" 
                                       class="flex items-center space-x-3 px-4 py-3 rounded-lg text-gray-700 hover:bg-gray-100 transition">
                                        <i class="fas fa-headset w-5"></i>
                                        <span class="font-medium">Get Support</span>
                                    </a>
                                </li>
                            </ul>

                            <hr class="my-4 border-gray-200">

                            <div class="px-2">
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center justify-center space-x-3 px-4 py-3 rounded-lg border-2 border-primary text-primary hover:bg-primary hover:text-white transition font-semibold">
                                        <i class="fas fa-sign-out-alt"></i>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </nav>
                        </nav>
                    </div>
                </aside>

                <!-- Main Content Area -->
                <main class="flex-1">
                    @yield('account_content')
                </main>
            </div>
        </div>
    </div>
@endsection
