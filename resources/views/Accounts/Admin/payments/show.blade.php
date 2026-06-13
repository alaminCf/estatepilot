@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Payment Details</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('admin.payments.index') }}" class="hover-text-primary">Payments</a>
        </li>
        <li>-</li>
        <li class="fw-medium">View #{{ $payment->id }}</li>
    </ul>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row gy-4">
    <!-- Left Column - Payment Overview -->
    <div class="col-lg-4">
        <!-- Payment Card -->
        <div class="card payment-overview-card mb-24">
            <div class="payment-header">
                <div class="payment-icon-wrapper">
                    <iconify-icon icon="mdi:cash-check" class="payment-icon"></iconify-icon>
                </div>
                <div class="payment-amount-section">
                    <span class="payment-label">Payment Amount</span>
                    <span class="payment-amount">৳{{ format_bd_number($payment->amount, 2) }}</span>
                </div>
            </div>
            <div class="card-body">
                <div class="payment-meta">
                    <div class="meta-item">
                        <iconify-icon icon="mdi:pound" class="meta-icon"></iconify-icon>
                        <div>
                            <span class="meta-label">Payment ID</span>
                            <span class="meta-value">#{{ str_pad($payment->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <iconify-icon icon="mdi:tag" class="meta-icon"></iconify-icon>
                        <div>
                            <span class="meta-label">Payment Type</span>
                            <span class="meta-value">
                                @if($payment->payment_type == 'Booking Payment')
                                    <span class="badge bg-info-focus text-info-600">{{ $payment->payment_type }}</span>
                                @elseif($payment->payment_type == 'Down Payment')
                                    <span class="badge bg-success-focus text-success-600">{{ $payment->payment_type }}</span>
                                @elseif($payment->payment_type == 'Installment Payment')
                                    <span class="badge bg-warning-focus text-warning-600">{{ $payment->payment_type }}{{ $payment->instalment_quantity > 1 ? ' ×'.$payment->instalment_quantity : '' }}</span>
                                @elseif($payment->payment_type == 'Part Of Installment')
                                    <span class="badge" style="background:#fef3c7;color:#92400e;">{{ $payment->payment_type }}</span>
                                @else
                                    <span class="badge bg-neutral-100 text-neutral-600">{{ $payment->payment_type }}</span>
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="meta-item">
                        <iconify-icon icon="mdi:calendar" class="meta-icon"></iconify-icon>
                        <div class="flex-grow-1">
                            <span class="meta-label">Payment Date</span>
                            <span class="meta-value">{{ $payment->created_at->format('d M, Y') }}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-info d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editPaymentDateModal">
                            <iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Edit
                        </button>
                    </div>
                    <div class="meta-item">
                        <iconify-icon icon="mdi:clock" class="meta-icon"></iconify-icon>
                        <div>
                            <span class="meta-label">Time</span>
                            <span class="meta-value">{{ $payment->created_at->format('h:i A') }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Customer Card -->
        <div class="card customer-card">
            <div class="customer-card-header">
                <div class="customer-avatar-wrapper">
                    @if($payment->booking->user->photo)
                        <img src="{{ $payment->booking->user->profile_image_url }}" alt="{{ $payment->booking->user->name }}" class="customer-avatar">
                    @else
                        <div class="customer-avatar-placeholder">
                            {{ strtoupper(substr($payment->booking->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="customer-name-section">
                    <h5 class="customer-name">{{ $payment->booking->user->name }}</h5>
                    <span class="customer-role">CID-{{ str_pad($payment->booking->user->client_id, 5, '0', STR_PAD_LEFT) }} | Customer</span>
                </div>
            </div>
            <div class="card-body">
                <ul class="customer-info-list">
                    <li>
                        <iconify-icon icon="mdi:phone" class="info-icon"></iconify-icon>
                        <div>
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $payment->booking->user->phone }}</span>
                        </div>
                    </li>
                    <li>
                        <iconify-icon icon="mdi:email" class="info-icon"></iconify-icon>
                        <div>
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $payment->booking->user->email }}</span>
                        </div>
                    </li>
                </ul>
                <div class="mt-16 pt-16 border-top">
                    <a href="{{ route('admin.users.show', $payment->booking->user->id) }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <iconify-icon icon="mdi:eye"></iconify-icon>
                        View Customer
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column - Booking & Payment History -->
    <div class="col-lg-8">
        <!-- Booking Details Card -->
        <div class="card booking-details-card mb-24">
            <div class="booking-header">
                <div class="booking-badge">
                    <iconify-icon icon="mdi:file-document" class="me-2"></iconify-icon>
                    Booking Details
                </div>
                <div class="booking-number">#{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</div>
            </div>
            <div class="card-body">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="booking-info-section">
                            <h6 class="info-section-title">
                                <iconify-icon icon="mdi:land-plots" class="me-2 d-flex"></iconify-icon>
                                Plot Information
                            </h6>
                            <div class="info-content">
                                <div class="info-row">
                                    <span class="info-key">Plot No:</span>
                                    <span class="info-val fw-semibold">{{ $payment->booking->plot->plot_no }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Title:</span>
                                    <span class="info-val">{{ Str::limit($payment->booking->plot->title, 30) }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Size:</span>
                                    <span class="info-val">{{ $payment->booking->plot->size_katha }} Katha</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="booking-info-section">
                            <h6 class="info-section-title">
                                <iconify-icon icon="mdi:currency-bdt" class="me-2 d-flex"></iconify-icon>
                                Financial Summary
                            </h6>
                            <div class="info-content">
                                <div class="info-row">
                                    <span class="info-key">Total Price:</span>
                                    <span class="info-val fw-semibold text-primary-600">৳{{ format_bd_number($payment->booking->price, 2) }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Total Paid:</span>
                                    <span class="info-val fw-semibold text-success-600">৳{{ format_bd_number($payment->booking->payments->sum('amount'), 2) }}</span>
                                </div>
                                <div class="info-row">
                                    <span class="info-key">Due Amount:</span>
                                    <span class="info-val fw-semibold text-danger-600">৳{{ format_bd_number($payment->booking->price - $payment->booking->payments->sum('amount'), 2) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="text-end mt-16">
                    <a href="{{ route('admin.bookings.show', $payment->booking->id) }}" class="btn btn-sm btn-primary-light d-inline-flex align-items-center">
                        <iconify-icon icon="mdi:eye" class="me-1 d-flex"></iconify-icon> View Booking
                    </a>
                </div>
            </div>
        </div>

        <!-- Payment Note Card -->
        @if($payment->payment_note)
        <div class="card payment-note-card mb-24">
            <div class="card-header py-16 px-24 bg-base">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:note-text" class="text-primary-600"></iconify-icon>
                    Payment Note
                </h6>
            </div>
            <div class="card-body">
                <p class="mb-0 payment-note-text">{{ $payment->payment_note }}</p>
            </div>
        </div>
        @endif

        <!-- Commission Distribution Card -->
        @php $earnings = $payment->commissionEarnings()->with('beneficiary')->orderBy('level')->get(); @endphp
        @if($earnings->count() > 0)
        <div class="card payment-history-card mb-24">
            <div class="card-header py-16 px-24 bg-base">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:account-cash" class="text-primary-600"></iconify-icon>
                    Commission Distribution
                    <span class="badge bg-primary-100 text-primary-600 text-capitalize ms-1">{{ $earnings->first()->pool_type }} pool — {{ rtrim(rtrim(number_format($earnings->first()->pool_rate, 2), '0'), '.') }}%</span>
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-24 py-12">Beneficiary</th>
                                <th class="px-24 py-12">Type</th>
                                <th class="px-24 py-12">Role</th>
                                <th class="px-24 py-12">Share</th>
                                <th class="px-24 py-12">Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($earnings as $earning)
                            <tr>
                                <td class="px-24 py-12 fw-medium">{{ $earning->beneficiary->name ?? 'N/A' }}</td>
                                <td class="px-24 py-12">
                                    <span class="badge bg-info-focus text-info-600">{{ config('commission.types.' . $earning->beneficiary_type . '.label', $earning->beneficiary_type) }}</span>
                                </td>
                                <td class="px-24 py-12">
                                    @if($earning->level === 0)
                                        <span class="badge bg-success-focus text-success-600">Seller</span>
                                    @else
                                        <span class="badge bg-warning-focus text-warning-600">Upline (L{{ $earning->level }})</span>
                                    @endif
                                </td>
                                <td class="px-24 py-12">{{ rtrim(rtrim(number_format($earning->percentage, 2), '0'), '.') }}%</td>
                                <td class="px-24 py-12"><span class="fw-semibold text-success-600">৳{{ format_bd_number($earning->amount, 2) }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-neutral-50">
                            <tr>
                                <td colspan="4" class="px-24 py-12 fw-semibold">Total Distributed</td>
                                <td class="px-24 py-12"><span class="fw-bold text-success-600">৳{{ format_bd_number($earnings->sum('amount'), 2) }}</span></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Payment History Card -->
        <div class="card payment-history-card">
            <div class="card-header py-16 px-24 bg-base">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:history" class="text-primary-600"></iconify-icon>
                    All Payments for this User
                </h6>
            </div>
            <div class="card-body p-0">
                @php
                    $userPayments = \App\Models\Payment::whereHas('booking', function($query) use ($payment) {
                        $query->where('user_id', $payment->booking->user_id);
                    })->with('booking.plot')->latest()->get();
                @endphp
                
                @if($userPayments->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-24 py-12">ID</th>
                                <th class="px-24 py-12">Booking</th>
                                <th class="px-24 py-12">Type</th>
                                <th class="px-24 py-12">Amount</th>
                                <th class="px-24 py-12">Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userPayments as $p)
                            <tr class="{{ $p->id == $payment->id ? 'bg-success-50' : '' }}">
                                <td class="px-24 py-12">
                                    <span class="fw-medium {{ $p->id == $payment->id ? 'text-success-600' : '' }}">
                                        #{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}
                                        @if($p->id == $payment->id)
                                            <span class="badge bg-success-100 text-success-600 ms-1">Current</span>
                                        @endif
                                    </span>
                                </td>
                                <td class="px-24 py-12">
                                    <a href="{{ route('admin.bookings.show', $p->booking->id) }}" class="text-primary-600 hover-text-primary">
                                        #{{ str_pad($p->booking->id, 5, '0', STR_PAD_LEFT) }} - {{ $p->booking->plot->plot_no }}
                                    </a>
                                </td>
                                <td class="px-24 py-12">
                                    @if($p->payment_type == 'Booking Payment')
                                        <span class="badge bg-info-focus text-info-600">{{ $p->payment_type }}</span>
                                    @elseif($p->payment_type == 'Down Payment')
                                        <span class="badge bg-success-focus text-success-600">{{ $p->payment_type }}</span>
                                    @elseif($p->payment_type == 'Installment Payment')
                                        <span class="badge bg-warning-focus text-warning-600">{{ $p->payment_type }}{{ $p->instalment_quantity > 1 ? ' ×'.$p->instalment_quantity : '' }}</span>
                                    @elseif($p->payment_type == 'Part Of Installment')
                                        <span class="badge" style="background:#fef3c7;color:#92400e;">{{ $p->payment_type }}</span>
                                    @else
                                        <span class="badge bg-neutral-100 text-neutral-600">{{ $p->payment_type }}</span>
                                    @endif
                                </td>
                                <td class="px-24 py-12">
                                    <span class="fw-semibold text-success-600">৳{{ format_bd_number($p->amount, 2) }}</span>
                                </td>
                                <td class="px-24 py-12 text-secondary-light">{{ $p->created_at->format('d M, Y') }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-neutral-50">
                            <tr>
                                <td colspan="3" class="px-24 py-12 fw-semibold">Total</td>
                                <td class="px-24 py-12">
                                    <span class="fw-bold text-success-600">৳{{ format_bd_number($userPayments->sum('amount'), 2) }}</span>
                                </td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-32">
                    <iconify-icon icon="mdi:cash-remove" class="text-neutral-400" style="font-size: 48px;"></iconify-icon>
                    <p class="text-neutral-600 mt-12 mb-0">No payments found for this user</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Back Button -->
<div class="mt-24">
    <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary px-24 py-12 radius-8 d-inline-flex align-items-center">
        <iconify-icon icon="mdi:arrow-left" class="me-2 d-flex"></iconify-icon> Back to Payments
    </a>
</div>

<!-- Edit Payment Date Modal -->
<div class="modal fade" id="editPaymentDateModal" tabindex="-1" aria-labelledby="editPaymentDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-info-600 py-16">
                <h5 class="modal-title text-white" id="editPaymentDateModalLabel">
                    <iconify-icon icon="mdi:calendar-edit" class="me-2"></iconify-icon>
                    Edit Payment Date & Time
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.payments.update-date', $payment->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:calendar" class="me-1"></iconify-icon>
                            Payment Date <span class="text-danger-600">*</span>
                        </label>
                        <input type="date" class="form-control radius-8" name="payment_date"
                            value="{{ $payment->created_at->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:clock" class="me-1"></iconify-icon>
                            Payment Time <span class="text-danger-600">*</span>
                        </label>
                        <input type="time" class="form-control radius-8" name="payment_time"
                            value="{{ $payment->created_at->format('H:i') }}" required>
                    </div>
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-outline-secondary px-20 py-10 radius-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-info-600 px-20 py-10 radius-8 d-inline-flex align-items-center text-white">
                        <iconify-icon icon="mdi:check" class="me-1 d-flex"></iconify-icon> Update Date
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Payment Overview Card */
.payment-overview-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.payment-header {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    padding: 24px;
    text-align: center;
}

.payment-icon-wrapper {
    width: 64px;
    height: 64px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 12px;
}

.payment-icon {
    font-size: 32px;
    color: white;
}

.payment-label {
    display: block;
    font-size: 12px;
    color: rgba(255, 255, 255, 0.8);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.payment-amount {
    font-size: 28px;
    font-weight: 700;
    color: white;
}

.payment-meta {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 12px;
}

.meta-icon {
    font-size: 20px;
    color: var(--primary-600);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.meta-label {
    display: block;
    font-size: 12px;
    color: #6b7280;
}

.meta-value {
    font-weight: 600;
    color: #1f2937;
}

/* Customer Card */
.customer-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.customer-card-header {
    background: linear-gradient(135deg, #6366f1 0%, #4f46e5 100%);
    padding: 24px;
    text-align: center;
}

.customer-avatar-wrapper {
    position: relative;
    display: inline-block;
    margin-bottom: 12px;
}

.customer-avatar,
.customer-avatar-placeholder {
    width: 70px;
    height: 70px;
    border-radius: 50%;
    border: 4px solid rgba(255, 255, 255, 0.3);
    object-fit: cover;
}

.customer-avatar-placeholder {
    background: rgba(255, 255, 255, 0.2);
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    font-weight: 700;
}

.customer-name {
    color: white;
    margin-bottom: 4px;
    font-size: 18px;
}

.customer-role {
    color: rgba(255, 255, 255, 0.7);
    font-size: 13px;
}

.section-title {
    font-size: 13px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}

.customer-info-list {
    list-style: none;
    padding: 0;
    margin: 0;
}

.customer-info-list li {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 10px 0;
    border-bottom: 1px solid var(--neutral-200);
}

.customer-info-list li:last-child {
    border-bottom: none;
    padding-bottom: 0;
}

.info-icon {
    font-size: 18px;
    color: var(--primary-600);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.info-label {
    display: block;
    font-size: 11px;
    color: #6b7280;
    text-transform: uppercase;
}

.info-value {
    font-weight: 500;
    color: #1f2937;
    word-break: break-word;
}

/* Booking Details Card */
.booking-details-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.booking-header {
    background: linear-gradient(135deg, #0ea5e9 0%, #0284c7 100%);
    padding: 16px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.booking-badge {
    background: rgba(255, 255, 255, 0.2);
    padding: 6px 14px;
    border-radius: 20px;
    color: white;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
}

.booking-number {
    font-size: 20px;
    font-weight: 700;
    color: white;
}

.booking-info-section {
    background: #f9fafb;
    border-radius: 12px;
    padding: 16px;
    height: 100%;
}

.info-section-title {
    font-size: 13px;
    font-weight: 600;
    color: #0284c7;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
}

.info-content {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.info-row {
    display: flex;
    justify-content: space-between;
    font-size: 14px;
}

.info-key {
    color: #6b7280;
}

.info-val {
    color: #1f2937;
}

/* Payment Note Card */
.payment-note-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.payment-note-text {
    background: #f9fafb;
    padding: 16px;
    border-radius: 8px;
    border-left: 4px solid #22c55e;
    font-style: italic;
    color: #374151;
    line-height: 1.6;
}

/* Payment History Card */
.payment-history-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}
</style>
@endpush
@endsection
