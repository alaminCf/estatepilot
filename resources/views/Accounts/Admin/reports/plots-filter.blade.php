@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Plots Report</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Plots Report</li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="text-lg mb-0">
            <iconify-icon icon="material-symbols:assessment-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
            Generate Plots Report
        </h6>
    </div>
    <div class="card-body p-24">
        <form id="reportForm" action="{{ route('admin.reports.plots.generate') }}" method="GET" target="_blank">
            
            <div class="row gy-3">
                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Plot Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="available">Available</option>
                        <option value="pending">Pending</option>
                        <option value="booked">Booked</option>
                    </select>
                </div>

                <!-- Block -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Block</label>
                    <select name="block" class="form-select">
                        <option value="">All Blocks</option>
                        @foreach($blocks as $block)
                            <option value="{{ $block }}">{{ $block }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Road No -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Road No</label>
                    <select name="road_no" class="form-select">
                        <option value="">All Roads</option>
                        @foreach($roadNumbers as $road)
                            <option value="{{ $road }}">{{ $road }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Facing -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Facing</label>
                    <select name="facing" class="form-select">
                        <option value="">All Facings</option>
                        @foreach($facings as $facing)
                            <option value="{{ $facing }}">{{ $facing }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Category -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Plot Category</label>
                    <select name="plot_category" class="form-select">
                        <option value="">All Categories</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Price Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Min Price (৳)</label>
                    <input type="number" name="price_min" class="form-control" placeholder="Minimum price" min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Max Price (৳)</label>
                    <input type="number" name="price_max" class="form-control" placeholder="Maximum price" min="0" step="0.01">
                </div>

                <!-- Size Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Min Size (Katha)</label>
                    <input type="number" name="size_min" class="form-control" placeholder="Minimum size" min="0" step="0.01">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Max Size (Katha)</label>
                    <input type="number" name="size_max" class="form-control" placeholder="Maximum size" min="0" step="0.01">
                </div>

                <!-- Date Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Created From</label>
                    <input type="date" name="date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Created To</label>
                    <input type="date" name="date_to" class="form-control">
                </div>

                <!-- Sort -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="">Default (Plot No)</option>
                        <option value="plot_no">Plot Number</option>
                        <option value="price">Price</option>
                        <option value="size_katha">Size</option>
                        <option value="block">Block</option>
                        <option value="created_at">Date Added</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Direction</label>
                    <select name="sort_direction" class="form-select">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>
            </div>

            <div class="mt-24 d-flex gap-2">
                <button type="submit" class="btn btn-primary px-24 d-flex align-items-center gap-2">
                    <iconify-icon icon="material-symbols:assessment-outline" class="text-lg"></iconify-icon>
                    Generate Report
                </button>
                <button type="reset" class="btn btn-outline-secondary px-24">
                    <iconify-icon icon="material-symbols:restart-alt" class="text-lg"></iconify-icon>
                    Reset Filters
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
