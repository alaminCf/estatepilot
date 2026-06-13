@extends('Website.layouts.app')

@section('title', 'Browse Plots - London Abason')

@push('styles')
<style>
    /* Map View Plot Cells */
    .plot-cell {
        min-width: 45px;
        min-height: 45px;
        font-size: 0.65rem;
        box-shadow: 0 1px 3px rgba(0,0,0,0.12);
    }
    
    @media (min-width: 640px) {
        .plot-cell {
            min-width: 50px;
            min-height: 50px;
            font-size: 0.7rem;
        }
    }
    
    @media (min-width: 768px) {
        .plot-cell {
            min-width: 55px;
            min-height: 55px;
            font-size: 0.75rem;
        }
    }

    /* Road separator */
    .road-separator {
        background: linear-gradient(90deg, transparent 0%, #9ca3af 10%, #9ca3af 90%, transparent 100%);
        height: 3px;
        position: relative;
        margin: 12px 0;
    }
    .road-separator::before {
        content: '';
        position: absolute;
        top: -1px;
        left: 0;
        right: 0;
        height: 1px;
        border-top: 2px dashed #d1d5db;
    }
    .road-separator::after {
        content: '';
        position: absolute;
        bottom: -1px;
        left: 0;
        right: 0;
        height: 1px;
        border-bottom: 2px dashed #d1d5db;
    }
    .road-label {
        position: absolute;
        left: 50%;
        top: 50%;
        transform: translate(-50%, -50%);
        background: #f59e0b;
        color: white;
        padding: 2px 12px;
        border-radius: 9999px;
        font-size: 0.7rem;
        font-weight: 700;
        white-space: nowrap;
        z-index: 10;
        letter-spacing: 0.03em;
        box-shadow: 0 1px 4px rgba(0,0,0,0.18);
    }
    
    /* Hover tooltip effect for available plots */
    .plot-cell[title]:hover::after {
        content: attr(title);
        position: absolute;
        bottom: 100%;
        left: 50%;
        transform: translateX(-50%);
        background: rgba(0,0,0,0.9);
        color: white;
        padding: 6px 10px;
        border-radius: 6px;
        font-size: 11px;
        white-space: nowrap;
        z-index: 100;
        margin-bottom: 5px;
        pointer-events: none;
    }
    
    .plot-cell {
        position: relative;
    }
</style>
@endpush

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-20 flex items-center bg-gradient-to-br from-gray-900 via-gray-800 to-gray-900">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 overflow-hidden">
            <img src="https://images.unsplash.com/photo-1560518883-ce09059eeffa?w=1200" 
                 alt="Browse Plots" 
                 class="w-full h-full object-cover opacity-20">
            <div class="absolute inset-0 bg-gradient-to-r from-gray-900/90 to-gray-800/80"></div>
        </div>

        <!-- Content -->
        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 text-center">
            <!-- Breadcrumb -->
            <div class="flex items-center justify-center space-x-2 text-sm mb-8">
                <a href="{{ route('home') }}" class="text-gray-300 hover:text-white transition">
                    <i class="fas fa-home mr-1"></i>
                    Home
                </a>
                <i class="fas fa-chevron-right text-gray-500 text-xs"></i>
                <span class="text-white font-medium">Browse Plots</span>
            </div>

            <!-- Title -->
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Browse Available Plots
            </h1>
            <div class="w-24 h-1 bg-primary mx-auto mb-6"></div>
            <p class="text-xl text-gray-300 max-w-2xl mx-auto">
                Find your perfect plot from our premium collection in prime locations
            </p>
        </div>
    </section>

    <!-- Main Content -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Mobile Filter & Sort Buttons -->
        <div class="lg:hidden mb-6 grid grid-cols-2 gap-4">
            <button onclick="toggleFilters()" class="bg-white border-2 border-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:border-primary hover:text-primary transition shadow-md flex items-center justify-center">
                <i class="fas fa-filter mr-2"></i>
                <span>Filters</span>
            </button>
            <button onclick="toggleSortModal()" class="bg-white border-2 border-gray-300 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:border-primary hover:text-primary transition shadow-md flex items-center justify-center">
                <i class="fas fa-sort mr-2"></i>
                <span>Sort</span>
            </button>
        </div>

        <!-- Mobile Backdrop -->
        <div id="mobileBackdrop" class="hidden fixed inset-0 bg-black bg-opacity-50 z-40 lg:hidden" onclick="closeFilters()"></div>

        <div class="flex flex-col lg:flex-row gap-8">
            <!-- Sidebar Filters -->
            <aside id="filterSidebar" class="fixed lg:static inset-y-0 left-0 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-50 lg:z-auto w-80 lg:w-80 flex-shrink-0 lg:block">
                <div class="bg-white rounded-none lg:rounded-xl shadow-lg p-6 h-full lg:h-auto overflow-y-auto lg:overflow-visible">
                    <!-- Mobile Close Button -->
                    <button onclick="closeFilters()" class="lg:hidden absolute top-6 right-6 text-gray-500 hover:text-gray-700 z-10">
                        <i class="fas fa-times text-2xl"></i>
                    </button>

                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Filters</h2>
                        <button onclick="resetFilters()" class="text-sm text-primary hover:text-primary-dark font-medium">
                            Reset All
                        </button>
                    </div>

                    <form id="filterForm" method="GET" action="{{ route('plots.index') }}" class="space-y-6">
                        <!-- Search Field -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Search</label>
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by plot no, title..." class="w-full px-4 py-2 pl-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Block Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Block</label>
                            <div class="space-y-2">
                                @foreach($blocks as $block)
                                <label class="flex items-center">
                                    <input type="checkbox" name="block[]" value="{{ $block }}" class="w-4 h-4 text-primary focus:ring-primary rounded" {{ is_array(request('block')) && in_array($block, request('block')) ? 'checked' : (request('block') == $block ? 'checked' : '') }}>
                                    <span class="ml-2 text-gray-700">Block {{ $block }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Size Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Plot Size (Katha)</label>
                            <div class="space-y-2">
                                @foreach($sizes as $size)
                                <label class="flex items-center">
                                    <input type="checkbox" name="size[]" value="{{ $size }}" class="w-4 h-4 text-primary focus:ring-primary rounded" {{ is_array(request('size')) && in_array($size, request('size')) ? 'checked' : (request('size') == $size ? 'checked' : '') }}>
                                    <span class="ml-2 text-gray-700">{{ $size }} Katha</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Facing Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Facing</label>
                            <div class="space-y-2">
                                @foreach($facings as $facing)
                                <label class="flex items-center">
                                    <input type="checkbox" name="facing[]" value="{{ $facing }}" class="w-4 h-4 text-primary focus:ring-primary rounded" {{ is_array(request('facing')) && in_array($facing, request('facing')) ? 'checked' : (request('facing') == $facing ? 'checked' : '') }}>
                                    <span class="ml-2 text-gray-700">{{ $facing }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>

                        <hr class="border-gray-200">

                        <!-- Price Range Filter -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-700 mb-3">Price Range</label>
                            <div class="space-y-3">
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Min Price (৳)</label>
                                    <input type="number" name="price_min" value="{{ request('price_min') }}" placeholder="0" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" step="1">
                                </div>
                                <div>
                                    <label class="block text-xs text-gray-600 mb-1">Max Price (৳)</label>
                                    <input type="number" name="price_max" value="{{ request('price_max') }}" placeholder="1000" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" step="1">
                                </div>
                            </div>
                        </div>

                        <!-- Apply Filters Button -->
                        <button type="submit" class="w-full bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                            <i class="fas fa-filter mr-2"></i>
                            Apply Filters
                        </button>
                    </form>

                    {{-- <!-- Quick Stats -->
                    <div class="mt-6 p-4 bg-green-50 rounded-lg border border-green-100">
                        <div class="text-center">
                            <div class="text-3xl font-bold text-primary">{{ $plots->total() }}</div>
                            <div class="text-sm text-gray-600 mt-1">Available Plots</div>
                        </div>
                    </div> --}}

                    <!-- Mobile Apply Button (Sticky Bottom) -->
                    <div class="lg:hidden fixed bottom-0 left-0 right-0 bg-white border-t p-4 flex gap-3">
                        <button onclick="resetFilters()" class="flex-1 bg-gray-100 text-gray-900 px-6 py-3 rounded-lg font-semibold hover:bg-gray-200 transition">
                            Reset
                        </button>
                        <button onclick="document.getElementById('filterForm').submit()" class="flex-1 bg-primary text-white px-6 py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                            Apply
                        </button>
                    </div>
                </div>
            </aside>

            <!-- Plots Grid -->
            <main class="flex-1">
                <!-- Results Header -->
                <div class="bg-white rounded-xl shadow-md p-6 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900">Showing {{ $plots->count() }} of {{ $plots->total() }} plots</h3>
                            <p class="text-sm text-gray-600 mt-1">
                                @if($plots->currentPage() > 1)
                                    Page {{ $plots->currentPage() }} of {{ $plots->lastPage() }}
                                @endif
                            </p>
                        </div>
                        <div class="flex flex-wrap items-center gap-3">
                            <!-- View Toggle -->
                            <div class="flex items-center rounded-lg border border-gray-300 overflow-hidden">
                                <button id="mapViewBtn" onclick="toggleView('map')" class="flex items-center gap-2 px-4 py-2 text-sm font-medium transition-colors duration-200 {{ request('view') != 'list' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                                    <i class="fas fa-map-marked-alt"></i> Map View
                                </button>
                                <button id="listViewBtn" onclick="toggleView('list')" class="flex items-center gap-2 px-4 py-2 text-sm font-medium border-l border-gray-300 transition-colors duration-200 {{ request('view') == 'list' ? 'bg-primary text-white' : 'bg-white text-gray-700 hover:bg-gray-50' }}">
                                    <i class="fas fa-list"></i> List View
                                </button>
                            </div>
                            <!-- Sort Dropdown -->
                            <select onchange="window.location.href = this.value" class="hidden md:block px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                <option value="{{ route('plots.index', array_merge(request()->all(), ['sort' => 'latest'])) }}" {{ request('sort') == 'latest' || !request('sort') ? 'selected' : '' }}>Latest First</option>
                                <option value="{{ route('plots.index', array_merge(request()->all(), ['sort' => 'price_low'])) }}" {{ request('sort') == 'price_low' ? 'selected' : '' }}>Price: Low to High</option>
                                <option value="{{ route('plots.index', array_merge(request()->all(), ['sort' => 'price_high'])) }}" {{ request('sort') == 'price_high' ? 'selected' : '' }}>Price: High to Low</option>
                                <option value="{{ route('plots.index', array_merge(request()->all(), ['sort' => 'size'])) }}" {{ request('sort') == 'size' ? 'selected' : '' }}>Size: Small to Large</option>
                            </select>
                        </div>
                    </div>
                </div>

                <!-- List View -->
                <div id="listView" class="{{ request('view') == 'list' ? '' : 'hidden' }}">
                    @if($plots->count() > 0)
                        <div id="plotsGrid" class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">
                            @foreach($plots as $plot)
                                <div class="bg-white rounded-xl shadow-lg overflow-hidden hover:shadow-2xl transition-all duration-300 group">
                                    <div class="relative overflow-hidden bg-green-50 border-b-4 border-primary">
                                        @if($plot->plot_map)
                                            <img src="{{ asset($plot->plot_map) }}" alt="{{ $plot->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                                        @else
                                            <div class="w-full h-56 bg-gradient-to-br from-primary to-primary-dark flex items-center justify-center">
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
                                    <div class="p-5">
                                        <div class="flex items-center justify-between mb-3">
                                            <h3 class="text-lg font-bold text-gray-900">{{ $plot->plot_no }}</h3>
                                            <span class="text-xl font-bold text-primary">@auth ৳{{ format_bd_number($plot->price, 2) }} @else <a href="{{ route('login') }}" class="text-sm text-primary hover:underline">Login to see price</a> @endauth</span>
                                        </div>
                                        <p class="text-gray-600 text-sm mb-4">{{ $plot->title }}</p>
                                        
                                        <div class="grid grid-cols-2 gap-3 mb-4 pb-4 border-b">
                                            <div class="flex items-center text-gray-700 text-sm">
                                                <i class="fas fa-ruler-combined text-primary mr-2"></i>
                                                <span>{{ $plot->size_katha }} Katha</span>
                                            </div>
                                            <div class="flex items-center text-gray-700 text-sm">
                                                <i class="fas fa-compass text-primary mr-2"></i>
                                                <span>{{ $plot->facing }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-700 text-sm">
                                                <i class="fas fa-road text-primary mr-2"></i>
                                                <span>Road {{ $plot->road_no }}</span>
                                            </div>
                                            <div class="flex items-center text-gray-700 text-sm">
                                                <i class="fas fa-calendar-alt text-primary mr-2"></i>
                                                <span>{{ ucfirst($plot->installment_plan ?? 'Cash') }}</span>
                                            </div>
                                        </div>

                                        <div class="space-y-2 mb-4 text-sm">
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Booking:</span>
                                                <span class="font-semibold text-gray-900">৳{{ format_bd_number($plot->booking_payment, 2) }}</span>
                                            </div>
                                            @if($plot->installment_plan)
                                            <div class="flex justify-between">
                                                <span class="text-gray-600">Per {{ ucfirst($plot->installment_plan) }}:</span>
                                                <span class="font-semibold text-gray-900">৳{{ format_bd_number($plot->installment_payment, 2) }}</span>
                                            </div>
                                            @endif
                                        </div>

                                        <a href="{{ route('plot.details', $plot->id) }}" class="block w-full bg-primary text-white px-4 py-2.5 rounded-lg font-semibold hover:bg-primary-dark transition text-sm text-center">
                                            <i class="fas fa-eye mr-1"></i>
                                            View Details
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>

                        <!-- Load More Button -->
                        @if($plots->hasMorePages())
                            <div class="text-center mt-12">
                                <button id="loadMoreBtn" onclick="loadMore()" class="bg-white border-2 border-primary text-primary px-10 py-4 rounded-lg font-semibold hover:bg-primary hover:text-white transition shadow-lg inline-flex items-center space-x-2">
                                    <span>Load More Plots</span>
                                    <i class="fas fa-arrow-down"></i>
                                </button>
                                <p class="text-sm text-gray-500 mt-4">
                                    Showing {{ $plots->count() }} of {{ $plots->total() }} plots
                                </p>
                            </div>
                        @endif
                    @else
                        <!-- No Results -->
                        <div class="bg-white rounded-xl shadow-lg p-12 text-center">
                            <i class="fas fa-search text-gray-300 text-6xl mb-4"></i>
                            <h3 class="text-2xl font-bold text-gray-900 mb-2">No Plots Found</h3>
                            <p class="text-gray-600 mb-6">Try adjusting your filters to see more results</p>
                            <button onclick="resetFilters()" class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition">
                                Reset Filters
                            </button>
                        </div>
                    @endif
                </div>

                <!-- Map View -->
                <div id="mapView" class="{{ request('view') == 'list' ? 'hidden' : '' }}">
                    <div class="bg-white rounded-xl shadow-lg p-6">

                        <!-- Plots Map Grid -->
                        @php
                            $plotsByBlock = $allPlotsForMap->groupBy('block');
                        @endphp

                        @if($plotsByBlock->count() > 0)
                            <div class="space-y-8">
                                @foreach($plotsByBlock as $blockName => $blockPlots)
                                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-200">
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
                                                <span class="text-yellow-600 font-medium">
                                                    <i class="fas fa-clock mr-1"></i>
                                                    {{ $blockPlots->where('status', 'pending')->count() }} Pending
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
                                                <div class="road-separator my-3">
                                                    <span class="road-label"><i class="fas fa-road mr-1"></i>Road {{ $roadNo }}</span>
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
                                                           class="plot-cell aspect-square rounded-lg border-2 flex items-center justify-center text-xs font-bold transition-all duration-200 {{ $statusClass }}"
                                                           title="Plot {{ $mapPlot->plot_no }} - {{ $mapPlot->size_katha }} Katha - @auth()৳{{ number_format($mapPlot->price) }} - @endauth Road {{ $roadNo }} - Click to view">
                                                            <span class="truncate px-1">{{ $mapPlot->plot_no }}</span>
                                                        </a>
                                                    @else
                                                        <div class="plot-cell aspect-square rounded-lg border-2 flex items-center justify-center text-xs font-bold {{ $statusClass }}"
                                                             title="Plot {{ $mapPlot->plot_no }} - {{ ucfirst($mapPlot->status) }} - Road {{ $roadNo }}">
                                                            <span class="truncate px-1">{{ $mapPlot->plot_no }}</span>
                                                        </div>
                                                    @endif
                                                @endforeach
                                            </div>
                                        @endforeach
                                    </div>
                                @endforeach
                            </div>

                            <!-- Summary Stats -->
                            <div class="mt-8 pt-6 border-t">
                                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                                    <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-4 text-center border border-green-200">
                                        <div class="text-3xl font-bold text-green-600">{{ $allPlotsForMap->where('status', 'available')->count() }}</div>
                                        <div class="text-sm text-green-700 font-medium">Available</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 rounded-xl p-4 text-center border border-yellow-200">
                                        <div class="text-3xl font-bold text-yellow-600">{{ $allPlotsForMap->where('status', 'pending')->count() }}</div>
                                        <div class="text-sm text-yellow-700 font-medium">Pending</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-4 text-center border border-red-200">
                                        <div class="text-3xl font-bold text-red-600">{{ $allPlotsForMap->whereIn('status', ['booked', 'sold'])->count() }}</div>
                                        <div class="text-sm text-red-700 font-medium">Booked/Sold</div>
                                    </div>
                                    <div class="bg-gradient-to-br from-gray-50 to-gray-100 rounded-xl p-4 text-center border border-gray-200">
                                        <div class="text-3xl font-bold text-gray-600">{{ $allPlotsForMap->count() }}</div>
                                        <div class="text-sm text-gray-700 font-medium">Total Plots</div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="text-center py-12">
                                <i class="fas fa-map text-gray-300 text-6xl mb-4"></i>
                                <h3 class="text-xl font-bold text-gray-900 mb-2">No Plots Available</h3>
                                <p class="text-gray-600">There are no plots to display on the map.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Mobile Sort Modal -->
    <div id="sortModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 md:hidden">
        <div class="fixed inset-x-0 bottom-0 bg-white rounded-t-3xl shadow-2xl max-h-96 overflow-y-auto">
            <div class="sticky top-0 bg-white border-b px-6 py-4 flex items-center justify-between rounded-t-3xl">
                <h2 class="text-xl font-bold text-gray-900">Sort By</h2>
                <button onclick="toggleSortModal()" class="text-gray-500 hover:text-gray-700">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>
            
            <div class="p-6 space-y-3">
                <button onclick="applySorting('latest')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-50 transition {{ request('sort') == 'latest' || !request('sort') ? 'bg-green-50 text-primary font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-clock mr-3"></i>
                    Latest First
                    @if(request('sort') == 'latest' || !request('sort'))
                    <i class="fas fa-check float-right text-primary"></i>
                    @endif
                </button>
                
                <button onclick="applySorting('price_low')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-50 transition {{ request('sort') == 'price_low' ? 'bg-green-50 text-primary font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-arrow-up mr-3"></i>
                    Price: Low to High
                    @if(request('sort') == 'price_low')
                    <i class="fas fa-check float-right text-primary"></i>
                    @endif
                </button>
                
                <button onclick="applySorting('price_high')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-50 transition {{ request('sort') == 'price_high' ? 'bg-green-50 text-primary font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-arrow-down mr-3"></i>
                    Price: High to Low
                    @if(request('sort') == 'price_high')
                    <i class="fas fa-check float-right text-primary"></i>
                    @endif
                </button>
                
                <button onclick="applySorting('size')" class="w-full text-left px-4 py-3 rounded-lg hover:bg-gray-50 transition {{ request('sort') == 'size' ? 'bg-green-50 text-primary font-semibold' : 'text-gray-700' }}">
                    <i class="fas fa-expand-arrows-alt mr-3"></i>
                    Size: Small to Large
                    @if(request('sort') == 'size')
                    <i class="fas fa-check float-right text-primary"></i>
                    @endif
                </button>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Toggle View (List/Map)
    function toggleView(viewType) {
        const listView = document.getElementById('listView');
        const mapView = document.getElementById('mapView');
        const mapBtn = document.getElementById('mapViewBtn');
        const listBtn = document.getElementById('listViewBtn');
        
        if (viewType === 'map') {
            listView.classList.add('hidden');
            mapView.classList.remove('hidden');
            mapBtn.classList.add('bg-primary', 'text-white');
            mapBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
            listBtn.classList.remove('bg-primary', 'text-white');
            listBtn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
        } else {
            listView.classList.remove('hidden');
            mapView.classList.add('hidden');
            listBtn.classList.add('bg-primary', 'text-white');
            listBtn.classList.remove('bg-white', 'text-gray-700', 'hover:bg-gray-50');
            mapBtn.classList.remove('bg-primary', 'text-white');
            mapBtn.classList.add('bg-white', 'text-gray-700', 'hover:bg-gray-50');
        }
        
        // Update URL without reload
        const url = new URL(window.location.href);
        url.searchParams.set('view', viewType);
        window.history.pushState({}, '', url.toString());
    }

    // Toggle Filter Sidebar
    function toggleFilters() {
        const sidebar = document.getElementById('filterSidebar');
        const backdrop = document.getElementById('mobileBackdrop');
        
        sidebar.classList.toggle('-translate-x-full');
        backdrop.classList.toggle('hidden');
        
        if (!backdrop.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    function closeFilters() {
        const sidebar = document.getElementById('filterSidebar');
        const backdrop = document.getElementById('mobileBackdrop');
        
        sidebar.classList.add('-translate-x-full');
        backdrop.classList.add('hidden');
        document.body.style.overflow = '';
    }

    // Mobile Sort Modal
    function toggleSortModal() {
        const modal = document.getElementById('sortModal');
        modal.classList.toggle('hidden');
        if (!modal.classList.contains('hidden')) {
            document.body.style.overflow = 'hidden';
        } else {
            document.body.style.overflow = '';
        }
    }

    function applySorting(sortValue) {
        const url = new URL(window.location.href);
        url.searchParams.set('sort', sortValue);
        window.location.href = url.toString();
    }

    // Close sort modal on backdrop click
    document.getElementById('sortModal')?.addEventListener('click', function(e) {
        if (e.target === this) toggleSortModal();
    });


    let currentPage = {{ $plots->currentPage() }};
    let isLoading = false;

    function loadMore() {
        if (isLoading) return;
        
        isLoading = true;
        const btn = document.getElementById('loadMoreBtn');
        const originalText = btn.innerHTML;
        btn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Loading...';
        btn.disabled = true;

        const urlParams = new URLSearchParams(window.location.search);
        urlParams.set('page', currentPage + 1);

        fetch('{{ route("plots.index") }}?' + urlParams.toString(), {
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newPlots = doc.querySelectorAll('#plotsGrid > div');
            const plotsGrid = document.getElementById('plotsGrid');
            
            newPlots.forEach(plot => {
                plotsGrid.appendChild(plot);
            });

            currentPage++;
            
            // Check if there are more pages
            const loadMoreSection = doc.querySelector('#loadMoreBtn');
            if (!loadMoreSection) {
                btn.parentElement.remove();
            } else {
                btn.innerHTML = originalText;
                btn.disabled = false;
                isLoading = false;
            }
        })
        .catch(error => {
            console.error('Error loading more plots:', error);
            btn.innerHTML = originalText;
            btn.disabled = false;
            isLoading = false;
        });
    }

    function resetFilters() {
        window.location.href = '{{ route("plots.index") }}';
    }
</script>
@endpush
