@extends('Website.layouts.app')

@section('title', $plot->title . ' - London Abason')

@section('content')
    <!-- Breadcrumb -->
    <div class="pt-20 bg-gray-50 border-b">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
            <div class="flex items-center space-x-2 text-sm">
                <a href="{{ route('home') }}" class="text-gray-500 hover:text-primary">Home</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <a href="{{ route('plots.index') }}" class="text-gray-500 hover:text-primary">Plots</a>
                <i class="fas fa-chevron-right text-gray-400 text-xs"></i>
                <span class="text-gray-900 font-medium">{{ $plot->plot_no }}</span>
            </div>
        </div>
    </div>

    <!-- Main Content -->
    <div class="bg-gray-50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-3 gap-8">
                <!-- Left Column - Main Content -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Image Section -->
                    <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
                        @if($plot->plot_map)
                            <div class="bg-green-50 cursor-pointer" onclick="openImageModal()">
                                <img src="{{ asset($plot->plot_map) }}" alt="{{ $plot->title }}" class="w-full h-96 object-cover hover:scale-105 transition-transform duration-300">
                            </div>
                        @else
                            <div class="w-full h-96 bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center">
                                <i class="fas fa-map-marked-alt text-white text-8xl opacity-30"></i>
                            </div>
                        @endif
                    </div>

                    <!-- Plot Details Card -->
                    <div class="bg-white rounded-2xl shadow-lg p-8">
                        <div class="flex items-start justify-between mb-6">
                            <div>
                                <h1 class="text-3xl font-bold text-gray-900 mb-2">{{ $plot->plot_no }}</h1>
                                <p class="text-lg text-gray-600">{{ $plot->title }}</p>
                            </div>
                            <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-semibold {{ $plot->status === 'available' ? 'bg-green-100 text-green-800' : ($plot->status === 'pending' ? 'bg-blue-100 text-blue-800' : 'bg-red-100 text-red-800') }}">
                                <span class="w-2 h-2 rounded-full {{ $plot->status === 'available' ? 'bg-green-500' : ($plot->status === 'pending' ? 'bg-blue-500' : 'bg-red-500') }} mr-2"></span>
                                {{ ucfirst($plot->status) }}
                            </span>
                        </div>

                        <!-- Key Features Grid -->
                        <div class="grid md:grid-cols-4 gap-4 mb-8 pb-8 border-b">
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-ruler-combined text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Size</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->size_katha }} Katha</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-compass text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Facing</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->facing }}</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-cube text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Block</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->block }}</div>
                            </div>
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-road text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Road No.</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->road_no }}</div>
                            </div>
                            @if($plot->plot_category)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-tag text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Category</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->plot_category }}</div>
                            </div>
                            @endif
                            @if($plot->road_width)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-arrows-alt-h text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Road Width</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->road_width }}</div>
                            </div>
                            @endif
                            @if($plot->agent_name)
                            <div class="text-center p-4 bg-gray-50 rounded-xl">
                                <i class="fas fa-user-tie text-primary text-2xl mb-2"></i>
                                <div class="text-sm text-gray-600">Agent</div>
                                <div class="text-lg font-bold text-gray-900">{{ $plot->agent_name }}</div>
                            </div>
                            @endif
                        </div>

                        <!-- Description -->
                        @if($plot->description)
                        <div class="mb-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4">Description</h3>
                            <p class="text-gray-600 leading-relaxed">{{ $plot->description }}</p>
                        </div>
                        @endif

                        <!-- Payment Plan -->
                        <div class="bg-gradient-to-br from-green-50 to-white p-6 rounded-xl border border-green-100">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-credit-card text-primary mr-2"></i>
                                Payment Plan
                            </h3>
                            <div class="grid md:grid-cols-2 gap-4">
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                                    <span class="text-gray-600">Total Price:</span>
                                    <span class="text-xl font-bold text-primary">@auth ৳{{ format_bd_number($plot->price, 2) }} @else <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">Login to see</a> @endauth</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                                    <span class="text-gray-600">Booking Money:</span>
                                    <span class="text-lg font-semibold text-gray-900">@auth ৳{{ format_bd_number($plot->booking_payment, 2) }} @else <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">Login to see</a> @endauth</span>
                                </div>
                                @if($plot->installment_plan)
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                                    <span class="text-gray-600">Installment Plan:</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ ucfirst($plot->installment_plan) }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                                    <span class="text-gray-600">Per {{ ucfirst($plot->installment_plan) }}:</span>
                                    <span class="text-lg font-semibold text-gray-900">৳{{ format_bd_number($plot->installment_payment, 2) }}</span>
                                </div>
                                @if($plot->total_installments)
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                                    <span class="text-gray-600">Total Installments:</span>
                                    <span class="text-lg font-semibold text-gray-900">{{ $plot->total_installments }}</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-white rounded-lg">
                                    <span class="text-gray-600">Duration:</span>
                                    <span class="text-lg font-semibold text-gray-900">
                                        {{ $plot->installment_plan === 'monthly' ? ceil($plot->total_installments / 12) : ceil($plot->total_installments / 4) }} Years
                                    </span>
                                </div>
                                @endif
                                @endif
                            </div>
                        </div>

                        <!-- Nearby Facilities -->
                        @if($plot->nearby_facilities)
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-map-marker-alt text-primary mr-2"></i>
                                Nearby Facilities
                            </h3>
                            <p class="text-gray-600 leading-relaxed">{{ $plot->nearby_facilities }}</p>
                        </div>
                        @endif

                        <!-- Google Maps Location -->
                        @if($plot->google_maps_location)
                        <div class="mt-8">
                            <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                                <i class="fas fa-map text-primary mr-2"></i>
                                Location
                            </h3>
                            <a href="{{ $plot->google_maps_location }}" target="_blank" class="inline-flex items-center text-primary hover:text-primary-dark font-semibold">
                                <i class="fas fa-external-link-alt mr-2"></i>
                                View on Google Maps
                            </a>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- Right Column - Booking Card -->
                <div class="lg:col-span-1">
                    <div class="bg-white rounded-2xl shadow-lg p-6 sticky top-24">
                        <!-- Price -->
                        <div class="text-center mb-6 pb-6 border-b">
                            @auth
                            <div class="text-sm text-gray-600 mb-2">Starting From</div>
                            <div class="text-4xl font-bold text-primary mb-2">৳{{ format_bd_number($plot->price, 2) }}</div>
                            <div class="text-sm text-gray-500">Total Price</div>
                            @else
                            <div class="text-sm text-gray-600 mb-2">Price</div>
                            <div class="text-lg font-semibold text-primary mb-2"><a href="{{ route('login') }}" class="hover:underline">Login to see price</a></div>
                            @endauth
                        </div>

                        <!-- Quick Info -->
                        <div class="space-y-3 mb-6">
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">Plot No.</span>
                                <span class="font-semibold text-gray-900">{{ $plot->plot_no }}</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">Size</span>
                                <span class="font-semibold text-gray-900">{{ $plot->size_katha }} Katha</span>
                            </div>
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">Booking Money</span>
                                <span class="font-semibold text-primary">৳{{ format_bd_number($plot->booking_payment, 2) }}</span>
                            </div>
                            @if($plot->installment_plan)
                            <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                <span class="text-gray-600 text-sm">{{ ucfirst($plot->installment_plan) }} EMI</span>
                                <span class="font-semibold text-gray-900">৳{{ format_bd_number($plot->installment_payment, 2) }}</span>
                            </div>
                            @endif
                        </div>

                        <!-- Book Now Button -->
                        @if($plot->status === 'available')
                            @if(auth()->check() && auth()->user()->role === 'user')
                                <button onclick="handleBookNow()" class="w-full bg-primary text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-primary-dark transition shadow-lg transform hover:scale-105 mb-4">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Book Now
                                </button>
                            @elseif(auth()->check())
                                <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-4 rounded-lg font-bold text-lg cursor-not-allowed mb-4" title="Only users can book plots">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Book Now
                                </button>
                                <p class="text-xs text-gray-500 text-center mb-4">Only registered users can book plots</p>
                            @else
                                <button onclick="handleBookNow()" class="w-full bg-primary text-white px-6 py-4 rounded-lg font-bold text-lg hover:bg-primary-dark transition shadow-lg transform hover:scale-105 mb-4">
                                    <i class="fas fa-calendar-check mr-2"></i>
                                    Book Now
                                </button>
                            @endif
                        @else
                            <button disabled class="w-full bg-gray-300 text-gray-500 px-6 py-4 rounded-lg font-bold text-lg cursor-not-allowed mb-4">
                                <i class="fas fa-ban mr-2"></i>
                                Not Available
                            </button>
                        @endif

                        <!-- Contact Info -->
                        <div class="border-t pt-6 mt-6">
                            <h4 class="font-semibold text-gray-900 mb-4">Need Help?</h4>
                            <div class="space-y-3">
                                <a href="tel:+8801322902986" class="flex items-center text-gray-600 hover:text-primary transition">
                                    <i class="fas fa-phone-alt text-primary mr-3"></i>
                                    <span>+880 1322-902986</span>
                                </a>
                                <a href="mailto:info@londonabd.com" class="flex items-center text-gray-600 hover:text-primary transition">
                                    <i class="fas fa-envelope text-primary mr-3"></i>
                                    <span>info@londonabd.com</span>
                                </a>
                            </div>
                        </div>

                        <!-- Features -->
                        <div class="border-t pt-6 mt-6">
                            <ul class="space-y-3">
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    100% Legal Documentation
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Flexible Payment Plans
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Prime Location
                                </li>
                                <li class="flex items-center text-sm text-gray-600">
                                    <i class="fas fa-check-circle text-green-500 mr-2"></i>
                                    Expert Support
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Image Lightbox Modal -->
    @if($plot->plot_map)
    <div id="imageModal" class="hidden fixed inset-0 z-50 bg-black bg-opacity-90 flex items-center justify-center p-4">
        <button onclick="closeImageModal()" class="absolute top-4 right-4 text-white hover:text-gray-300 z-10">
            <i class="fas fa-times text-3xl"></i>
        </button>
        <div class="max-w-7xl max-h-full overflow-auto">
            <img src="{{ asset($plot->plot_map) }}" alt="{{ $plot->title }}" class="max-w-full max-h-[90vh] object-contain mx-auto">
        </div>
    </div>
    @endif

    <!-- Auth Modal (Not Logged In) -->
    <div id="authModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" onclick="closeAuthModal()"></div>
            
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-gradient-to-br from-primary to-primary-dark px-8 py-6">
                    <div class="flex items-center justify-between">
                        <h3 class="text-2xl font-bold text-white">Authentication Required</h3>
                        <button onclick="closeAuthModal()" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>
                
                <div class="px-8 py-8">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-user-lock text-primary text-3xl"></i>
                        </div>
                        <p class="text-gray-600 text-lg">Please sign in or register to book this plot</p>
                    </div>
                    
                    <div class="space-y-3">
                        <a href="{{ route('login', ['redirect' => url()->current()]) }}" class="block w-full bg-primary text-white px-6 py-4 rounded-lg font-semibold text-center hover:bg-primary-dark transition shadow-lg">
                            <i class="fas fa-sign-in-alt mr-2"></i>
                            Sign In
                        </a>
                        <a href="{{ route('register', ['redirect' => url()->current()]) }}" class="block w-full bg-white border-2 border-primary text-primary px-6 py-4 rounded-lg font-semibold text-center hover:bg-green-50 transition">
                            <i class="fas fa-user-plus mr-2"></i>
                            Register
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Booking Modal (Logged In) -->
    <div id="bookingModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75" onclick="closeBookingModal()"></div>
            
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-gradient-to-br from-primary to-primary-dark px-8 py-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-2xl font-bold text-white">Book Plot {{ $plot->plot_no }}</h3>
                            <p class="text-green-100 text-sm mt-1">Fill the form below to proceed with booking</p>
                        </div>
                        <button onclick="closeBookingModal()" class="text-white hover:text-gray-200">
                            <i class="fas fa-times text-2xl"></i>
                        </button>
                    </div>
                </div>
                
                <form id="bookingForm" action="{{ route('bookings.store') }}" method="POST" class="px-8 py-8">
                    @csrf
                    <input type="hidden" name="plot_id" value="{{ $plot->id }}">
                    
                    <div class="space-y-6">
                        <!-- Plot Summary -->
                        <div class="bg-gray-50 p-4 rounded-lg">
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <span class="text-gray-600">Plot:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $plot->plot_no }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Size:</span>
                                    <span class="font-semibold text-gray-900 ml-2">{{ $plot->size_katha }} Katha</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Total Price:</span>
                                    <span class="font-semibold text-primary ml-2">@auth ৳{{ format_bd_number($plot->price, 2) }} @else <a href="{{ route('login') }}" class="text-sm hover:underline">Login to see</a> @endauth</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Booking Money:</span>
                                    <span class="font-semibold text-gray-900 ml-2">৳{{ format_bd_number($plot->booking_payment, 2) }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Type -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Select Payment Type <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-2 gap-4">
                                <label class="relative flex flex-col items-center p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group" id="oneTimeLabel">
                                    <input type="radio" name="payment_type" value="one_time" class="sr-only" onchange="handlePaymentTypeChange()" required>
                                    <div class="w-16 h-16 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-money-bill-wave text-blue-600 text-2xl"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-bold text-gray-900 text-lg mb-1">One Time</div>
                                        <div class="text-xs text-gray-500">Full payment at once</div>
                                    </div>
                                    <div class="absolute top-3 right-3 w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-white text-xs hidden"></i>
                                    </div>
                                </label>
                                <label class="relative flex flex-col items-center p-5 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group" id="installmentLabel">
                                    <input type="radio" name="payment_type" value="installment" class="sr-only" onchange="handlePaymentTypeChange()" required>
                                    <div class="w-16 h-16 bg-gradient-to-br from-green-100 to-green-50 rounded-full flex items-center justify-center mb-3 group-hover:scale-110 transition-transform duration-300">
                                        <i class="fas fa-calendar-alt text-green-600 text-2xl"></i>
                                    </div>
                                    <div class="text-center">
                                        <div class="font-bold text-gray-900 text-lg mb-1">Installment</div>
                                        <div class="text-xs text-gray-500">Pay in monthly/quarterly</div>
                                    </div>
                                    <div class="absolute top-3 right-3 w-6 h-6 rounded-full border-2 border-gray-300 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-white text-xs hidden"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Installment Plan (Hidden by default) -->
                        <div id="installmentPlanSection" class="hidden">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Installment Plan <span class="text-red-500">*</span>
                            </label>
                            <select name="installment_plan" id="installmentPlan" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" onchange="calculateInstallment()">
                                <option value="">Select installment plan</option>
                                <option value="monthly">Monthly</option>
                                <option value="quarterly">Quarterly</option>
                            </select>
                        </div>

                        <!-- Total Installments (Hidden by default) -->
                        <div id="totalInstallmentsSection" class="hidden">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Number of Installments <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="total_installments" id="totalInstallments" min="1" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter number of installments" onchange="calculateInstallment()">
                        </div>

                        <!-- Price Overview -->
                        @auth
                        <div id="priceOverview" class="bg-gradient-to-br from-green-50 to-blue-50 p-5 rounded-xl border-2 border-primary/20">
                            <h4 class="font-bold text-gray-900 mb-3 flex items-center">
                                <i class="fas fa-calculator text-primary mr-2"></i>
                                Payment Overview
                            </h4>
                            <div class="space-y-2 text-sm">
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-700">Total Plot Price:</span>
                                    <span class="font-bold text-gray-900">৳{{ format_bd_number($plot->price, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2 border-b border-gray-200">
                                    <span class="text-gray-700">Booking Money:</span>
                                    <span class="font-semibold text-primary">৳{{ format_bd_number($plot->booking_payment, 2) }}</span>
                                </div>
                                <div class="flex justify-between items-center py-2" id="remainingAmountRow">
                                    <span class="text-gray-700">Remaining Amount:</span>
                                    <span class="font-semibold text-gray-900" id="remainingAmount">৳{{ format_bd_number($plot->price - $plot->booking_payment, 2) }}</span>
                                </div>
                                <!-- Installment Details (Hidden by default) -->
                                <div id="installmentDetails" class="hidden space-y-2 pt-2 border-t-2 border-primary/30">
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-gray-700">Payment Plan:</span>
                                        <span class="font-semibold text-primary" id="planType">-</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-gray-700">Per Installment:</span>
                                        <span class="font-bold text-lg text-primary" id="perInstallment">৳0</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-gray-700">Total Installments:</span>
                                        <span class="font-semibold text-gray-900" id="totalInstallmentsDisplay">0</span>
                                    </div>
                                    <div class="flex justify-between items-center py-1">
                                        <span class="text-gray-700">Duration:</span>
                                        <span class="font-semibold text-gray-900" id="duration">-</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endauth

                        <!-- Booking Money Option -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">
                                Booking Money Option <span class="text-red-500">*</span>
                            </label>
                            <div class="grid grid-cols-1 gap-3">
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group" id="fullBookingLabel">
                                    <input type="radio" name="booking_money_option" value="full" class="sr-only" onchange="handleBookingMoneyOptionChange()" required>
                                    <div class="w-10 h-10 bg-gradient-to-br from-blue-100 to-blue-50 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                        <i class="fas fa-money-bill-wave text-blue-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">Paying Full Booking Money</div>
                                        <div class="text-xs text-gray-500">Pay ৳{{ format_bd_number($plot->booking_payment, 2) }} as full booking amount</div>
                                    </div>
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-white text-xs hidden"></i>
                                    </div>
                                </label>
                                <label class="relative flex items-center p-4 border-2 border-gray-200 rounded-xl cursor-pointer hover:border-primary hover:shadow-md transition-all duration-300 group" id="customBookingLabel">
                                    <input type="radio" name="booking_money_option" value="custom" class="sr-only" onchange="handleBookingMoneyOptionChange()" required>
                                    <div class="w-10 h-10 bg-gradient-to-br from-orange-100 to-orange-50 rounded-full flex items-center justify-center mr-4 group-hover:scale-110 transition-transform duration-300 flex-shrink-0">
                                        <i class="fas fa-hand-holding-usd text-orange-600 text-lg"></i>
                                    </div>
                                    <div>
                                        <div class="font-bold text-gray-900 text-sm">I want to pay other amount for booking money</div>
                                        <div class="text-xs text-gray-500">Pay a partial amount now (Pre-Booking)</div>
                                    </div>
                                    <div class="absolute top-3 right-3 w-5 h-5 rounded-full border-2 border-gray-300 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                        <i class="fas fa-check text-white text-xs hidden"></i>
                                    </div>
                                </label>
                            </div>
                        </div>

                        <!-- Custom Booking Amount (Hidden by default) -->
                        <div id="customBookingAmountSection" class="hidden">
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Enter Your Booking Amount (৳) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="custom_booking_amount" id="customBookingAmount" min="1" max="{{ $plot->booking_payment }}" step="0.01" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" placeholder="Enter amount you want to pay" onchange="updateCustomBookingDisplay()" oninput="updateCustomBookingDisplay()">
                            <p class="text-xs text-gray-500 mt-1">Maximum booking amount: ৳{{ format_bd_number($plot->booking_payment, 2) }}</p>
                        </div>

                        <!-- Pre-Booking Notice (Hidden by default) -->
                        <div id="preBookingNotice" class="hidden">
                            <div class="bg-amber-50 border-2 border-amber-300 rounded-xl p-4">
                                <div class="flex items-start">
                                    <div class="flex-shrink-0">
                                        <i class="fas fa-exclamation-triangle text-amber-500 text-xl mt-0.5"></i>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-bold text-amber-800">Pre-Booking Notice</h4>
                                        <p class="text-sm text-amber-700 mt-1">
                                            This booking will be valid till <strong>15 days</strong>. Before this timeline if the full booking money is not paid then the booking will be cancelled automatically.
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Custom Booking Amount in Payment Overview -->
                        <div id="customBookingOverview" class="hidden bg-gradient-to-br from-orange-50 to-amber-50 p-4 rounded-xl border-2 border-orange-200">
                            <h4 class="font-bold text-gray-900 mb-2 flex items-center text-sm">
                                <i class="fas fa-coins text-orange-500 mr-2"></i>
                                Pre-Booking Payment
                            </h4>
                            <div class="space-y-1 text-sm">
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-gray-700">Your Booking Amount:</span>
                                    <span class="font-bold text-orange-600" id="customAmountDisplay">৳0</span>
                                </div>
                                <div class="flex justify-between items-center py-1">
                                    <span class="text-gray-700">Remaining Booking Money:</span>
                                    <span class="font-semibold text-gray-900" id="remainingBookingMoneyDisplay">৳0</span>
                                </div>
                            </div>
                        </div>

                        <!-- Referral Agent -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Who referred you? (Commission User) <span class="text-red-500">*</span>
                            </label>
                            <select name="referral_agent_id" required class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">Select an option</option>
                                @foreach($agents as $agent)
                                    <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->referral_code }})</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Additional Information -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-2">
                                Additional Information (Optional)
                            </label>
                            <textarea name="additional_info" rows="4" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent resize-none" placeholder="Any special requests or information..."></textarea>
                        </div>

                        <!-- Customer Details -->
                        @auth
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-50 border-2 border-blue-200 rounded-xl p-5">
                            <div class="flex items-center justify-between mb-4">
                                <h4 class="text-base font-bold text-gray-900 flex items-center">
                                    <i class="fas fa-user-circle text-primary mr-2"></i>
                                    Your Information
                                </h4>
                                <a href="{{ route('account.profile') }}" class="text-primary hover:text-primary-dark transition-colors" title="Edit Profile">
                                    <i class="fas fa-edit text-lg"></i>
                                </a>
                            </div>
                            <div class="grid grid-cols-2 gap-x-4 gap-y-3 text-sm">
                                <div>
                                    <span class="text-gray-600">Name:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ auth()->user()->name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Phone:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ auth()->user()->phone ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Email:</span>
                                    <span class="font-semibold text-gray-900 ml-1 text-xs">{{ auth()->user()->email ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">NID:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ auth()->user()->nid ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Father's Name:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ auth()->user()->father_name ?? 'N/A' }}</span>
                                </div>
                                <div>
                                    <span class="text-gray-600">Mother's Name:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ auth()->user()->mother_name ?? 'N/A' }}</span>
                                </div>
                                <div class="col-span-2">
                                    <span class="text-gray-600">Address:</span>
                                    <span class="font-semibold text-gray-900 ml-1">{{ auth()->user()->address ?? 'N/A' }}</span>
                                </div>
                            </div>
                        </div>
                        @endauth

                        <!-- Additional Owners Section -->
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <label class="block text-sm font-semibold text-gray-700">
                                    <i class="fas fa-users text-primary mr-1"></i>
                                    Additional Owners
                                </label>
                                <button type="button" id="addOwnerBtnPopup" class="inline-flex items-center gap-1 px-3 py-1.5 text-xs font-semibold text-primary bg-green-50 border border-primary/30 rounded-lg hover:bg-green-100 transition">
                                    <i class="fas fa-plus"></i> Add Additional Owner
                                </button>
                            </div>
                            <div id="ownersContainerPopup">
                                <!-- Owner entries added dynamically -->
                            </div>
                            <div id="noOwnersMessagePopup" class="text-center py-6 rounded-xl border-2 border-dashed border-gray-200" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9);">
                                <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-green-100 to-blue-100 flex items-center justify-center mx-auto mb-2">
                                    <i class="fas fa-users text-primary text-xl"></i>
                                </div>
                                <p class="text-xs font-semibold text-gray-600 mb-0.5">No Owners Added Yet</p>
                                <p class="text-xs text-gray-400">Click <span class="text-primary font-semibold">"Add Additional Owner"</span> to add additional owners.</p>
                            </div>
                        </div>

                        <!-- Terms and Conditions Checkbox -->
                        <div class="border-t pt-6">
                            <label class="flex items-start cursor-pointer group">
                                <input type="checkbox" name="terms_accepted" id="termsCheckbox" required class="w-5 h-5 text-primary border-gray-300 rounded focus:ring-2 focus:ring-primary mt-0.5 flex-shrink-0">
                                <span class="ml-3 text-sm text-gray-700 group-hover:text-gray-900">
                                    I agree to the <a href="#" class="text-primary hover:text-primary-dark font-semibold underline">Terms and Conditions</a> and <a href="#" class="text-primary hover:text-primary-dark font-semibold underline">Privacy Policy</a> of London Abason.
                                </span>
                            </label>
                            <p id="termsError" class="text-red-500 text-xs mt-2 hidden">
                                <i class="fas fa-exclamation-circle mr-1"></i>
                                Please accept the terms and conditions to proceed
                            </p>
                        </div>
                    </div>

                    <div class="flex gap-3 mt-8">
                        <button type="button" onclick="closeBookingModal()" class="flex-1 bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Cancel
                        </button>
                        <button type="submit" class="flex-1 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Confirm Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <div class="fixed inset-0 transition-opacity bg-gray-900 bg-opacity-75"></div>
            
            <div class="inline-block overflow-hidden text-left align-bottom transition-all transform bg-white rounded-2xl shadow-2xl sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-8 py-8">
                    <div class="text-center">
                        <div class="w-24 h-24 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6 animate-bounce">
                            <i class="fas fa-check-circle text-green-500 text-5xl"></i>
                        </div>
                        <h3 class="text-3xl font-bold text-gray-900 mb-3">Booking Successful!</h3>
                        <p class="text-gray-600 text-lg mb-2">Thank you for choosing London Abason</p>
                        <p class="text-gray-500 text-sm mb-8">Your booking has been submitted successfully. Our team will contact you soon.</p>
                        
                        <div class="bg-gradient-to-r from-green-50 to-blue-50 p-6 rounded-xl mb-8">
                            <div class="flex items-center justify-center space-x-2 text-sm text-gray-700 mb-3">
                                <i class="fas fa-info-circle text-primary"></i>
                                <span class="font-semibold">Booking Status: Pending</span>
                            </div>
                            <p class="text-xs text-gray-600">We'll verify your booking and contact you within 24 hours</p>
                        </div>

                        <a href="{{ route('account.bookings') }}" class="block w-full bg-primary text-white px-6 py-4 rounded-lg font-semibold text-center hover:bg-primary-dark transition shadow-lg mb-3">
                            <i class="fas fa-list-alt mr-2"></i>
                            My All Bookings
                        </a>
                        <button onclick="window.location.href='{{ route('plots.index') }}'" class="block w-full bg-gray-100 text-gray-700 px-6 py-3 rounded-lg font-semibold text-center hover:bg-gray-200 transition">
                            Browse More Plots
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    const isLoggedIn = {{ auth()->check() ? 'true' : 'false' }};
    const plotPrice = {{ $plot->price ?? 0 }};
    const bookingPayment = {{ $plot->booking_payment ?? 0 }};

    // Booking Money Option Handler
    function handleBookingMoneyOptionChange() {
        const option = document.querySelector('input[name="booking_money_option"]:checked')?.value;
        const customSection = document.getElementById('customBookingAmountSection');
        const preBookingNotice = document.getElementById('preBookingNotice');
        const customOverview = document.getElementById('customBookingOverview');
        const fullBookingLabel = document.getElementById('fullBookingLabel');
        const customBookingLabel = document.getElementById('customBookingLabel');

        // Reset styles
        fullBookingLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
        customBookingLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-orange-50', 'shadow-lg');
        fullBookingLabel.querySelector('.fa-check')?.classList.add('hidden');
        customBookingLabel.querySelector('.fa-check')?.classList.add('hidden');
        fullBookingLabel.querySelectorAll('.w-5')[0]?.classList.add('opacity-0');
        customBookingLabel.querySelectorAll('.w-5')[0]?.classList.add('opacity-0');

        if (option === 'custom') {
            customSection.classList.remove('hidden');
            preBookingNotice.classList.remove('hidden');
            customOverview.classList.remove('hidden');
            customBookingLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-orange-50', 'shadow-lg');
            customBookingLabel.querySelectorAll('.w-5')[0]?.classList.remove('opacity-0');
            customBookingLabel.querySelectorAll('.w-5')[0]?.classList.add('bg-primary', 'border-primary');
            customBookingLabel.querySelector('.fa-check')?.classList.remove('hidden');
            document.getElementById('customBookingAmount').setAttribute('required', 'required');
        } else {
            customSection.classList.add('hidden');
            preBookingNotice.classList.add('hidden');
            customOverview.classList.add('hidden');
            fullBookingLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
            fullBookingLabel.querySelectorAll('.w-5')[0]?.classList.remove('opacity-0');
            fullBookingLabel.querySelectorAll('.w-5')[0]?.classList.add('bg-primary', 'border-primary');
            fullBookingLabel.querySelector('.fa-check')?.classList.remove('hidden');
            document.getElementById('customBookingAmount').removeAttribute('required');
            document.getElementById('customBookingAmount').value = '';
        }
    }

    // Update Custom Booking Amount Display
    function updateCustomBookingDisplay() {
        const customAmount = parseFloat(document.getElementById('customBookingAmount').value) || 0;
        const remainingBooking = bookingPayment - customAmount;
        
        document.getElementById('customAmountDisplay').textContent = '৳' + customAmount.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('remainingBookingMoneyDisplay').textContent = '৳' + Math.max(0, remainingBooking).toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }

    // Payment Type Change Handler
    function handlePaymentTypeChange() {
        const paymentType = document.querySelector('input[name="payment_type"]:checked')?.value;
        const installmentSection = document.getElementById('installmentPlanSection');
        const totalInstallmentsSection = document.getElementById('totalInstallmentsSection');
        const installmentDetails = document.getElementById('installmentDetails');
        const oneTimeLabel = document.getElementById('oneTimeLabel');
        const installmentLabel = document.getElementById('installmentLabel');

        // Update label styles
        oneTimeLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg', 'scale-105');
        installmentLabel.classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-green-50', 'shadow-lg', 'scale-105');
        
        // Hide all checkmarks
        oneTimeLabel.querySelector('.fa-check').classList.add('hidden');
        installmentLabel.querySelector('.fa-check').classList.add('hidden');
        oneTimeLabel.querySelectorAll('.w-6')[0].classList.add('opacity-0');
        installmentLabel.querySelectorAll('.w-6')[0].classList.add('opacity-0');

        if (paymentType === 'installment') {
            installmentSection.classList.remove('hidden');
            totalInstallmentsSection.classList.remove('hidden');
            installmentLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-green-50', 'shadow-lg', 'scale-105');
            installmentLabel.querySelectorAll('.w-6')[0].classList.remove('opacity-0');
            installmentLabel.querySelectorAll('.w-6')[0].classList.add('bg-primary', 'border-primary');
            installmentLabel.querySelector('.fa-check').classList.remove('hidden');
            
            // Make installment fields required
            document.getElementById('installmentPlan').setAttribute('required', 'required');
            document.getElementById('totalInstallments').setAttribute('required', 'required');
        } else if (paymentType === 'one_time') {
            installmentSection.classList.add('hidden');
            totalInstallmentsSection.classList.add('hidden');
            installmentDetails.classList.add('hidden');
            oneTimeLabel.classList.add('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg', 'scale-105');
            oneTimeLabel.querySelectorAll('.w-6')[0].classList.remove('opacity-0');
            oneTimeLabel.querySelectorAll('.w-6')[0].classList.add('bg-primary', 'border-primary');
            oneTimeLabel.querySelector('.fa-check').classList.remove('hidden');
            
            // Remove required from installment fields
            document.getElementById('installmentPlan').removeAttribute('required');
            document.getElementById('totalInstallments').removeAttribute('required');
            
            // Reset installment fields
            document.getElementById('installmentPlan').value = '';
            document.getElementById('totalInstallments').value = '';
        }
    }

    // Calculate Installment
    function calculateInstallment() {
        const installmentPlan = document.getElementById('installmentPlan').value;
        const totalInstallments = parseInt(document.getElementById('totalInstallments').value) || 0;
        const installmentDetails = document.getElementById('installmentDetails');
        
        if (!installmentPlan || !totalInstallments) {
            installmentDetails.classList.add('hidden');
            return;
        }

        const remainingAmount = plotPrice - bookingPayment;
        const perInstallment = remainingAmount / totalInstallments;

        // Calculate duration
        let duration = '';
        if (installmentPlan === 'monthly') {
            const years = Math.floor(totalInstallments / 12);
            const months = totalInstallments % 12;
            if (years > 0) duration += years + (years === 1 ? ' Year' : ' Years');
            if (months > 0) duration += (years > 0 ? ' ' : '') + months + (months === 1 ? ' Month' : ' Months');
        } else if (installmentPlan === 'quarterly') {
            const years = Math.floor(totalInstallments / 4);
            const quarters = totalInstallments % 4;
            if (years > 0) duration += years + (years === 1 ? ' Year' : ' Years');
            if (quarters > 0) duration += (years > 0 ? ' ' : '') + quarters + (quarters === 1 ? ' Quarter' : ' Quarters');
        }

        // Update display
        document.getElementById('planType').textContent = installmentPlan.charAt(0).toUpperCase() + installmentPlan.slice(1);
        document.getElementById('perInstallment').textContent = '৳' + perInstallment.toLocaleString('en-BD', {minimumFractionDigits: 2, maximumFractionDigits: 2});
        document.getElementById('totalInstallmentsDisplay').textContent = totalInstallments;
        document.getElementById('duration').textContent = duration || '-';
        
        installmentDetails.classList.remove('hidden');
    }

    // Image Modal Functions
    function openImageModal() {
        document.getElementById('imageModal')?.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }

    function closeImageModal() {
        document.getElementById('imageModal')?.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Close image modal on backdrop click
    document.getElementById('imageModal')?.addEventListener('click', function(e) {
        if (e.target === this) closeImageModal();
    });

    function handleBookNow() {
        if (!isLoggedIn) {
            document.getElementById('authModal').classList.remove('hidden');
        } else {
            document.getElementById('bookingModal').classList.remove('hidden');
        }
    }

    function closeAuthModal() {
        document.getElementById('authModal').classList.add('hidden');
    }

    function closeBookingModal() {
        document.getElementById('bookingModal').classList.add('hidden');
        // Reset form
        document.getElementById('bookingForm').reset();
        document.getElementById('installmentPlanSection').classList.add('hidden');
        document.getElementById('totalInstallmentsSection').classList.add('hidden');
        document.getElementById('installmentDetails').classList.add('hidden');
        document.getElementById('customBookingAmountSection').classList.add('hidden');
        document.getElementById('preBookingNotice').classList.add('hidden');
        document.getElementById('customBookingOverview').classList.add('hidden');
        document.getElementById('oneTimeLabel').classList.remove('border-primary', 'bg-green-50');
        document.getElementById('installmentLabel').classList.remove('border-primary', 'bg-green-50');
        document.getElementById('fullBookingLabel').classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-blue-50', 'shadow-lg');
        document.getElementById('customBookingLabel').classList.remove('border-primary', 'bg-gradient-to-br', 'from-primary/5', 'to-orange-50', 'shadow-lg');
    }

    // Handle form submission
    document.getElementById('bookingForm')?.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Validate terms checkbox
        const termsCheckbox = document.getElementById('termsCheckbox');
        const termsError = document.getElementById('termsError');
        
        if (!termsCheckbox.checked) {
            termsError.classList.remove('hidden');
            termsCheckbox.focus();
            return;
        }
        termsError.classList.add('hidden');

        // Validate payment type
        const paymentType = document.querySelector('input[name="payment_type"]:checked');
        if (!paymentType) {
            alert('Please select a payment type');
            return;
        }

        // Validate booking money option
        const bookingMoneyOption = document.querySelector('input[name="booking_money_option"]:checked');
        if (!bookingMoneyOption) {
            alert('Please select a booking money option');
            return;
        }

        // If custom booking, validate amount
        if (bookingMoneyOption.value === 'custom') {
            const customAmount = parseFloat(document.getElementById('customBookingAmount').value) || 0;
            if (customAmount <= 0) {
                alert('Please enter a valid custom booking amount');
                return;
            }
            if (customAmount >= bookingPayment) {
                alert('Custom amount must be less than the full booking money. Select "Paying Full Booking Money" option instead.');
                return;
            }
        }

        // If installment, validate installment fields
        if (paymentType.value === 'installment') {
            const installmentPlan = document.getElementById('installmentPlan').value;
            const totalInstallments = document.getElementById('totalInstallments').value;
            
            if (!installmentPlan || !totalInstallments) {
                alert('Please complete all installment plan details');
                return;
            }
        }
        
        const formData = new FormData(this);
        const submitBtn = this.querySelector('button[type="submit"]');
        const originalText = submitBtn.innerHTML;
        
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Processing...';

        fetch(this.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                closeBookingModal();
                
                // Update success modal message if pre-booked
                if (data.is_pre_booked) {
                    const statusInfo = document.querySelector('#successModal .bg-gradient-to-r');
                    if (statusInfo) {
                        statusInfo.innerHTML = `
                            <div class="flex items-center justify-center space-x-2 text-sm text-amber-700 mb-3">
                                <i class="fas fa-clock"></i>
                                <span class="font-semibold">Booking Status: Pre-Booked</span>
                            </div>
                            <p class="text-xs text-amber-600 font-medium">This booking is valid for 15 days. Please pay the full booking money before the deadline to confirm your booking.</p>
                        `;
                        statusInfo.classList.remove('from-green-50', 'to-blue-50');
                        statusInfo.classList.add('from-amber-50', 'to-orange-50');
                    }
                }
                
                document.getElementById('successModal').classList.remove('hidden');
            } else {
                alert(data.message || 'Something went wrong. Please try again.');
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalText;
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('An error occurred. Please try again.');
            submitBtn.disabled = false;
            submitBtn.innerHTML = originalText;
        });
    });

    // Close modals on ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeAuthModal();
            closeBookingModal();
            closeImageModal();
        }
    });

    // ===== Owners Management for Popup =====
    let popupOwnerIndex = 0;

    function createPopupOwnerCard(index) {
        return `
        <div class="popup-owner-card bg-gray-50 border border-gray-200 rounded-xl p-4 mb-3 relative" data-owner-index="${index}">
            <div class="flex items-center justify-between mb-3">
                <h5 class="text-sm font-bold text-gray-800 flex items-center">
                    <i class="fas fa-user text-primary mr-1.5"></i>
                    Additional Owner #<span class="popup-owner-number">${index + 1}</span>
                </h5>
                <button type="button" class="remove-popup-owner-btn w-6 h-6 flex items-center justify-center rounded-full bg-red-100 text-red-500 hover:bg-red-200 transition" title="Remove">
                    <i class="fas fa-times text-xs"></i>
                </button>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][name]" placeholder="Full Name" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Phone <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][phone]" placeholder="Phone Number" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">NID <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][nid]" placeholder="National ID" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Address <span class="text-red-500">*</span></label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][address]" placeholder="Full Address" required>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Father's Name</label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][father_name]" placeholder="Father's Name">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Mother's Name</label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][mother_name]" placeholder="Mother's Name">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Spouse's Name</label>
                    <input type="text" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][spouse_name]" placeholder="Spouse's Name">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-medium text-gray-600 mb-1">Nominee Info</label>
                    <textarea rows="3" class="w-full px-3 py-2 text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" name="owners[${index}][nominee_info]" placeholder="Nominee name, relation, NID, phone, address, etc."></textarea>
                </div>
            </div>
        </div>`;
    }

    function updatePopupOwnerNumbers() {
        document.querySelectorAll('#ownersContainerPopup .popup-owner-card').forEach((card, i) => {
            card.querySelector('.popup-owner-number').textContent = i + 1;
        });
        const hasOwners = document.querySelectorAll('#ownersContainerPopup .popup-owner-card').length > 0;
        document.getElementById('noOwnersMessagePopup').style.display = hasOwners ? 'none' : 'block';
    }

    document.getElementById('addOwnerBtnPopup')?.addEventListener('click', function() {
        document.getElementById('ownersContainerPopup').insertAdjacentHTML('beforeend', createPopupOwnerCard(popupOwnerIndex));
        popupOwnerIndex++;
        updatePopupOwnerNumbers();
    });

    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-popup-owner-btn')) {
            const card = e.target.closest('.popup-owner-card');
            card.style.transition = 'all 0.2s';
            card.style.opacity = '0';
            card.style.maxHeight = '0';
            card.style.overflow = 'hidden';
            setTimeout(() => {
                card.remove();
                updatePopupOwnerNumbers();
            }, 200);
        }
    });
</script>
@endpush
