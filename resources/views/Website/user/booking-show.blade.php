@extends('Website.user.layouts.account')

@section('title', 'Booking Details - London Abason')

@section('account_content')
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3 mb-2">
                <h1 class="text-3xl font-bold text-gray-900">Booking #{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</h1>
                <span class="px-3 py-1 rounded-full text-sm font-semibold
                    @if($booking->status === 'approved') bg-green-100 text-green-700
                    @elseif($booking->status === 'pending') bg-yellow-100 text-yellow-700
                    @elseif($booking->status === 'pre-booked') bg-blue-100 text-blue-700
                    @elseif($booking->status === 'confirmed') bg-green-100 text-green-700
                    @else bg-red-100 text-red-700
                    @endif">
                    {{ ucfirst($booking->status) }}
                </span>
            </div>
            <p class="text-gray-500 text-sm">
                Booked on {{ $booking->booking_date ? $booking->booking_date->format('M d, Y h:i A') : $booking->created_at->format('M d, Y') }}
            </p>
        </div>
        <div class="flex gap-3">
            @if(in_array($booking->status, ['pending', 'pre-booked']))
                <a href="{{ route('account.bookings.edit', $booking) }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-white rounded-lg font-semibold transition text-sm">
                    <i class="fas fa-edit"></i> Edit Booking
                </a>
            @endif
            <a href="{{ route('account.bookings') }}" class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-100 hover:bg-gray-200 text-gray-700 rounded-lg font-semibold transition text-sm">
                <i class="fas fa-arrow-left"></i> Back to Bookings
            </a>
        </div>
    </div>

    <!-- Pre-Booking Expiry Notice -->
    @if($booking->status === 'pre-booked' && $booking->pre_booking_expires_at)
        <div class="mb-6 rounded-xl border-2 {{ $booking->pre_booking_expires_at->isPast() ? 'bg-red-50 border-red-300' : 'bg-amber-50 border-amber-300' }} p-4">
            <div class="flex items-start gap-3">
                <i class="fas fa-{{ $booking->pre_booking_expires_at->isPast() ? 'exclamation-circle text-red-500' : 'clock text-amber-500' }} text-xl mt-0.5"></i>
                <div>
                    @if($booking->pre_booking_expires_at->isPast())
                        <h4 class="font-bold text-red-700 mb-1">Pre-Booking Expired</h4>
                        <p class="text-sm text-red-600">This pre-booking expired on <strong>{{ $booking->pre_booking_expires_at->format('M d, Y h:i A') }}</strong>. The full booking money was not paid in time.</p>
                    @else
                        <h4 class="font-bold text-amber-700 mb-1">Pre-Booking Active</h4>
                        <p class="text-sm text-amber-600">Custom booking amount: <strong>৳{{ format_bd_number($booking->custom_booking_amount, 2) }}</strong>. Expires on <strong>{{ $booking->pre_booking_expires_at->format('M d, Y h:i A') }}</strong> ({{ $booking->pre_booking_expires_at->diffForHumans() }}).</p>
                    @endif
                </div>
            </div>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Left Column -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Plot Details Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-r from-primary to-primary-dark px-6 py-4">
                    <div class="flex items-center justify-between">
                        <h3 class="text-lg font-bold text-white flex items-center gap-2">
                            <i class="fas fa-map-marked-alt"></i> Plot Details
                        </h3>
                        <span class="text-white font-bold text-xl">{{ $booking->plot->plot_no }}</span>
                    </div>
                </div>
                <div class="p-6">
                    <h4 class="text-xl font-bold text-gray-900 mb-4">{{ $booking->plot->title }}</h4>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-ruler-combined text-primary mb-1 block"></i>
                            <div class="text-xs text-gray-500">Size</div>
                            <div class="font-bold text-gray-900">{{ $booking->plot->size_katha }} Katha</div>
                        </div>
                        @if($booking->plot->block)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-cube text-primary mb-1 block"></i>
                            <div class="text-xs text-gray-500">Block</div>
                            <div class="font-bold text-gray-900">{{ $booking->plot->block }}</div>
                        </div>
                        @endif
                        @if($booking->plot->facing)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-compass text-primary mb-1 block"></i>
                            <div class="text-xs text-gray-500">Facing</div>
                            <div class="font-bold text-gray-900">{{ $booking->plot->facing }}</div>
                        </div>
                        @endif
                        @if($booking->plot->road_no)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-road text-primary mb-1 block"></i>
                            <div class="text-xs text-gray-500">Road No</div>
                            <div class="font-bold text-gray-900">{{ $booking->plot->road_no }}</div>
                        </div>
                        @endif
                        @if($booking->plot->plot_category)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-tag text-primary mb-1 block"></i>
                            <div class="text-xs text-gray-500">Category</div>
                            <div class="font-bold text-gray-900">{{ $booking->plot->plot_category }}</div>
                        </div>
                        @endif
                        @if($booking->plot->road_width)
                        <div class="text-center p-3 bg-gray-50 rounded-lg">
                            <i class="fas fa-arrows-alt-h text-primary mb-1 block"></i>
                            <div class="text-xs text-gray-500">Road Width</div>
                            <div class="font-bold text-gray-900">{{ $booking->plot->road_width }}</div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Additional Owners Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-users text-primary"></i> Additional Owners
                        @if($booking->owners && count($booking->owners) > 0)
                            <span class="bg-primary text-white text-xs font-bold px-2 py-0.5 rounded-full">{{ count($booking->owners) }}</span>
                        @endif
                    </h3>
                </div>
                <div class="p-6">
                    @if($booking->owners && count($booking->owners) > 0)
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($booking->owners as $index => $owner)
                            <div class="border border-gray-200 rounded-xl p-4 hover:shadow-md hover:border-primary/30 transition-all duration-200 bg-gradient-to-br from-white to-gray-50">
                                <div class="mb-3 pb-3 border-b border-gray-200">
                                    <h4 class="font-bold text-gray-900">{{ $owner['name'] ?? 'N/A' }}</h4>
                                    <span class="text-xs text-gray-500">Additional Owner #{{ $index + 1 }}</span>
                                </div>
                                <div class="space-y-2">
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-phone text-primary w-4 text-center"></i>
                                        <span class="text-gray-600">Phone:</span>
                                        <span class="font-semibold text-gray-900">{{ $owner['phone'] ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-id-card text-primary w-4 text-center"></i>
                                        <span class="text-gray-600">NID:</span>
                                        <span class="font-semibold text-gray-900">{{ $owner['nid'] ?? 'N/A' }}</span>
                                    </div>
                                    <div class="flex items-start gap-2 text-sm">
                                        <i class="fas fa-map-marker-alt text-primary w-4 text-center mt-0.5"></i>
                                        <span class="text-gray-600">Address:</span>
                                        <span class="font-semibold text-gray-900">{{ $owner['address'] ?? 'N/A' }}</span>
                                    </div>
                                    @if(!empty($owner['father_name']))
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-male text-blue-500 w-4 text-center"></i>
                                        <span class="text-gray-600">Father:</span>
                                        <span class="font-semibold text-gray-900">{{ $owner['father_name'] }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($owner['mother_name']))
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-female text-pink-500 w-4 text-center"></i>
                                        <span class="text-gray-600">Mother:</span>
                                        <span class="font-semibold text-gray-900">{{ $owner['mother_name'] }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($owner['spouse_name']))
                                    <div class="flex items-center gap-2 text-sm">
                                        <i class="fas fa-heart text-red-400 w-4 text-center"></i>
                                        <span class="text-gray-600">Spouse:</span>
                                        <span class="font-semibold text-gray-900">{{ $owner['spouse_name'] }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($owner['nominee_info']))
                                    <div class="flex items-start gap-2 text-sm pt-2 mt-2 border-t border-gray-100">
                                        <i class="fas fa-users text-green-500 w-4 text-center mt-0.5"></i>
                                        <div>
                                            <span class="text-gray-600 block mb-1">Nominee Info:</span>
                                            <span class="font-semibold text-gray-900 whitespace-pre-line">{{ $owner['nominee_info'] }}</span>
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-user-friends text-4xl mb-3 block"></i>
                            <p class="text-gray-500">No owners added for this booking</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Payment History Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-history text-primary"></i> Payment History
                    </h3>
                </div>
                <div class="p-6">
                    @if($booking->payments->count() > 0)
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead>
                                    <tr class="bg-gray-50">
                                        <th class="text-left px-4 py-3 font-semibold text-gray-600 rounded-l-lg">#</th>
                                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Type</th>
                                        <th class="text-left px-4 py-3 font-semibold text-gray-600">Amount</th>
                                        <th class="text-left px-4 py-3 font-semibold text-gray-600 rounded-r-lg">Date</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    @foreach($booking->payments as $p)
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-4 py-3 font-medium text-gray-900">#{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</td>
                                        <td class="px-4 py-3">
                                            @if($p->payment_type == 'Booking Payment')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-blue-100 text-blue-700">{{ $p->payment_type }}</span>
                                            @elseif($p->payment_type == 'Installment Payment')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-700">{{ $p->payment_type }}</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-700">{{ $p->payment_type }}</span>
                                            @endif
                                        </td>
                                        <td class="px-4 py-3 font-bold text-green-600">৳{{ format_bd_number($p->amount, 2) }}</td>
                                        <td class="px-4 py-3 text-gray-500">{{ $p->created_at->format('d M, Y h:i A') }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr class="bg-gray-50">
                                        <td colspan="2" class="px-4 py-3 font-bold text-gray-900 rounded-l-lg">Total Paid</td>
                                        <td class="px-4 py-3 font-bold text-green-600">৳{{ format_bd_number($booking->payments->sum('amount'), 2) }}</td>
                                        <td class="rounded-r-lg"></td>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-8 text-gray-400">
                            <i class="fas fa-receipt text-4xl mb-3 block"></i>
                            <p class="text-gray-500">No payments recorded yet</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Additional Info -->
            @if($booking->additional_info)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary"></i> Additional Information
                    </h3>
                </div>
                <div class="p-6">
                    <p class="text-gray-700">{{ $booking->additional_info }}</p>
                </div>
            </div>
            @endif
        </div>

        <!-- Right Column - Payment Summary -->
        <div class="space-y-6">
            <!-- Payment Summary Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="bg-gradient-to-br from-green-50 to-blue-50 px-6 py-5 border-b border-gray-200">
                    <h3 class="text-lg font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-calculator text-primary"></i> Payment Summary
                    </h3>
                </div>
                <div class="p-6">
                    @php
                        $totalPaid = $booking->payments->sum('amount');
                        $totalDue = $booking->price - $totalPaid;
                        $bookingPaymentsPaid = $booking->payments->where('payment_type', 'Booking Payment')->sum('amount');
                        $installmentsPaid = (int) $booking->payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sum('instalment_quantity');
                        $remainingBookingMoney = $booking->booking_payment - $bookingPaymentsPaid;
                    @endphp

                    <div class="space-y-4">
                        <!-- Total Price -->
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Total Price</span>
                            <span class="text-xl font-bold text-gray-900">৳{{ format_bd_number($booking->price, 2) }}</span>
                        </div>

                        <!-- Booking Money -->
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Booking Money</span>
                            <span class="font-semibold text-gray-900">৳{{ format_bd_number($booking->booking_payment, 2) }}</span>
                        </div>

                        <!-- Paid Booking Money -->
                        <div class="flex justify-between items-center pb-3 border-b border-gray-200">
                            <span class="text-gray-600">Paid Booking Money</span>
                            <span class="font-semibold text-green-600">৳{{ format_bd_number($bookingPaymentsPaid, 2) }}</span>
                        </div>

                        <!-- Total Paid -->
                        <div class="flex justify-between items-center p-3 bg-green-50 rounded-lg">
                            <span class="text-green-700 font-semibold">Total Paid</span>
                            <span class="text-lg font-bold text-green-600">৳{{ format_bd_number($totalPaid, 2) }}</span>
                        </div>

                        <!-- Total Due -->
                        <div class="flex justify-between items-center p-3 {{ $totalDue > 0 ? 'bg-red-50' : 'bg-green-50' }} rounded-lg">
                            <span class="{{ $totalDue > 0 ? 'text-red-700' : 'text-green-700' }} font-semibold">Total Due</span>
                            <span class="text-lg font-bold {{ $totalDue > 0 ? 'text-red-600' : 'text-green-600' }}">৳{{ format_bd_number(max($totalDue, 0), 2) }}</span>
                        </div>

                        <!-- Installment Info -->
                        @if($booking->installment_plan)
                        <div class="pt-3 border-t border-gray-200">
                            <h4 class="font-semibold text-gray-900 mb-3 flex items-center gap-2">
                                <i class="fas fa-calendar-alt text-primary"></i> Installment Plan
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Plan</span>
                                    <span class="font-semibold text-gray-900">{{ ucfirst($booking->installment_plan) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Per Installment</span>
                                    <span class="font-semibold text-primary">৳{{ format_bd_number($booking->installment_payment, 2) }}</span>
                                </div>
                                <div class="flex justify-between">
                                    <span class="text-gray-600">Installments Paid</span>
                                    <span class="font-semibold text-gray-900">{{ $installmentsPaid }} / {{ $booking->total_installments }}</span>
                                </div>
                                <!-- Progress Bar -->
                                <div class="mt-2">
                                    <div class="w-full bg-gray-200 rounded-full h-2">
                                        <div class="bg-primary h-2 rounded-full transition-all" style="width: {{ $booking->total_installments > 0 ? ($installmentsPaid / $booking->total_installments * 100) : 0 }}%"></div>
                                    </div>
                                    <p class="text-xs text-gray-500 mt-1 text-right">
                                        {{ $booking->total_installments > 0 ? round($installmentsPaid / $booking->total_installments * 100) : 0 }}% Complete
                                    </p>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Booking Info Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-base font-bold text-gray-900 flex items-center gap-2">
                        <i class="fas fa-info-circle text-primary"></i> Booking Info
                    </h3>
                </div>
                <div class="p-6">
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-600">Booking ID</span>
                            <span class="font-semibold text-gray-900">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-600">Booking Date</span>
                            <span class="font-semibold text-gray-900">{{ $booking->booking_date ? $booking->booking_date->format('d M, Y') : $booking->created_at->format('d M, Y') }}</span>
                        </div>
                        @if($booking->agent)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Agent</span>
                            <span class="font-semibold text-gray-900">{{ $booking->agent->name }}</span>
                        </div>
                        @endif
                        <div class="flex justify-between">
                            <span class="text-gray-600">Last Updated</span>
                            <span class="font-semibold text-gray-900">{{ $booking->updated_at->format('d M, Y H:i') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
