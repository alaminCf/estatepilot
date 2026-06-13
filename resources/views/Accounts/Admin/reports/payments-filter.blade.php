@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Payments Report</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Payments Report</li>
    </ul>
</div>

<div class="card">
    <div class="card-header">
        <h6 class="text-lg mb-0">
            <iconify-icon icon="material-symbols:assessment-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
            Generate Payments Report
        </h6>
    </div>
    <div class="card-body p-24">
        <form id="reportForm" action="{{ route('admin.reports.payments.generate') }}" method="GET" target="_blank">
            
            <div class="row gy-3">
                <!-- Payment Type -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Payment Type</label>
                    <select name="payment_type" class="form-select">
                        <option value="">All Types</option>
                        <option value="Booking Payment">Booking Payment</option>
                        <option value="Installment Payment">Installment Payment</option>
                        <option value="Part Of Installment">Part Of Installment</option>
                    </select>
                </div>

                <!-- Date Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date From</label>
                    <input type="date" name="date_from" class="form-control">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Date To</label>
                    <input type="date" name="date_to" class="form-control">
                </div>

                <!-- Amount Range -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Min Amount (৳)</label>
                    <input type="number" name="amount_min" class="form-control" placeholder="Minimum amount" min="0" step="0.01">
                </div>
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Max Amount (৳)</label>
                    <input type="number" name="amount_max" class="form-control" placeholder="Maximum amount" min="0" step="0.01">
                </div>

                <!-- Plot No -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Plot Number</label>
                    <input type="text" name="plot_no" class="form-control" placeholder="Search by plot no">
                </div>

                <!-- Customer Search -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Customer (Name/Phone)</label>
                    <input type="text" name="customer_search" class="form-control" placeholder="Search customer">
                </div>

                <!-- Sort -->
                <div class="col-md-3">
                    <label class="form-label fw-semibold">Sort By</label>
                    <select name="sort_by" class="form-select">
                        <option value="">Default (Latest)</option>
                        <option value="amount">Amount</option>
                        <option value="payment_type">Payment Type</option>
                        <option value="created_at">Date</option>
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
