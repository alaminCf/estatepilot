@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Bookings Report</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Bookings Report</li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="text-lg mb-0">
            <iconify-icon icon="material-symbols:assessment-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
            Generate Bookings Report
        </h6>
    </div>
    <div class="card-body p-24">
        <form id="reportForm" action="{{ route('admin.reports.bookings.generate') }}" method="GET" target="_blank">
            
            <div class="row gy-3">
                <!-- Status -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Booking Status</label>
                    <select name="status" class="form-select">
                        <option value="">All Statuses</option>
                        <option value="pending">Pending</option>
                        <option value="pre-booked">Pre-Booked</option>
                        <option value="approved">Approved</option>
                        <option value="cancelled">Cancelled</option>
                    </select>
                </div>

                <!-- Payment Status -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment Status</label>
                    <select name="payment_status" class="form-select">
                        <option value="">All</option>
                        <option value="due_installment_this_month">Due Installment This Month</option>
                        <option value="due_booking_payment">Due Booking Payment</option>
                    </select>
                </div>

                <!-- Installment Paid -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Min Installment Paid</label>
                    <input type="number" name="min_installment_paid" class="form-control" placeholder="Min installments paid" min="0">
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-semibold">Max Installment Paid</label>
                    <input type="number" name="max_installment_paid" class="form-control" placeholder="Max installments paid" min="0">
                </div>

                <!-- Agent -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Referral Agent</label>
                    <select name="referral_agent_id" class="form-select">
                        <option value="">All Agents</option>
                        @foreach($agents as $agent)
                            <option value="{{ $agent->id }}">{{ $agent->name }} ({{ $agent->referral_code }})</option>
                        @endforeach
                    </select>
                </div>

                <!-- Has Agent -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Agent Referred</label>
                    <select name="has_agent" class="form-select">
                        <option value="">All Bookings</option>
                        <option value="yes">With Agent</option>
                        <option value="no">Without Agent</option>
                    </select>
                </div>

                <!-- Block -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Plot Block</label>
                    <select name="block" class="form-select">
                        <option value="">All Blocks</option>
                        @foreach($blocks as $block)
                            <option value="{{ $block }}">{{ $block }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Installment Plan -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Installment Plan</label>
                    <select name="installment_plan" class="form-select">
                        <option value="">All Plans</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                    </select>
                </div>

                <!-- Booking Date Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Booking Date From</label>
                    <input type="date" name="date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Booking Date To</label>
                    <input type="date" name="date_to" class="form-control">
                </div>

                <!-- Created Date Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Created From</label>
                    <input type="date" name="created_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Created To</label>
                    <input type="date" name="created_to" class="form-control">
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

                <!-- Sort -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="">Default (Latest)</option>
                        <option value="booking_date">Booking Date</option>
                        <option value="price">Price</option>
                        <option value="created_at">Created Date</option>
                        <option value="status">Status</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort Direction</label>
                    <select name="sort_direction" class="form-select">
                        <option value="desc">Descending</option>
                        <option value="asc">Ascending</option>
                    </select>
                </div>

                <!-- Client ID -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Client ID</label>
                    <input type="text" name="client_id" class="form-control" placeholder="e.g. CID-00003 or 3">
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
