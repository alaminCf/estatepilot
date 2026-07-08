@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Commission Report</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Commission Report</li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="text-lg mb-0">
            <iconify-icon icon="material-symbols:assessment-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
            Generate Commission Report
        </h6>
    </div>
    <div class="card-body p-24">
        <form id="reportForm" action="{{ route('admin.reports.agents.generate') }}" method="GET" target="_blank">
            
            <div class="row gy-3">
                <!-- Specific Agent -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Agent</label>
                    <select name="agent_id" class="form-select">
                        <option value="">All Agents</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->referral_code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Agent Status -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Agent Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>

                <!-- Commission Rate Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Min Commission Rate (%)</label>
                    <input type="number" name="commission_rate_min" class="form-control" placeholder="Min rate" min="0" max="100" step="0.01">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Max Commission Rate (%)</label>
                    <input type="number" name="commission_rate_max" class="form-control" placeholder="Max rate" min="0" max="100" step="0.01">
                </div>

                <!-- Agent Join Date Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Joined From</label>
                    <input type="date" name="date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Joined To</label>
                    <input type="date" name="date_to" class="form-control">
                </div>

                <!-- Booking Date Range (for filtering bookings) -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Booking Period From</label>
                    <input type="date" name="booking_date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Booking Period To</label>
                    <input type="date" name="booking_date_to" class="form-control">
                </div>

                <!-- Min Bookings -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Minimum Bookings</label>
                    <input type="number" name="min_bookings" class="form-control" placeholder="Min bookings count" min="0">
                </div>

                <!-- Sort -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="">Default (Name)</option>
                        <option value="name">Name</option>
                        <option value="commission_rate">Commission Rate</option>
                        <option value="created_at">Join Date</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Direction</label>
                    <select name="sort_direction" class="form-select">
                        <option value="asc">Ascending</option>
                        <option value="desc">Descending</option>
                    </select>
                </div>

                <!-- Client ID -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Client ID</label>
                    <input type="number" name="client_id" class="form-control" placeholder="Enter client ID" min="1" value="{{ request('client_id') }}">
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
