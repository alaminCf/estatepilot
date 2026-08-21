@extends('Website.layouts.app')

@section('title', site_name() . ' - ' . site_tagline())

@section('content')
    <!-- Hero Section -->
    <section id="home" class="relative pt-20 min-h-screen flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1564013799919-ab600027ffc6?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80" 
                 alt="Real Estate" 
                 class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div class="text-white space-y-6">
                    <div class="inline-block">
                        <span class="bg-white/10 backdrop-blur-sm text-white px-4 py-2 rounded-full text-sm font-medium border border-white/20">
                            Welcome to {{ site_name() }}
                        </span>
                    </div>
                    
                    <h1 class="text-5xl md:text-6xl font-bold leading-tight">
                        Build Your Dream Home
                        <!-- <span class="text-primary"> -->
                            Near Dhaka
                        <!-- </span> -->
                    </h1>
                    
                    <p class="text-xl text-gray-200 leading-relaxed">
                        {{ site_legal_name() }} offers strategically located residential plots with organized infrastructure, proper road access, and long-term development potential.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 pt-4">
                        <a href="{{ route('plots.index') }}" class="bg-white text-primary px-8 py-4 rounded-lg font-semibold hover:bg-gray-100 transition shadow-xl transform hover:scale-105">
                            <i class="fas fa-search mr-2"></i>
                            Browse Plots
                        </a>
                        <a href="{{ route('contact') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-semibold hover:bg-white hover:text-primary transition">
                            <i class="fas fa-phone-alt mr-2"></i>
                            Contact Us
                        </a>
                    </div>

                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-6 pt-8">
                        <div class="bg-white/10 rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <div class="text-2xl font-bold text-white mb-1">500+</div>
                            <div class="text-sm text-gray-200 font-medium">Plots Sold</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <div class="text-2xl font-bold text-white mb-1">1000+</div>
                            <div class="text-sm text-gray-200 font-medium">Happy Clients</div>
                        </div>
                        <div class="bg-white/10 rounded-xl p-4 border border-white/20 hover:bg-white/20 transition-all duration-300">
                            <div class="text-2xl font-bold text-white mb-1">15+</div>
                            <div class="text-sm text-gray-200 font-medium">Prime Locations</div>
                        </div>
                    </div>

                    
                </div>

                <!-- Right Content - Quick Search Card -->
                <div class="bg-white rounded-2xl shadow-2xl p-8 ml-auto" style="max-width: 420px; width: 100%;">
                    <h3 class="text-2xl font-bold text-gray-900 mb-6">Find Your Plot</h3>
                    
                    <form action="{{ route('plots.index') }}" method="GET" class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Block</label>
                            <select name="block" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">All Blocks</option>
                                @foreach($blocks as $block)
                                    <option value="{{ $block }}">Block {{ $block }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Plot Size</label>
                            <select name="size" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">All Sizes</option>
                                @foreach($sizes as $size)
                                    <option value="{{ $size }}">{{ $size }} Katha</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Facing</label>
                            <select name="facing" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="">All Directions</option>
                                @foreach($facings as $facing)
                                    <option value="{{ $facing }}">{{ $facing }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Price Range</label>
                            <div class="grid grid-cols-2 gap-3">
                                <input type="number" name="price_min" placeholder="Min (৳)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" step="1">
                                <input type="number" name="price_max" placeholder="Max (৳)" class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" step="1">
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-primary text-white px-6 py-4 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                            <i class="fas fa-search mr-2"></i>
                            Search Plots
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Scroll Indicator -->
        <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
            <a href="#plots" class="text-white">
                <i class="fas fa-chevron-down text-2xl"></i>
            </a>
        </div>
    </section>

    <!-- Featured Plots Section -->
    <section id="plots" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-8">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Our Properties</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Featured Plots</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Explore our carefully selected premium plots in prime locations with flexible payment options
                </p>
            </div>

            <!-- Tab Buttons -->
            <div class="flex items-center justify-center mb-10">
                <div class="inline-flex rounded-lg border border-gray-300 overflow-hidden shadow-sm">
                    <button id="featuredCardsBtn" onclick="switchFeaturedTab('cards')" class="flex items-center gap-2 px-6 py-3 text-sm font-semibold transition-colors duration-200 bg-primary text-white">
                        <i class="fas fa-th-large"></i> Plot Cards
                    </button>
                    <button id="featuredMapBtn" onclick="switchFeaturedTab('map')" class="flex items-center gap-2 px-6 py-3 text-sm font-semibold border-l border-gray-300 transition-colors duration-200 bg-white text-gray-700 hover:bg-gray-50">
                        <i class="fas fa-map-marked-alt"></i> Plot Map
                    </button>
                </div>
            </div>

            <!-- Plot Cards Grid -->
            <div id="featuredCardsView">
            <div class="grid md:grid-cols-3 gap-8 mb-12">
                @forelse($featuredPlots as $plot)
                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                    <div class="relative overflow-hidden">
                        @if($plot->plot_map)
                            <img src="{{ asset($plot->plot_map) }}" alt="{{ $plot->title }}" class="w-full h-64 object-cover group-hover:scale-110 transition-transform duration-500">
                        @else
                            <div class="w-full h-64 bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center">
                                <i class="fas fa-map-marked-alt text-white text-5xl opacity-50"></i>
                            </div>
                        @endif
                        <div class="absolute top-4 left-4">
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">Available</span>
                        </div>
                        <div class="absolute top-4 right-4">
                            <span class="bg-white text-gray-900 px-3 py-1 rounded-full text-sm font-semibold">{{ $plot->block }}</span>
                        </div>
                    </div>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-3">
                            <h3 class="text-xl font-bold text-gray-900">{{ $plot->plot_no }}</h3>
                            <span class="text-2xl font-bold text-primary">৳{{ format_bd_number($plot->price, 2) }}</span>
                        </div>
                        <p class="text-gray-600 mb-4">{{ $plot->title }}</p>
                        
                        <div class="grid grid-cols-2 gap-4 mb-4 pb-4 border-b">
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-ruler-combined text-primary mr-2"></i>
                                <span class="text-sm">{{ $plot->size_katha }} Katha</span>
                            </div>
                            <div class="flex items-center text-gray-700">
                                <i class="fas fa-compass text-primary mr-2"></i>
                                <span class="text-sm">{{ $plot->facing }}</span>
                            </div>
                        </div>

                        <div class="space-y-2 mb-4">
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">Booking Money:</span>
                                <span class="font-semibold text-gray-900">৳{{ format_bd_number($plot->booking_payment, 2) }}</span>
                            </div>
                            @if($plot->installment_plan)
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-600">{{ ucfirst($plot->installment_plan) }} EMI:</span>
                                <span class="font-semibold text-gray-900">৳{{ format_bd_number($plot->installment_payment) }}</span>
                            </div>
                            @endif
                        </div>

                        <a href="{{ route('plot.details', $plot->id) }}" class="block w-full bg-primary text-white px-4 py-3 rounded-lg font-semibold hover:bg-primary-dark transition text-center">
                            <i class="fas fa-eye mr-2"></i>
                            View Details
                        </a>
                    </div>
                </div>
                @empty
                <div class="col-span-3 text-center py-12">
                    <i class="fas fa-home text-gray-300 text-6xl mb-4"></i>
                    <p class="text-gray-500 text-lg">No plots available at the moment</p>
                </div>
                @endforelse
            </div>

            </div>

            <!-- Plot Map View -->
            <div id="featuredMapView" class="hidden">
                @php
                    $plotsByBlock = $allPlotsForMap->groupBy('block');
                @endphp

                @if($plotsByBlock->count() > 0)
                    <!-- Legend -->
                    <div class="flex flex-wrap items-center justify-center gap-4 mb-6">
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded bg-green-500 inline-block"></span>
                            <span class="text-sm text-gray-700">Available</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded bg-yellow-400 inline-block"></span>
                            <span class="text-sm text-gray-700">Pending</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-4 h-4 rounded bg-red-500 inline-block"></span>
                            <span class="text-sm text-gray-700">Booked/Sold</span>
                        </div>
                    </div>

                    <div class="space-y-8">
                        @foreach($plotsByBlock as $blockName => $blockPlots)
                            <div class="bg-white rounded-xl shadow-lg p-5 border border-gray-200">
                                <!-- Block Header -->
                                <div class="flex items-center justify-between mb-4">
                                    <h3 class="text-lg font-bold text-gray-900 flex items-center">
                                        <i class="fas fa-th-large text-primary mr-2"></i>
                                        Block {{ $blockName }}
                                    </h3>
                                    <div class="flex items-center gap-3 text-sm">
                                        <span class="text-green-600 font-medium">
                                            <i class="fas fa-check-circle mr-1"></i>
                                            {{ $blockPlots->where('status', 'available')->count() }} Available
                                        </span>
                                        <span class="text-red-600 font-medium">
                                            <i class="fas fa-times-circle mr-1"></i>
                                            {{ $blockPlots->whereIn('status', ['booked', 'sold'])->count() }} Booked
                                        </span>
                                    </div>
                                </div>

                                <!-- Plots Grid grouped by Road -->
                                @php
                                    $plotsByRoad = $blockPlots->groupBy('road_no');
                                @endphp
                                @foreach($plotsByRoad as $roadNo => $roadPlots)
                                    @if(!$loop->first)
                                        <div style="background:linear-gradient(90deg,transparent 0%,#9ca3af 10%,#9ca3af 90%,transparent 100%);height:3px;position:relative;margin:12px 0;">
                                            <span style="position:absolute;left:50%;top:50%;transform:translate(-50%,-50%);background:#f59e0b;color:white;padding:2px 12px;border-radius:9999px;font-size:0.7rem;font-weight:700;white-space:nowrap;z-index:10;"><i class="fas fa-road mr-1"></i>Road {{ $roadNo }}</span>
                                        </div>
                                    @else
                                        <div class="flex items-center gap-2 mb-2">
                                            <span class="inline-flex items-center bg-amber-100 text-amber-800 text-xs font-bold px-3 py-1 rounded-full">
                                                <i class="fas fa-road mr-1"></i>Road {{ $roadNo }}
                                                @if($roadPlots->first()->road_width)
                                                    <span class="ml-1 text-amber-600">({{ $roadPlots->first()->road_width }})</span>
                                                @endif
                                            </span>
                                        </div>
                                    @endif
                                    <div class="grid grid-cols-4 sm:grid-cols-6 md:grid-cols-8 lg:grid-cols-10 xl:grid-cols-12 gap-2 mb-2">
                                        @foreach($roadPlots as $mapPlot)
                                            @php
                                                $statusClass = match($mapPlot->status) {
                                                    'available' => 'bg-green-500 hover:bg-green-600 border-green-600 cursor-pointer text-white hover:scale-110 hover:shadow-lg',
                                                    'pending' => 'bg-yellow-400 border-yellow-500 cursor-not-allowed text-gray-800',
                                                    'booked', 'sold' => 'bg-red-500 border-red-600 cursor-not-allowed text-white',
                                                    default => 'bg-gray-400 border-gray-500 cursor-not-allowed text-white'
                                                };
                                                $isClickable = $mapPlot->status === 'available';
                                            @endphp
                                            @if($isClickable)
                                                <a href="{{ route('plot.details', $mapPlot->id) }}"
                                                   class="aspect-square rounded-lg border-2 flex items-center justify-center text-xs font-bold transition-all duration-200 {{ $statusClass }}"
                                                   style="min-width:45px;min-height:45px;font-size:0.65rem;box-shadow:0 1px 3px rgba(0,0,0,0.12);position:relative;"
                                                   title="Plot {{ $mapPlot->plot_no }} - {{ $mapPlot->size_katha }} Katha - ৳{{ number_format($mapPlot->price) }} - Click to view">
                                                    <span class="truncate px-1">{{ $mapPlot->plot_no }}</span>
                                                </a>
                                            @else
                                                <div class="aspect-square rounded-lg border-2 flex items-center justify-center text-xs font-bold {{ $statusClass }}"
                                                     style="min-width:45px;min-height:45px;font-size:0.65rem;box-shadow:0 1px 3px rgba(0,0,0,0.12);position:relative;"
                                                     title="Plot {{ $mapPlot->plot_no }} - {{ ucfirst($mapPlot->status) }}">
                                                    <span class="truncate px-1">{{ $mapPlot->plot_no }}</span>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-12">
                        <i class="fas fa-map text-gray-300 text-6xl mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-900 mb-2">No Plots Available</h3>
                    </div>
                @endif
            </div>

            <!-- View All Button -->
            <div class="text-center mt-12">
                <a href="{{ route('plots.index') }}" class="bg-white border-2 border-primary text-primary px-8 py-4 rounded-lg font-semibold hover:bg-primary hover:text-white transition shadow-lg inline-flex items-center space-x-2">
                    <span>View All Plots</span>
                    <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="py-20 bg-white" style="margin-bottom: 30px;">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-20 items-center">
                <!-- Left Content - Image -->
                <div class="relative">
                    <div class="relative rounded-2xl overflow-hidden shadow-2xl">
                        <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?w=800" 
                             alt="{{ site_name() }} Office" 
                             class="w-full h-[600px] object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-primary/80 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8 text-white">
                            <div class="flex items-center space-x-6">
                                <div class="text-center">
                                    <div class="text-4xl font-bold">10+</div>
                                    <div class="text-sm text-green-100">Years</div>
                                </div>
                                <div class="w-px h-12 bg-white/30"></div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold">500+</div>
                                    <div class="text-sm text-green-100">Projects</div>
                                </div>
                                <div class="w-px h-12 bg-white/30"></div>
                                <div class="text-center">
                                    <div class="text-4xl font-bold">1000+</div>
                                    <div class="text-sm text-green-100">Clients</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Decorative Elements -->
                    <div class="absolute -bottom-8 -right-8 w-40 h-40 bg-gradient-to-br from-primary to-primary-dark rounded-3xl opacity-90 animate-bounce-slow flex items-center justify-center shadow-2xl">
                        <i class="fas fa-map-marked-alt text-white text-5xl opacity-50"></i>
                    </div>
                    <div class="absolute -top-8 -left-8 w-24 h-24 bg-yellow-400 rounded-full opacity-20 animate-pulse flex items-center justify-center">
                        <i class="fas fa-home text-white text-3xl opacity-70"></i>
                    </div>
                </div>

                <!-- Right Content - Text -->
                <div class="space-y-6">
                    <span class="text-primary font-semibold text-sm uppercase tracking-wider">About Us</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-gray-900 leading-tight">
                        Building Dreams,
                        <span class="text-primary">Creating Communities</span>
                    </h2>
                    <p class="text-lg text-gray-600 leading-relaxed">
                        {{ site_legal_name() }} is a trusted name in Bangladesh's real estate sector, 
                        dedicated to providing premium residential and commercial plots in strategically planned locations.
                    </p>
                    <p class="text-gray-600 leading-relaxed">
                        Our commitment to quality, transparency, and customer 
                        satisfaction has made us a preferred choice for property investors.
                    </p>

                    <!-- Key Points -->
                    <div class="space-y-4 pt-4">
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bullseye text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Our Mission</h4>
                                <p class="text-gray-600 text-sm">To provide affordable, legally secured plots with proper infrastructure in prime locations.</p>
                            </div>
                        </div>
                        <div class="flex items-start space-x-4">
                            <div class="w-12 h-12 bg-primary/10 rounded-lg flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-eye text-primary text-xl"></i>
                            </div>
                            <div>
                                <h4 class="font-semibold text-gray-900 mb-1">Our Vision</h4>
                                <p class="text-gray-600 text-sm">To be the most trusted real estate company, creating sustainable communities for future generations.</p>
                            </div>
                        </div>
                    </div>

                    <!-- CTA Buttons -->
                    <div class="flex flex-wrap gap-4 pt-6">
                        <a href="{{ route('about') }}" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                            Learn More
                        </a>
                        <a href="{{ route('contact') }}" class="bg-gray-100 text-gray-900 px-8 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                            <i class="fas fa-envelope mr-2"></i>
                            Contact Us
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="py-20 bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">How It Works</span>
                <h2 class="text-4xl md:text-5xl font-bold text-white mt-2 mb-4">Your Journey to Land Ownership</h2>
                <p class="text-gray-300 text-lg max-w-2xl mx-auto">
                    Simple 4-step process to own your dream plot
                </p>
            </div>

            <div class="relative">
                <!-- Connection Line -->
                <div class="hidden md:block absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-4/5 h-1 bg-gradient-to-r from-primary via-primary-light to-primary" style="top: 80px;"></div>

                <div class="grid md:grid-cols-4 gap-8 relative">
                    <!-- Step 1 -->
                    <div class="text-center">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 mx-auto relative z-10">
                                <i class="fas fa-search text-white text-4xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-gray-900 shadow-lg z-20">
                                1
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Browse Plots</h3>
                        <p class="text-gray-300">
                            Explore our wide range of residential and commercial plots in prime locations
                        </p>
                    </div>

                    <!-- Step 2 -->
                    <div class="text-center">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 mx-auto relative z-10">
                                <i class="fas fa-map-marked-alt text-white text-4xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-gray-900 shadow-lg z-20">
                                2
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Visit Location</h3>
                        <p class="text-gray-300">
                            Schedule a free site visit with our team to see the plot and nearby facilities
                        </p>
                    </div>

                    <!-- Step 3 -->
                    <div class="text-center">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 mx-auto relative z-10">
                                <i class="fas fa-file-signature text-white text-4xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-gray-900 shadow-lg z-20">
                                3
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Book Your Plot</h3>
                        <p class="text-gray-300">
                            Pay booking money and complete the documentation with our legal support
                        </p>
                    </div>

                    <!-- Step 4 -->
                    <div class="text-center">
                        <div class="relative inline-block mb-6">
                            <div class="w-32 h-32 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center shadow-2xl transform hover:scale-110 transition-all duration-300 mx-auto relative z-10">
                                <i class="fas fa-key text-white text-4xl"></i>
                            </div>
                            <div class="absolute -top-2 -right-2 w-12 h-12 bg-yellow-400 rounded-full flex items-center justify-center font-bold text-gray-900 shadow-lg z-20">
                                4
                            </div>
                        </div>
                        <h3 class="text-xl font-bold text-white mb-3">Get Ownership</h3>
                        <p class="text-gray-300">
                            Complete payments as per plan and receive full ownership documents
                        </p>
                    </div>
                </div>
            </div>

            <!-- CTA Button -->
            <div class="text-center mt-16">
                <a href="{{ route('register') }}" class="inline-block bg-primary text-white px-10 py-4 rounded-lg font-bold text-lg hover:bg-primary-dark transition shadow-xl transform hover:scale-105">
                    <i class="fas fa-rocket mr-2"></i>
                    Start Your Journey Today
                </a>
            </div>
        </div>
    </section>

    <!-- Why Choose Us Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Why Choose Us</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">What Makes Us Different</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    We provide exceptional service and support to help you find your dream plot with confidence
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8 mb-12">
                <!-- Feature 1 -->
                <div class="bg-gradient-to-br from-green-50 to-white p-8 rounded-2xl hover:shadow-xl transition-all duration-300 border border-green-100">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Legal Clarity</h3>
                    <p class="text-gray-600 leading-relaxed">
                        100% legally verified plots with clear documentation. We ensure all paperwork is transparent and hassle-free.
                    </p>
                </div>

                <!-- Feature 2 -->
                <div class="bg-gradient-to-br from-blue-50 to-white p-8 rounded-2xl hover:shadow-xl transition-all duration-300 border border-blue-100">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-credit-card text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Flexible Payment</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Easy installment plans tailored to your budget. Pay monthly or quarterly with zero hidden charges.
                    </p>
                </div>

                <!-- Feature 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-white p-8 rounded-2xl hover:shadow-xl transition-all duration-300 border border-purple-100">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-map-marked-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Prime Locations</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Strategic locations with excellent connectivity, nearby amenities, and high appreciation potential.
                    </p>
                </div>

                <!-- Feature 4 -->
                <div class="bg-gradient-to-br from-yellow-50 to-white p-8 rounded-2xl hover:shadow-xl transition-all duration-300 border border-yellow-100">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-users text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">Expert Guidance</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Professional team to guide you through every step from selection to documentation and beyond.
                    </p>
                </div>

                <!-- Feature 5 -->
                <div class="bg-gradient-to-br from-red-50 to-white p-8 rounded-2xl hover:shadow-xl transition-all duration-300 border border-red-100">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">SMS Reminders</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Automated payment reminders and updates via SMS to keep you informed about your installments.
                    </p>
                </div>

                <!-- Feature 6 -->
                <div class="bg-gradient-to-br from-indigo-50 to-white p-8 rounded-2xl hover:shadow-xl transition-all duration-300 border border-indigo-100">
                    <div class="w-16 h-16 bg-primary rounded-xl flex items-center justify-center mb-6 shadow-lg shadow-primary/30">
                        <i class="fas fa-chart-line text-white text-2xl"></i>
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-3">High ROI</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Proven track record of 15-20% annual appreciation in property value for maximum returns on investment.
                    </p>
                </div>
            </div>

            <!-- Stats Banner -->
            <div class="bg-gradient-to-r from-primary to-primary-dark rounded-2xl p-12 text-white shadow-2xl">
                <div class="grid md:grid-cols-4 gap-8 text-center">
                    <div>
                        <div class="text-5xl font-bold mb-2">500+</div>
                        <div class="text-green-100">Plots Delivered</div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">1000+</div>
                        <div class="text-green-100">Happy Families</div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">15+</div>
                        <div class="text-green-100">Prime Locations</div>
                    </div>
                    <div>
                        <div class="text-5xl font-bold mb-2">10+</div>
                        <div class="text-green-100">Years Experience</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">Testimonials</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">What Our Clients Say</h2>
                <p class="text-gray-600 text-lg max-w-2xl mx-auto">
                    Real stories from real people who found their dream plots with us
                </p>
            </div>

            <div class="grid md:grid-cols-3 gap-8">
                <!-- Testimonial 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-lg">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-6 leading-relaxed">
                        "Excellent service! The team guided us through every step. The installment plan was very flexible and the plot location is perfect. Highly recommended!"
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-4">
                            AR
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Ahmed Rahman</h4>
                            <p class="text-sm text-gray-500">Plot Owner, Block A</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-lg">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-6 leading-relaxed">
                        "Very professional and transparent process. All documents were clear and legally verified. The SMS reminders for payments are very helpful."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-4">
                            SK
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Sultana Karim</h4>
                            <p class="text-sm text-gray-500">Plot Owner, Block B</p>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg hover:shadow-xl transition-all duration-300">
                    <div class="flex items-center mb-4">
                        <div class="flex text-yellow-400 text-lg">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <p class="text-gray-700 italic mb-6 leading-relaxed">
                        "Best real estate company! Found my perfect plot at a great location. The customer support is amazing and they helped with all the paperwork."
                    </p>
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center text-white font-bold mr-4">
                            MI
                        </div>
                        <div>
                            <h4 class="font-semibold text-gray-900">Mohammad Islam</h4>
                            <p class="text-sm text-gray-500">Plot Owner, Block C</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Trust Badges -->
            <div class="mt-16 grid md:grid-cols-4 gap-6">
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <i class="fas fa-certificate text-primary text-3xl mb-3"></i>
                    <h4 class="font-semibold text-gray-900">Certified</h4>
                    <p class="text-sm text-gray-600">RAJUK Approved</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <i class="fas fa-award text-primary text-3xl mb-3"></i>
                    <h4 class="font-semibold text-gray-900">Award Winning</h4>
                    <p class="text-sm text-gray-600">Best Developer 2025</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <i class="fas fa-handshake text-primary text-3xl mb-3"></i>
                    <h4 class="font-semibold text-gray-900">Trusted</h4>
                    <p class="text-sm text-gray-600">1000+ Happy Clients</p>
                </div>
                <div class="bg-white p-6 rounded-xl shadow-md text-center">
                    <i class="fas fa-lock text-primary text-3xl mb-3"></i>
                    <h4 class="font-semibold text-gray-900">Secure</h4>
                    <p class="text-sm text-gray-600">100% Legal Papers</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Banner Section -->
    <section class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="relative bg-gradient-to-r from-primary to-primary-dark rounded-3xl overflow-hidden shadow-2xl">
                <!-- Background Pattern -->
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23ffffff\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
                </div>

                <div class="relative grid md:grid-cols-2 gap-12 items-center p-12 md:p-16">
                    <!-- Left Content -->
                    <div class="text-white">
                        <h2 class="text-4xl md:text-5xl font-bold mb-6 leading-tight">
                            Ready to Own Your Dream Plot?
                        </h2>
                        <p class="text-xl text-green-100 mb-8 leading-relaxed">
                            Don't miss out on prime locations with flexible payment plans. Book your plot today and secure your future investment.
                        </p>
                        
                        <ul class="space-y-4 mb-8">
                            <li class="flex items-center text-green-100">
                                <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                                <span>Zero booking hassle</span>
                            </li>
                            <li class="flex items-center text-green-100">
                                <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                                <span>Flexible EMI options</span>
                            </li>
                            <li class="flex items-center text-green-100">
                                <i class="fas fa-check-circle text-white text-xl mr-3"></i>
                                <span>Instant plot confirmation</span>
                            </li>
                        </ul>

                        <div class="flex flex-wrap gap-4">
                            <a href="{{ route('contact') }}" class="bg-white text-primary px-8 py-4 rounded-lg font-bold hover:bg-gray-100 transition shadow-xl transform hover:scale-105">
                                <i class="fas fa-phone-alt mr-2"></i>
                                Contact Us Now
                            </a>
                            <a href="{{ route('plots.index') }}" class="bg-transparent border-2 border-white text-white px-8 py-4 rounded-lg font-bold hover:bg-white hover:text-primary transition">
                                <i class="fas fa-map-marked-alt mr-2"></i>
                                Visit Our Plots
                            </a>
                        </div>
                    </div>

                    <!-- Right Content - Contact Form -->
                    <div class="bg-white rounded-2xl p-8 shadow-2xl">
                        <h3 class="text-2xl font-bold text-gray-900 mb-6">Get a Free Consultation</h3>
                        <form class="space-y-4">
                            <div>
                                <input type="text" 
                                       placeholder="Your Name" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <input type="tel" 
                                       placeholder="Phone Number" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <input type="email" 
                                       placeholder="Email Address" 
                                       class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                            </div>
                            <div>
                                <select class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option>I'm interested in...</option>
                                    <option>Residential Plot</option>
                                    <option>Commercial Plot</option>
                                    <option>Both</option>
                                </select>
                            </div>
                            <div>
                                <textarea rows="3" 
                                          placeholder="Your Message (Optional)" 
                                          class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent"></textarea>
                            </div>
                            <button type="submit" class="w-full bg-primary text-white px-6 py-4 rounded-lg font-bold hover:bg-primary-dark transition shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Submit Request
                            </button>
                        </form>
                        <p class="text-xs text-gray-500 text-center mt-4">
                            We'll contact you within 24 hours
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section id="faq" class="py-20 bg-gray-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-primary font-semibold text-sm uppercase tracking-wider">FAQ</span>
                <h2 class="text-4xl md:text-5xl font-bold text-gray-900 mt-2 mb-4">Frequently Asked Questions</h2>
                <p class="text-gray-600 text-lg">
                    Find answers to common questions about buying plots with us
                </p>
            </div>

            <div class="space-y-4">
                <!-- FAQ 1 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-lg">What are the payment options available?</span>
                        <i class="fas fa-chevron-down text-primary transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            We offer flexible payment plans including booking money, down payment, and monthly/quarterly installments. 
                            You can choose a plan that suits your budget. No hidden charges apply, and all terms are clearly documented.
                        </p>
                    </div>
                </div>

                <!-- FAQ 2 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-lg">Are all plots legally verified?</span>
                        <i class="fas fa-chevron-down text-primary transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Yes, all our plots are 100% legally verified with clear land titles. We provide complete documentation 
                            including RAJUK approval, mutation, and registry. Our legal team ensures all paperwork is transparent and authentic.
                        </p>
                    </div>
                </div>

                <!-- FAQ 3 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-lg">How long does the booking process take?</span>
                        <i class="fas fa-chevron-down text-primary transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            The booking process is quick and simple. Once you select a plot and pay the booking money, 
                            we provide instant confirmation. Complete documentation usually takes 7-15 working days depending on the location.
                        </p>
                    </div>
                </div>

                <!-- FAQ 4 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-lg">Can I visit the plot location before buying?</span>
                        <i class="fas fa-chevron-down text-primary transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Absolutely! We encourage all our clients to visit the plot locations. You can schedule a free site visit 
                            with our team who will guide you through the property, show nearby facilities, and answer all your questions.
                        </p>
                    </div>
                </div>

                <!-- FAQ 5 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-lg">What happens if I miss an installment payment?</span>
                        <i class="fas fa-chevron-down text-primary transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            We understand that circumstances can change. If you miss a payment, we send SMS reminders. 
                            We offer a grace period and can discuss payment rescheduling options. Our team works with you to find solutions.
                        </p>
                    </div>
                </div>

                <!-- FAQ 6 -->
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
                    <button class="faq-question w-full px-8 py-6 text-left flex justify-between items-center hover:bg-gray-50 transition">
                        <span class="font-semibold text-gray-900 text-lg">Do you provide after-sales support?</span>
                        <i class="fas fa-chevron-down text-primary transition-transform"></i>
                    </button>
                    <div class="faq-answer hidden px-8 pb-6">
                        <p class="text-gray-600 leading-relaxed">
                            Yes! We provide comprehensive after-sales support including construction guidance, utility connections, 
                            and property management services. Our relationship with clients continues long after the purchase.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Still Have Questions CTA -->
            <div class="text-center mt-12 p-8 bg-white rounded-2xl shadow-lg">
                <h3 class="text-2xl font-bold text-gray-900 mb-3">Still Have Questions?</h3>
                <p class="text-gray-600 mb-6">Our team is here to help you 24/7</p>
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('faq') }}" class="bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition inline-flex items-center">
                        <i class="fas fa-question-circle mr-2"></i>
                        Learn More
                    </a>
                    <a href="{{ route('contact') }}" class="bg-gray-100 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition inline-flex items-center">
                        <i class="fas fa-envelope mr-2"></i>
                        Contact Us
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function switchFeaturedTab(tab) {
        const cardsView = document.getElementById('featuredCardsView');
        const mapView = document.getElementById('featuredMapView');
        const cardsBtn = document.getElementById('featuredCardsBtn');
        const mapBtn = document.getElementById('featuredMapBtn');

        if (tab === 'map') {
            cardsView.classList.add('hidden');
            mapView.classList.remove('hidden');
            mapBtn.classList.add('bg-primary', 'text-white');
            mapBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
            cardsBtn.classList.remove('bg-primary', 'text-white');
            cardsBtn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
        } else {
            cardsView.classList.remove('hidden');
            mapView.classList.add('hidden');
            cardsBtn.classList.add('bg-primary', 'text-white');
            cardsBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
            mapBtn.classList.remove('bg-primary', 'text-white');
            mapBtn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
        }
    }
</script>
@endpush
