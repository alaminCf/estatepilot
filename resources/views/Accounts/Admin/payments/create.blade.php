@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add New Payment</h6>
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
        <li class="fw-medium">Add New</li>
    </ul>
</div>

@if ($errors->any())
    <div class="alert alert-danger mb-20">
        <ul class="mb-0">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- ====== STEP 1: Select Payment Type & Booking ====== --}}
@if (!$selectedBooking)
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card payment-form-card">
            <div class="card-body p-0">
                <div class="payment-form-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="payment-form-icon">
                            <iconify-icon icon="mdi:cash-plus" class="icon"></iconify-icon>
                        </div>
                        <div>
                            <h5 class="mb-1 text-white">Record New Payment</h5>
                            <p class="mb-0 text-white-50 text-sm">Select payment type and booking to continue</p>
                        </div>
                    </div>
                </div>

                <div class="p-24">
                    <form action="{{ route('admin.payments.create') }}" method="GET" id="selectionForm">
                        <div class="row g-3">
                            {{-- Payment Type - Full Width --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                    <iconify-icon icon="mdi:tag" class="me-1 d-flex"></iconify-icon>
                                    Payment Type <span class="text-danger-600 ms-1">*</span>
                                </label>
                                <select class="form-control radius-8 form-select" name="payment_type" id="payment_type" required>
                                    <option value="">Select payment type...</option>
                                    <option value="Booking Payment">Booking Payment</option>
                                    <option value="Down Payment">Down Payment</option>
                                    <option value="Installment Payment">Installment Payment</option>
                                </select>
                            </div>

                            {{-- Booking Select - Full Width --}}
                            <div class="col-12">
                                <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                    <iconify-icon icon="mdi:book-open-variant" class="me-1 d-flex"></iconify-icon>
                                    Select Booking <span class="text-danger-600 ms-1">*</span>
                                </label>
                                <select class="form-control radius-8" name="booking_id" id="booking_select" required style="width:100%">
                                    <option value="">Search booking by name, phone, plot number...</option>
                                    @foreach ($bookings as $b)
                                        <option value="{{ $b->id }}">
                                            #{{ str_pad($b->id, 5, '0', STR_PAD_LEFT) }} | {{ $b->plot->plot_no }} | {{ $b->user->name }} ({{ $b->user->phone }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between gap-3 pt-24 mt-24 border-top">
                            <a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary px-32 py-12 radius-8 d-inline-flex align-items-center">
                                <iconify-icon icon="mdi:arrow-left" class="me-2 d-flex"></iconify-icon> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary px-32 py-12 radius-8 d-inline-flex align-items-center" id="continueBtn" disabled>
                                <iconify-icon icon="mdi:arrow-right" class="me-2 d-flex"></iconify-icon> Continue
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- ====== STEP 2: Payment Form (after Continue) ====== --}}
@else
<div class="row justify-content-center">
    <div class="col-lg-10">
        <div class="card payment-form-card">
            <div class="card-body p-0">
                <div class="payment-form-header">
                    <div class="d-flex align-items-center gap-3">
                        <div class="payment-form-icon">
                            <iconify-icon icon="mdi:cash-plus" class="icon"></iconify-icon>
                        </div>
                        <div>
                            <h5 class="mb-1 text-white">Record {{ $paymentType }}</h5>
                            <p class="mb-0 text-white-50 text-sm">
                                Booking #{{ str_pad($selectedBooking->id, 5, '0', STR_PAD_LEFT) }} &mdash; {{ $selectedBooking->user->name }} &mdash; Plot {{ $selectedBooking->plot->plot_no }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="p-24">
                    {{-- Booking Summary --}}
                    <div class="booking-summary-card mb-24">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="summary-section">
                                    <h6 class="summary-title">
                                        <iconify-icon icon="mdi:account" class="me-2 d-flex"></iconify-icon>
                                        Customer Details
                                    </h6>
                                    <div class="summary-content">
                                        <div class="d-flex align-items-center gap-3 mb-3">
                                            <span class="w-48-px h-48-px rounded-circle bg-success-100 text-success-600 d-flex justify-content-center align-items-center fw-semibold text-lg">
                                                {{ strtoupper(substr($selectedBooking->user->name, 0, 1)) }}
                                            </span>
                                            <div>
                                                <span class="fw-semibold d-block">{{ $selectedBooking->user->name }}</span>
                                                <span class="text-secondary-light text-sm">{{ $selectedBooking->user->phone }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="summary-section">
                                    <h6 class="summary-title">
                                        <iconify-icon icon="mdi:land-plots" class="me-2 d-flex"></iconify-icon>
                                        Plot Details
                                    </h6>
                                    <div class="summary-content">
                                        <div class="d-flex justify-content-between mb-2">
                                            <span class="text-secondary-light">Plot No:</span>
                                            <span class="fw-semibold">{{ $selectedBooking->plot->plot_no }}</span>
                                        </div>
                                        <div class="d-flex justify-content-between">
                                            <span class="text-secondary-light">Plot Title:</span>
                                            <span class="fw-semibold">{{ $selectedBooking->plot->title }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Payment Overview --}}
                        <div class="payment-overview mt-20">
                            <div class="row g-3">
                                <div class="col-sm-6 col-md-3">
                                    <div class="overview-box">
                                        <span class="overview-label">Total Price</span>
                                        <span class="overview-value text-primary-600">{{ format_bd_number($summary['total_price']) }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="overview-box">
                                        <span class="overview-label">Total Paid</span>
                                        <span class="overview-value text-success-600">{{ format_bd_number($summary['total_paid']) }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="overview-box">
                                        <span class="overview-label">Due Amount</span>
                                        <span class="overview-value text-danger-600">{{ format_bd_number($summary['outstanding_balance']) }}</span>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="overview-box">
                                        @if ($paymentType === 'Booking Payment')
                                            <span class="overview-label">Booking Due</span>
                                            <span class="overview-value text-info-600">{{ format_bd_number(max(0, $summary['booking_payment_expected'] - $summary['booking_payments_received'])) }}</span>
                                        @elseif ($paymentType === 'Down Payment')
                                            <span class="overview-label">Booking Received</span>
                                            <span class="overview-value text-info-600">{{ format_bd_number($summary['booking_payments_received']) }}</span>
                                        @else
                                            <span class="overview-label">Installments Left</span>
                                            <span class="overview-value text-info-600">{{ $summary['remaining_installments'] }} of {{ $summary['total_installments'] }}</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Payment Form --}}
                    <form action="{{ route('admin.payments.store') }}" method="POST" id="paymentForm">
                        @csrf
                        <input type="hidden" name="booking_id" value="{{ $selectedBooking->id }}">
                        <input type="hidden" name="payment_type" id="hidden_payment_type" value="{{ $paymentType }}">
                        {{-- Installment Info Banner --}}
                        @if ($paymentType === 'Installment Payment')
                            <div class="alert alert-info mb-20">
                                <div class="d-flex align-items-center gap-2 mb-1">
                                    <iconify-icon icon="mdi:information" class="text-lg"></iconify-icon>
                                    <strong>Installment Info</strong>
                                </div>
                                <div class="d-flex flex-wrap gap-3 text-sm">
                                    <span><strong>Plan:</strong> {{ ucfirst($summary['installment_plan']) }}</span>
                                    <span>|</span>
                                    <span><strong>Original EMI:</strong> ৳{{ format_bd_number($summary['installment_payment']) }}</span>
                                    @if (abs($summary['adjusted_installment'] - $summary['installment_payment']) > 0.01 && $summary['adjusted_installment'] > 0)
                                        <span>|</span>
                                        <span><strong>Adjusted EMI:</strong> <span class="text-primary fw-bold">৳{{ format_bd_number($summary['adjusted_installment']) }}</span></span>
                                    @endif
                                    <span>|</span>
                                    <span><strong>Remaining:</strong> {{ $summary['remaining_installments'] }} installment{{ $summary['remaining_installments'] > 1 ? 's' : '' }}</span>
                                </div>
                            </div>
                        @endif

                        {{-- Payment Details --}}
                        <div class="payment-step mb-24">
                            <div class="step-header mb-20">
                                <span class="step-number">
                                    <iconify-icon icon="mdi:currency-bdt" class="d-flex"></iconify-icon>
                                </span>
                                <span class="step-title">Payment Details</span>
                            </div>

                            <div class="row g-3">
                                @if ($paymentType === 'Installment Payment')
                                {{-- Installment Quantity --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:numeric" class="me-1 d-flex"></iconify-icon>
                                        Installment Quantity <span class="text-danger-600 ms-1">*</span>
                                    </label>
                                    <div class="d-flex gap-2 align-items-center">
                                        <select class="form-control radius-8 form-select" name="instalment_quantity" id="instalment_quantity" style="flex:1">
                                            <option value="0">Less than 1 Installment</option>
                                            @for ($i = 1; $i <= min(5, $summary['remaining_installments']); $i++)
                                                <option value="{{ $i }}" {{ $i === 1 ? 'selected' : '' }}>{{ $i }} Installment{{ $i > 1 ? 's' : '' }}</option>
                                            @endfor
                                            <option value="custom">Custom Installment Quantity</option>
                                        </select>
                                        <input type="number" min="1" max="{{ $summary['remaining_installments'] }}" class="form-control radius-8" id="custom_qty_input" placeholder="Qty" style="flex:0 0 100px; display:none;">
                                    </div>
                                    <small class="text-secondary-light mt-1 d-block" id="qtyHint">1 installment = ৳{{ format_bd_number($summary['adjusted_installment']) }}</small>
                                </div>
                                @endif

                                {{-- Amount --}}
                                <div class="{{ $paymentType === 'Installment Payment' ? 'col-md-6' : 'col-md-8' }}" id="amountWrapper">
                                    <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:currency-bdt" class="me-1 d-flex"></iconify-icon>
                                        Amount (৳) <span class="text-danger-600 ms-1">*</span>
                                    </label>
                                    @if ($paymentType === 'Booking Payment')
                                        @php $bookingDue = max(0, $summary['booking_payment_expected'] - $summary['booking_payments_received']); @endphp
                                        <input type="hidden" name="instalment_quantity" value="0">
                                        <input type="number" step="0.01" min="0.01" max="{{ $bookingDue }}" class="form-control radius-8 @error('amount') is-invalid @enderror" name="amount" id="payment_amount" value="{{ old('amount', $bookingDue) }}" required>
                                        <small class="text-secondary-light mt-1 d-block">Booking due: ৳{{ format_bd_number($bookingDue) }}</small>
                                    @elseif ($paymentType === 'Down Payment')
                                        <input type="hidden" name="instalment_quantity" value="0">
                                        <input type="number" step="0.01" min="0.01" max="{{ $summary['outstanding_balance'] }}" class="form-control radius-8 @error('amount') is-invalid @enderror" name="amount" id="payment_amount" value="{{ old('amount') }}" required>
                                        <small class="text-secondary-light mt-1 d-block">Outstanding balance: ৳{{ format_bd_number($summary['outstanding_balance']) }}</small>
                                    @else
                                        <input type="number" step="0.01" class="form-control radius-8 @error('amount') is-invalid @enderror" name="amount" id="payment_amount" value="{{ old('amount', $summary['adjusted_installment']) }}" required>
                                        <small class="text-secondary-light mt-1 d-block" id="amountHint">1 &times; ৳{{ format_bd_number($summary['adjusted_installment']) }}</small>
                                    @endif
                                    @error('amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Live Calculator (Installment Payment only) --}}
                                @if ($paymentType === 'Installment Payment')
                                <div class="col-12" id="calcInfoWrapper">
                                    <div class="calc-info-box p-12 radius-8">
                                        <div id="calcInfoContent"></div>
                                    </div>
                                </div>
                                @endif

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:calendar" class="me-1 d-flex"></iconify-icon>
                                        Payment Date
                                    </label>
                                    <input type="date" class="form-control radius-8 @error('payment_date') is-invalid @enderror" name="payment_date" value="{{ old('payment_date', date('Y-m-d')) }}">
                                    @error('payment_date')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:clock" class="me-1 d-flex"></iconify-icon>
                                        Payment Time
                                    </label>
                                    <input type="time" class="form-control radius-8 @error('payment_time') is-invalid @enderror" name="payment_time" value="{{ old('payment_time', date('H:i')) }}">
                                    @error('payment_time')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:note-text" class="me-1 d-flex"></iconify-icon>
                                        Payment Note
                                    </label>
                                    <textarea class="form-control radius-8 @error('payment_note') is-invalid @enderror" name="payment_note" rows="3" placeholder="Enter any notes about this payment...">{{ old('payment_note') }}</textarea>
                                    @error('payment_note')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-between gap-3 pt-20 border-top">
                            <a href="{{ route('admin.payments.create') }}" class="btn btn-outline-secondary px-32 py-12 radius-8 d-inline-flex align-items-center">
                                <iconify-icon icon="mdi:arrow-left" class="me-2 d-flex"></iconify-icon> Back
                            </a>
                            <button type="submit" class="btn btn-primary px-32 py-12 radius-8 d-inline-flex align-items-center" id="submitBtn">
                                <iconify-icon icon="mdi:check" class="me-2 d-flex"></iconify-icon> Record Payment
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
<style>
span.select2-dropdown.select2-dropdown--below {
    top: -40px;
}
.select2 > .selection{
    width: 100% !important;
}
.payment-form-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
}

.payment-form-header {
    background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);
    padding: 28px 24px;
}

.payment-form-icon {
    width: 56px;
    height: 56px;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    color: white;
}

.step-header {
    display: flex;
    align-items: center;
    gap: 12px;
}

.step-number {
    width: 32px;
    height: 32px;
    background: var(--primary-100);
    color: var(--primary-600);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
    font-size: 14px;
}

.step-title {
    font-weight: 600;
    font-size: 16px;
    color: #1f2937;
}

.payment-step {
    padding: 20px;
    background: #fafbfc;
    border-radius: 12px;
    border: 1px solid var(--neutral-200);
}

.booking-summary-card {
    background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%);
    border: 1px solid #86efac;
    border-radius: 12px;
    padding: 20px;
}

.summary-section {
    background: white;
    border-radius: 10px;
    padding: 16px;
    height: 100%;
}

.summary-title {
    font-size: 13px;
    font-weight: 600;
    color: #16a34a;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.summary-content {
    font-size: 14px;
}

.payment-overview {
    background: white;
    border-radius: 10px;
    padding: 16px;
}

.overview-box {
    background: #f9fafb;
    border-radius: 8px;
    padding: 12px;
    text-align: center;
}

.overview-label {
    display: block;
    font-size: 11px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 4px;
}

.overview-value {
    font-size: 18px;
    font-weight: 700;
}

.calc-info-box {
    background: transparent;
    border: none;
    padding: 0 !important;
}

.calc-inline-item {
    flex: 1;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 3px;
    padding: 10px 12px;
    background: #fffbeb;
    border: 1px solid #fde68a;
    border-radius: 8px;
    text-align: center;
    min-width: 0;
}

.calc-inline-label {
    font-size: 14px;
    color: #9ca3af;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    font-weight: 500;
    white-space: nowrap;
}

.calc-inline-val {
    font-size: 13px;
    font-weight: 700;
    color: #1f2937;
    line-height: 1.3;
    white-space: nowrap;
}

.form-control:focus,
.form-select:focus {
    border-color: #22c55e;
    box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.1);
}

/* Select2 Full Width Fix */
.select2-container {
    width: 100% !important;
}

.select2-container--bootstrap-5 .select2-selection {
    min-height: 46px;
    border-radius: 8px !important;
    border: 1px solid var(--neutral-300) !important;
    padding: 6px 12px;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__rendered {
    line-height: 32px;
}

.select2-container--bootstrap-5 .select2-selection--single .select2-selection__arrow {
    height: 44px;
}

.select2-container--bootstrap-5 .select2-dropdown {
    border-radius: 8px;
    border: 1px solid var(--neutral-300);
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
}

.select2-container--bootstrap-5 .select2-results__option--highlighted[aria-selected] {
    background-color: #22c55e !important;
}

.select2-container--bootstrap-5 .select2-search--dropdown .select2-search__field {
    border-radius: 6px;
    padding: 8px 12px;
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script>
$(document).ready(function() {

    @if (!$selectedBooking)
    // ===== Step 1: Selection Page =====

    // Init Select2 for booking dropdown
    $('#booking_select').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search booking by name, phone, plot number...',
        allowClear: true,
        width: '100%'
    });

    // Enable Continue button when both fields selected
    function checkContinue() {
        var type = $('#payment_type').val();
        var booking = $('#booking_select').val();
        $('#continueBtn').prop('disabled', !(type && booking));
    }

    $('#payment_type').on('change', checkContinue);
    $('#booking_select').on('change', checkContinue);

    @else
    // ===== Step 2: Payment Form =====

    var summaryData = @json($summary);

    function formatBD(num) {
        num = parseFloat(num) || 0;
        var parts = num.toFixed(2).split('.');
        var intPart = parts[0];
        var decPart = parts[1];
        var lastThree = intPart.slice(-3);
        var remaining = intPart.slice(0, -3);
        if (remaining.length > 0) lastThree = ',' + lastThree;
        var formatted = remaining.replace(/\B(?=(\d{2})+(?!\d))/g, ',') + lastThree;
        return '৳' + formatted + '.' + decPart;
    }

    @if ($paymentType === 'Installment Payment')
    var adjustedEMI = parseFloat(summaryData.adjusted_installment);
    var remainingInst = parseInt(summaryData.remaining_installments);
    var outstandingBalance = parseFloat(summaryData.outstanding_balance);
    var partialAccum = parseFloat(summaryData.partial_toward_current_instalment) || 0;
    var remainingForCurrent = Math.max(0, adjustedEMI - partialAccum);

    // Get effective quantity from dropdown or custom input
    function getEffectiveQty() {
        var val = $('#instalment_quantity').val();
        if (val === 'custom') {
            return parseInt($('#custom_qty_input').val()) || 0;
        }
        return parseInt(val) || 0;
    }

    // Installment quantity dropdown change
    $('#instalment_quantity').on('change', function() {
        var val = $(this).val();

        if (val === 'custom') {
            // Show custom input
            $('#custom_qty_input').show().val('').focus();
            $('#payment_amount').val('');
            $('#amountHint').text('Enter quantity to calculate amount');
            $('#qtyHint').html('<span class="text-info-600">Enter a custom quantity</span>');
            // Restore payment type to Installment Payment
            $('#hidden_payment_type').val('Installment Payment');
            updateCalcInfo();
            return;
        }

        // Hide custom input for preset options
        $('#custom_qty_input').hide().val('');

        var qty = parseInt(val);
        if (qty === 0) {
            // "Less than 1" — partial payment mode → Part Of Installment
            $('#hidden_payment_type').val('Part Of Installment');
            $('#payment_amount').val('').focus();
            $('#amountHint').text('Enter a partial amount (less than 1 installment)');
            $('#qtyHint').html('<span class="text-warning-600">Part of Installment mode</span>');
        } else {
            // Restore payment type to Installment Payment
            $('#hidden_payment_type').val('Installment Payment');
            // For qty=1, account for accumulated partial payments toward current installment
            var firstInstAmt = (partialAccum > 0 && qty >= 1) ? remainingForCurrent : adjustedEMI;
            var amount = Math.min(firstInstAmt + Math.max(0, qty - 1) * adjustedEMI, outstandingBalance).toFixed(2);
            $('#payment_amount').val(amount);
            if (partialAccum > 0 && qty == 1) {
                $('#amountHint').text('Remaining for current installment: ' + formatBD(remainingForCurrent));
            } else {
                $('#amountHint').text(qty + ' \u00d7 ' + formatBD(adjustedEMI));
            }
            $('#qtyHint').text('1 installment = ' + formatBD(adjustedEMI));
        }
        updateCalcInfo();
    });

    // Custom quantity input change
    $('#custom_qty_input').on('input change', function() {
        var qty = parseInt($(this).val()) || 0;
        if (qty > 0) {
            // Update the hidden select value for form submission
            $('#instalment_quantity').val('custom');
            // Set a hidden field or override name
            $(this).attr('name', 'instalment_quantity');
            $('#instalment_quantity').removeAttr('name');
            $('#hidden_payment_type').val('Installment Payment');
            var firstInstAmt = (partialAccum > 0 && qty >= 1) ? remainingForCurrent : adjustedEMI;
            var amount = Math.min(firstInstAmt + Math.max(0, qty - 1) * adjustedEMI, outstandingBalance).toFixed(2);
            $('#payment_amount').val(amount);
            if (partialAccum > 0 && qty == 1) {
                $('#amountHint').text('Remaining for current installment: ' + formatBD(remainingForCurrent));
            } else {
                $('#amountHint').text(qty + ' \u00d7 ' + formatBD(adjustedEMI));
            }
            $('#qtyHint').text('1 installment = ' + formatBD(adjustedEMI));
        } else {
            $('#payment_amount').val('');
            $('#amountHint').text('Enter quantity to calculate amount');
        }
        updateCalcInfo();
    });

    // When typing amount (partial mode)
    $('#payment_amount').on('input change', function() {
        updateCalcInfo();
    });

    function updateCalcInfo() {
        var amount = parseFloat($('#payment_amount').val()) || 0;
        var qty = getEffectiveQty();
        var remaining = Math.max(0, outstandingBalance - amount);
        var newRemainingInst = Math.max(0, remainingInst - qty);
        // For EMI recalc, add back any uncommitted partials to remaining balance
        var remainingForEMI = remaining + (partialAccum > 0 && qty > 0 ? 0 : partialAccum);
        var newEMI = newRemainingInst > 0 ? (remainingForEMI / newRemainingInst) : 0;

        var parts = [];

        parts.push('<div class="calc-inline-item"><span class="calc-inline-label">Remaining Balance</span><span class="calc-inline-val text-danger-600">' + formatBD(remaining) + '</span></div>');

        if (qty > 0) {
            parts.push('<div class="calc-inline-item"><span class="calc-inline-label">Installments Covered</span><span class="calc-inline-val">' + qty + ' of ' + remainingInst + '</span></div>');
        } else if (amount > 0 && adjustedEMI > 0) {
            var pct = ((amount / adjustedEMI) * 100).toFixed(0);
            parts.push('<div class="calc-inline-item"><span class="calc-inline-label">Partial</span><span class="calc-inline-val text-warning-600">' + pct + '% of EMI</span></div>');
        }

        parts.push('<div class="calc-inline-item"><span class="calc-inline-label">Installments Left</span><span class="calc-inline-val">' + newRemainingInst + '</span></div>');

        if (qty > 0 && newRemainingInst > 0 && remaining > 0) {
            parts.push('<div class="calc-inline-item"><span class="calc-inline-label">New EMI</span><span class="calc-inline-val text-primary-600">' + formatBD(newEMI) + '</span></div>');
        }

        var html = '<div class="d-flex gap-2 w-100">' + parts.join('') + '</div>';

        if (amount > 0 && remaining <= 0.01) {
            html += '<div class="mt-2 text-sm fw-semibold text-success-600"><iconify-icon icon="mdi:check-circle" class="me-1"></iconify-icon>Clears all remaining balance!</div>';
        }

        $('#calcInfoContent').html(html);
    }

    // Initial calc
    updateCalcInfo();
    @endif

    // Form validation
    $('#paymentForm').on('submit', function(e) {
        var amount = parseFloat($('#payment_amount').val()) || 0;
        if (amount <= 0) {
            e.preventDefault();
            alert('Please enter a valid amount.');
            return;
        }
        if (amount > parseFloat(summaryData.outstanding_balance) + 0.01) {
            e.preventDefault();
            alert('Amount exceeds outstanding balance of ' + formatBD(summaryData.outstanding_balance));
            return;
        }
    });

    @endif
});
</script>
@endpush
@endsection
