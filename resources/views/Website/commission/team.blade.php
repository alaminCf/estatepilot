@extends('Website.commission.layouts.account')

@section('title', 'My Team - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Team</h1>
        <p class="text-gray-600">Commission users directly under you. You earn an override on every sale they make.</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200">
        <div class="p-6 border-b border-gray-200">
            <h2 class="text-xl font-bold text-gray-900">Direct Downline ({{ $team->count() }})</h2>
        </div>
        @if($team->count() > 0)
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Referral Code</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Sales</th>
                        <th class="px-6 py-3 text-center text-xs font-semibold text-gray-500 uppercase">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach($team as $member)
                    <tr class="hover:bg-gray-50">
                        <td class="px-6 py-4">
                            <div class="flex items-center space-x-3">
                                <div class="w-10 h-10 rounded-full overflow-hidden bg-purple-100 flex items-center justify-center flex-shrink-0">
                                    @if($member->photo)
                                        <img src="{{ $member->profile_image_url }}" alt="{{ $member->name }}" class="w-full h-full object-cover">
                                    @else
                                        <span class="text-purple-600 font-bold text-sm">{{ strtoupper(substr($member->name, 0, 1)) }}</span>
                                    @endif
                                </div>
                                <div>
                                    <h4 class="font-semibold text-gray-900">{{ $member->name }}</h4>
                                    <p class="text-sm text-gray-500">{{ $member->phone ?? '' }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">{{ $member->commissionTypeLabel() ?? 'Unassigned' }}</span>
                        </td>
                        <td class="px-6 py-4 text-sm font-medium text-gray-900 tracking-wider">{{ $member->referral_code }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-full text-xs font-semibold">{{ $member->referred_bookings_count }}</span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $member->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">
                                {{ ucfirst($member->status) }}
                            </span>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <div class="text-center py-12">
            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-users text-gray-400 text-2xl"></i>
            </div>
            <p class="text-gray-500">No team members yet</p>
            <p class="text-sm text-gray-400">Commission users assigned under you will appear here</p>
        </div>
        @endif
    </div>
@endsection
