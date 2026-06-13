@extends('Website.commission.layouts.account')

@section('title', 'Dashboard - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">Dashboard</h1>
        <p class="text-gray-600">Welcome back, {{ auth()->user()->name }}!{{ auth()->user()->commission_type ? ' You are signed in as ' . auth()->user()->commissionTypeLabel() . '.' : '' }}</p>
    </div>

    <!-- Referral Code Share Box -->
    <div class="bg-gradient-to-r from-purple-600 to-purple-800 rounded-xl shadow-lg p-6 mb-8 text-white">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-2xl font-bold mb-1">Share Your Referral Code</h2>
                <p class="text-purple-100 text-sm">Customers can use this code when booking to credit the sale to you</p>
            </div>
            <div class="flex items-center gap-3">
                <div class="bg-white/20 border-2 border-white/30 rounded-lg px-6 py-3">
                    <span class="text-2xl font-bold text-white tracking-widest" id="referralCode">{{ auth()->user()->referral_code }}</span>
                </div>
                <button onclick="copyReferralCode()" class="px-4 py-3 bg-white text-purple-600 hover:bg-purple-50 rounded-lg font-semibold transition">
                    <i class="fas fa-copy"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Total Sales -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-handshake text-blue-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-blue-600 bg-blue-100 px-2 py-1 rounded-full">{{ $stats['approved_sales'] }} approved</span>
            </div>
            <h3 class="text-3xl font-bold text-gray-900 mb-1">{{ $stats['total_sales'] }}</h3>
            <p class="text-sm text-gray-600">My Sales</p>
        </div>

        <!-- Earned from own sales -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-coins text-purple-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-purple-600 bg-purple-100 px-2 py-1 rounded-full">Own Sales</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['earned_own'], 2) }}</h3>
            <p class="text-sm text-gray-600">Earned from My Sales</p>
        </div>

        <!-- Earned from team overrides -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-sitemap text-indigo-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-indigo-600 bg-indigo-100 px-2 py-1 rounded-full">{{ $stats['team_size'] }} in team</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['earned_override'], 2) }}</h3>
            <p class="text-sm text-gray-600">Earned from Team Sales</p>
        </div>

        <!-- Received -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 hover:shadow-md transition">
            <div class="flex items-center justify-between mb-4">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                    <i class="fas fa-wallet text-emerald-600 text-xl"></i>
                </div>
                <span class="text-xs font-semibold text-emerald-600 bg-emerald-100 px-2 py-1 rounded-full">Received</span>
            </div>
            <h3 class="text-2xl font-bold text-gray-900 mb-1">৳{{ format_bd_number($stats['total_paid'], 2) }}</h3>
            <p class="text-sm text-gray-600">Payouts Received</p>
        </div>
    </div>

    @if($stats['legacy_commission'] > 0)
    <!-- Legacy Commission Banner -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-8">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
            <div>
                <h2 class="text-xl font-bold text-gray-900 mb-1">Legacy Commission</h2>
                <p class="text-gray-600 text-sm">Commission from your bookings made under the previous flat-rate system. Included in your total balance.</p>
            </div>
            <div class="text-3xl font-bold text-amber-600">৳{{ format_bd_number($stats['legacy_commission'], 2) }}</div>
        </div>
    </div>
    @endif

    <!-- Balance Due Alert -->
    @if($stats['balance'] > 0)
    <div class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-200 rounded-xl shadow-sm p-6 mb-8">
        <div class="flex items-center gap-4">
            <div class="w-16 h-16 bg-orange-100 rounded-full flex items-center justify-center flex-shrink-0">
                <i class="fas fa-hand-holding-usd text-orange-600 text-2xl"></i>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900 mb-1">Pending Balance</h2>
                <p class="text-gray-600 text-sm">Total earned ৳{{ format_bd_number($stats['earned_total'], 2) }} — received ৳{{ format_bd_number($stats['total_paid'], 2) }}</p>
            </div>
            <div class="text-right">
                <p class="text-3xl font-bold text-orange-600">৳{{ format_bd_number($stats['balance'], 2) }}</p>
                <a href="{{ route('commission.earnings') }}" class="text-sm text-orange-600 hover:underline font-medium">View Details →</a>
            </div>
        </div>
    </div>
    @endif

    <div class="grid lg:grid-cols-2 gap-6">
        <!-- Recent Earnings -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Recent Earnings</h2>
                    <a href="{{ route('commission.earnings') }}" class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentEarnings->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentEarnings as $earning)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 {{ $earning->isOwnSale() ? 'bg-purple-100' : 'bg-indigo-100' }} rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas {{ $earning->isOwnSale() ? 'fa-handshake text-purple-600' : 'fa-sitemap text-indigo-600' }}"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">৳{{ format_bd_number($earning->amount, 2) }}</h4>
                                        <p class="text-sm text-gray-600">
                                            {{ ucfirst($earning->pool_type) }} • {{ $earning->isOwnSale() ? 'My sale' : 'Team sale by ' . ($earning->seller->name ?? 'N/A') }} • {{ $earning->created_at->format('M d, Y') }}
                                        </p>
                                    </div>
                                </div>
                                <span class="text-purple-600 font-semibold">{{ rtrim(rtrim(number_format($earning->percentage, 2), '0'), '.') }}%</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-coins text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">No earnings yet</p>
                        <p class="text-sm text-gray-400">Earnings appear when payments are recorded on your sales</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Payouts -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200">
            <div class="p-6 border-b border-gray-200">
                <div class="flex items-center justify-between">
                    <h2 class="text-xl font-bold text-gray-900">Recent Payouts</h2>
                    <a href="{{ route('commission.payouts') }}" class="text-purple-600 hover:text-purple-800 font-medium text-sm">
                        View All <i class="fas fa-arrow-right ml-1"></i>
                    </a>
                </div>
            </div>
            <div class="p-6">
                @if($recentPayouts->count() > 0)
                    <div class="space-y-4">
                        @foreach($recentPayouts as $payout)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                <div class="flex items-center space-x-4">
                                    <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                                        <i class="fas fa-check text-green-600"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-semibold text-gray-900">৳{{ format_bd_number($payout->amount, 2) }}</h4>
                                        <p class="text-sm text-gray-600">{{ $payout->created_at->format('M d, Y') }}</p>
                                    </div>
                                </div>
                                <span class="text-green-600 font-semibold">Received</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-wallet text-gray-400 text-2xl"></i>
                        </div>
                        <p class="text-gray-500">No payouts received yet</p>
                        <p class="text-sm text-gray-400">Commission payouts will appear here</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <script>
        function copyReferralCode() {
            const code = document.getElementById('referralCode').innerText;
            navigator.clipboard.writeText(code).then(() => {
                alert('Referral code copied to clipboard!');
            });
        }
    </script>
@endsection
