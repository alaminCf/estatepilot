@extends('Website.user.layouts.account')

@section('title', 'My Bookings - ' . site_name())

@section('account_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Bookings</h1>
        <p class="text-gray-600">View and manage all your plot bookings</p>
    </div>

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4 flex items-center gap-3">
            <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
            <p class="text-red-800 font-medium">{{ session('error') }}</p>
        </div>
    @endif

        <!-- Bookings List -->
        @if($bookings->count() > 0)
            <div class="space-y-6">
                @foreach($bookings as $booking)
                    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-all duration-300">
                        <div class="p-6">
                            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-6">
                                <!-- Left: Plot Details -->
                                <div class="flex-1">
                                    <div class="flex items-start gap-4">
                                        <!-- Plot Image/Placeholder -->
                                        <div class="w-24 h-24 rounded-lg bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center flex-shrink-0">
                                            <i class="fas fa-map-marked-alt text-white text-3xl"></i>
                                        </div>
                                        
                                        <!-- Plot Info -->
                                        <div class="flex-1">
                                            <div class="flex items-center gap-3 mb-2">
                                                <h3 class="text-xl font-bold text-gray-900">Plot #{{ $booking->plot->plot_no }}</h3>
                                                <span class="px-3 py-1 rounded-full text-xs font-semibold
                                                    @if($booking->status === 'confirmed') bg-green-100 text-green-700
                                                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                                                    @elseif($booking->status === 'pre-booked') bg-blue-100 text-blue-700
                                                    @else bg-red-100 text-red-700
                                                    @endif">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3 text-sm">
                                                <div>
                                                    <span class="text-gray-500">Size:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ $booking->plot->size_katha }} Katha</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Block:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ $booking->plot->block }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Facing:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ $booking->plot->facing }}</span>
                                                </div>
                                                <div>
                                                    <span class="text-gray-500">Road:</span>
                                                    <span class="font-semibold text-gray-900 ml-1">{{ $booking->plot->road_no ?? 'N/A' }}</span>
                                                </div>
                                            </div>

                                            <div class="mt-3 flex items-center gap-4 text-sm text-gray-600">
                                                <div class="flex items-center gap-2">
                                                    <i class="far fa-calendar text-primary"></i>
                                                    <span>Booked: {{ $booking->booking_date ? $booking->booking_date->format('M d, Y') : $booking->created_at->format('M d, Y') }}</span>
                                                </div>
                                                @if($booking->agent)
                                                    <div class="flex items-center gap-2">
                                                        <i class="fas fa-user-tie text-primary"></i>
                                                        <span>Agent: {{ $booking->agent->name }}</span>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Right: Price & Actions -->
                                <div class="lg:text-right flex-shrink-0">
                                    <div class="mb-4">
                                        <p class="text-sm text-gray-500 mb-1">Total Price</p>
                                        <p class="text-3xl font-bold text-primary">৳{{ format_bd_number($booking->plot->price, 0) }}</p>
                                    </div>
                                    
                                    <div class="flex flex-col gap-2">
                                        <a href="{{ route('account.bookings.show', $booking) }}" 
                                           class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition-colors duration-300">
                                            <i class="fas fa-eye"></i>
                                            <span>View Details</span>
                                        </a>
                                        @if(in_array($booking->status, ['pending', 'pre-booked']))
                                            <a href="{{ route('account.bookings.edit', $booking) }}" 
                                               class="inline-flex items-center justify-center gap-2 px-6 py-3 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-semibold transition-colors duration-300">
                                                <i class="fas fa-edit"></i>
                                                <span>Edit Booking</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Info (if any) -->
                            @if($booking->additional_info)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <p class="text-sm text-gray-500 mb-1">Additional Information:</p>
                                    <p class="text-gray-700">{{ $booking->additional_info }}</p>
                                </div>
                            @endif

                            <!-- Custom Booking Amount Info -->
                            @if($booking->custom_booking_amount)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="flex items-center gap-4 text-sm">
                                        <div>
                                            <span class="text-gray-500">Custom Booking Amount:</span>
                                            <span class="font-semibold text-orange-600 ml-1">৳{{ format_bd_number($booking->custom_booking_amount, 2) }}</span>
                                        </div>
                                        <div>
                                            <span class="text-gray-500">Full Booking Money:</span>
                                            <span class="font-semibold text-gray-900 ml-1">৳{{ format_bd_number($booking->booking_payment, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @endif

                            <!-- Pre-Booking Expiry Notice -->
                            @if($booking->status === 'pre-booked' && $booking->pre_booking_expires_at)
                                <div class="mt-4 pt-4 border-t border-gray-200">
                                    <div class="bg-amber-50 border border-amber-300 rounded-lg p-3">
                                        <div class="flex items-start">
                                            <i class="fas fa-exclamation-triangle text-amber-500 mt-0.5 mr-2"></i>
                                            <div class="text-sm">
                                                @if($booking->pre_booking_expires_at->isPast())
                                                    <p class="text-red-600 font-semibold mb-0"><strong>EXPIRED:</strong> This pre-booking expired on {{ $booking->pre_booking_expires_at->format('M d, Y h:i A') }}.</p>
                                                @else
                                                    <p class="text-amber-700 mb-0"><strong>Pre-Booking Notice:</strong> This booking is valid till <strong>{{ $booking->pre_booking_expires_at->format('M d, Y') }}</strong> ({{ $booking->pre_booking_expires_at->diffForHumans() }}). If the full booking money is not paid before this date, the booking will be cancelled automatically.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $bookings->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <i class="fas fa-inbox text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-900 mb-2">No Bookings Yet</h3>
                <p class="text-gray-600 mb-6">You haven't booked any plots yet. Browse our available plots to get started!</p>
                <a href="{{ route('plots.index') }}" 
                   class="inline-flex items-center gap-2 px-8 py-3 bg-primary hover:bg-primary-dark text-white rounded-lg font-semibold transition-colors duration-300">
                    <i class="fas fa-search"></i>
                    <span>Browse Plots</span>
                </a>
            </div>
        @endif
@endsection
