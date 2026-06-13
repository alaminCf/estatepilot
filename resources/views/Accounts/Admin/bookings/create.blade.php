@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Add New Booking</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('admin.bookings.index') }}" class="hover-text-primary">Bookings</a>
        </li>
        <li>-</li>
        <li class="fw-medium">Add New</li>
    </ul>
</div>

<form action="{{ route('admin.bookings.store') }}" method="POST">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger mb-20">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card booking-form-card">
                <div class="card-body p-0">
                    <!-- Header -->
                    <div class="booking-form-header">
                        <div class="d-flex align-items-center gap-3">
                            <div class="booking-form-icon">
                                <iconify-icon icon="hugeicons:invoice-03" class="icon"></iconify-icon>
                            </div>
                            <div>
                                <h5 class="mb-1 text-white">Create New Booking</h5>
                                <p class="mb-0 text-white-50 text-sm">Fill in the details to create a new plot booking</p>
                            </div>
                        </div>
                    </div>

                    <div class="p-24">
                        <!-- Step 1: Selection -->
                        <div class="booking-step" id="step1">
                            <div class="step-header mb-20">
                                <span class="step-number">1</span>
                                <span class="step-title">Select Plot & Customer</span>
                            </div>
                            
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:land-plots" class="me-1 d-flex"></iconify-icon>
                                        Select Plot <span class="text-danger-600 ms-1">*</span>
                                    </label>
                                    <select class="form-control radius-8 form-select @error('plot_id') is-invalid @enderror" id="plot_id" name="plot_id" required>
                                        <option value="">Choose a plot...</option>
                                        @foreach($plots as $plot)
                                            <option value="{{ $plot->id }}" 
                                                data-price="{{ $plot->price }}"
                                                data-booking-payment="{{ $plot->booking_payment }}"
                                                data-remaining-payment="{{ $plot->price - ($plot->booking_payment ?? 0) }}"
                                                data-installment-plan="{{ $plot->installment_plan }}"
                                                data-total-installments="{{ $plot->total_installments }}"
                                                data-installment-payment="{{ $plot->installment_payment }}"
                                                {{ old('plot_id') == $plot->id ? 'selected' : '' }}>
                                                {{ $plot->plot_no }} - {{ $plot->title }} (৳{{ format_bd_number($plot->price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('plot_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="col-md-6">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8 d-flex align-items-center">
                                        <iconify-icon icon="mdi:account" class="me-1 d-flex"></iconify-icon>
                                        Select Customer <span class="text-danger-600 ms-1">*</span>
                                    </label>
                                    <select class="form-control radius-8 form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
                                        <option value="">Choose a customer...</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}" 
                                                data-name="{{ $user->name }}"
                                                data-email="{{ $user->email }}"
                                                data-phone="{{ $user->phone }}"
                                                data-address="{{ $user->address ?? 'N/A' }}"
                                                {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                                {{ $user->name }} ({{ $user->phone }})
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('user_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="text-end mt-20">
                                <button type="button" class="btn btn-primary px-32 py-12 radius-8 d-inline-flex align-items-center" id="continueBtn">
                                    Continue <iconify-icon icon="mdi:arrow-right" class="ms-2 d-flex"></iconify-icon>
                                </button>
                            </div>
                        </div>

                        <!-- Step 2: Details (Hidden initially) -->
                        <div id="step2" style="display: none;">
                            <!-- Customer Info Preview -->
                            <div class="customer-preview-card mb-24">
                                <div class="step-header mb-16">
                                    <span class="step-number">2</span>
                                    <span class="step-title">Customer Information</span>
                                </div>
                                <div class="row g-3">
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <span class="info-label">Name</span>
                                            <span class="info-value" id="display_customer_name">-</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <span class="info-label">Phone</span>
                                            <span class="info-value" id="display_customer_phone">-</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <span class="info-label">Email</span>
                                            <span class="info-value" id="display_customer_email">-</span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-md-3">
                                        <div class="info-item">
                                            <span class="info-label">Address</span>
                                            <span class="info-value" id="display_customer_address">-</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Pricing Section -->
                            <div class="booking-step mb-24">
                                <div class="step-header mb-20">
                                    <span class="step-number">3</span>
                                    <span class="step-title">Pricing & Payment</span>
                                </div>
                                
                                <div class="row g-3">
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Total Price (৳) <span class="text-danger-600">*</span></label>
                                        <input type="number" step="0.01" class="form-control radius-8 @error('price') is-invalid @enderror" id="price" name="price" placeholder="0.00" value="{{ old('price') }}" required>
                                        @error('price')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Booking Payment (৳) <span class="text-danger-600">*</span></label>
                                        <input type="number" step="0.01" class="form-control radius-8 @error('booking_payment') is-invalid @enderror" id="booking_payment" name="booking_payment" placeholder="0.00" value="{{ old('booking_payment') }}" required>
                                        @error('booking_payment')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Remaining Payment (৳)</label>
                                        <input type="number" step="0.01" class="form-control radius-8 bg-neutral-100" id="remaining_payment" placeholder="0.00" value="{{ old('remaining_payment') }}" readonly>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Installment Plan</label>
                                        <select class="form-control radius-8 form-select" id="installment_plan" name="installment_plan">
                                            <option value="">Select Plan</option>
                                            <option value="monthly" {{ old('installment_plan') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="quarterly" {{ old('installment_plan') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                        </select>
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Total Installments</label>
                                        <input type="number" class="form-control radius-8" id="total_installments" name="total_installments" placeholder="e.g., 36" value="{{ old('total_installments') }}">
                                    </div>

                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Installment Payment (৳)</label>
                                        <input type="number" step="0.01" class="form-control radius-8 bg-neutral-100" id="installment_payment" name="installment_payment" placeholder="0.00" value="{{ old('installment_payment') }}" readonly>
                                    </div>
                                </div>
                            </div>

                            <!-- Additional Details -->
                            <div class="booking-step mb-24">
                                <div class="step-header mb-20">
                                    <span class="step-number">4</span>
                                    <span class="step-title">Additional Details</span>
                                </div>
                                
                                <div class="row g-3">
                                    <!-- Owners Section -->
                                    <div class="col-12 mb-3">
                                        <div class="d-flex align-items-center justify-content-between mb-12">
                                            <label class="form-label fw-semibold text-primary-light text-sm mb-0 d-flex align-items-center">
                                                <iconify-icon icon="mdi:account-group" class="me-1 d-flex"></iconify-icon>
                                                Additional Owners
                                            </label>
                                            <button type="button" class="btn btn-sm btn-primary-light d-inline-flex align-items-center" id="addOwnerBtn">
                                                <iconify-icon icon="mdi:plus" class="me-1 d-flex"></iconify-icon> Add Additional Owner
                                            </button>
                                        </div>
                                        <div id="ownersContainer">
                                            <!-- Owner entries will be added here dynamically -->
                                        </div>
                                        <div id="noOwnersMessage" class="text-center py-24" style="background: linear-gradient(135deg, #f8fafc, #f1f5f9); border: 2px dashed #cbd5e1; border-radius: 12px;">
                                            <div class="d-inline-flex align-items-center justify-content-center mb-12" style="width:64px;height:64px;background:linear-gradient(135deg,var(--primary-100),#dbeafe);border-radius:16px;">
                                                <iconify-icon icon="mdi:account-multiple-plus" style="font-size:32px;color:var(--primary-600);"></iconify-icon>
                                            </div>
                                            <h6 class="fw-semibold text-neutral-600 mb-4">No Owners Added Yet</h6>
                                            <p class="text-sm text-secondary-light mb-0">Click <strong class="text-primary-600">"Add Additional Owner"</strong> above to add additional owners.</p>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Booking Date</label>
                                        <input type="date" class="form-control radius-8 @error('booking_date') is-invalid @enderror" id="booking_date" name="booking_date" value="{{ old('booking_date', date('Y-m-d')) }}">
                                        @error('booking_date')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Booking Time</label>
                                        <input type="time" class="form-control radius-8 @error('booking_time') is-invalid @enderror" id="booking_time" name="booking_time" value="{{ old('booking_time', date('H:i')) }}">
                                        @error('booking_time')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Seller (Commission User)</label>
                                        <select class="form-control radius-8 form-select @error('referral_agent_id') is-invalid @enderror" id="referral_agent_id" name="referral_agent_id">
                                            <option value="">No Seller</option>
                                            @foreach($agents as $agent)
                                                <option value="{{ $agent->id }}" {{ old('referral_agent_id') == $agent->id ? 'selected' : '' }}>
                                                    {{ $agent->name }} — {{ $agent->commissionTypeLabel() }} @if($agent->referral_code)({{ $agent->referral_code }})@endif
                                                </option>
                                            @endforeach
                                        </select>
                                        <small class="text-secondary-light">Commission is distributed per the commission chart when payments are recorded</small>
                                        @error('referral_agent_id')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Booking Status</label>
                                        <select class="form-control radius-8 form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                                            <option value="pending" {{ old('status', 'pending') == 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="pre-booked" {{ old('status') == 'pre-booked' ? 'selected' : '' }}>Pre-Booked</option>
                                            <option value="approved" {{ old('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                                            <option value="cancelled" {{ old('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                        @error('status')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-md-6" id="customBookingAmountSection" style="{{ old('status') == 'pre-booked' ? '' : 'display:none' }}">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Custom Booking Amount (৳)</label>
                                        <input type="number" step="0.01" class="form-control radius-8 @error('custom_booking_amount') is-invalid @enderror" id="custom_booking_amount" name="custom_booking_amount" placeholder="0.00" value="{{ old('custom_booking_amount') }}">
                                        <small class="text-secondary-light">Amount paid for pre-booking (less than full booking payment)</small>
                                        @error('custom_booking_amount')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Additional Information</label>
                                        <textarea class="form-control radius-8 @error('additional_info') is-invalid @enderror" id="additional_info" name="additional_info" rows="3" placeholder="Enter any additional notes...">{{ old('additional_info') }}</textarea>
                                        @error('additional_info')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="d-flex justify-content-between gap-3 pt-20 border-top">
                                <button type="button" class="btn btn-outline-secondary px-32 py-12 radius-8 d-inline-flex align-items-center" id="backBtn">
                                    <iconify-icon icon="mdi:arrow-left" class="me-2 d-flex"></iconify-icon> Back
                                </button>
                                <div class="d-flex gap-3">
                                    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-danger px-32 py-12 radius-8">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary px-32 py-12 radius-8 d-inline-flex align-items-center">
                                        <iconify-icon icon="mdi:check" class="me-2 d-flex"></iconify-icon> Create Booking
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>

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
/* Booking Form Styles */
.booking-form-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 25px rgba(0, 0, 0, 0.08);
}

.booking-form-header {
    background: linear-gradient(135deg, var(--primary-600) 0%, var(--primary-800) 100%);
    padding: 28px 24px;
}

.booking-form-icon {
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

.customer-preview-card {
    background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
    border-radius: 12px;
    padding: 20px;
    border: 1px dashed var(--neutral-300);
}

.info-item {
    display: flex;
    flex-direction: column;
    gap: 4px;
}

.info-label {
    font-size: 12px;
    color: var(--secondary-light);
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.info-value {
    font-weight: 600;
    color: #1f2937;
    font-size: 14px;
}

.booking-step {
    padding: 20px;
    background: #fafbfc;
    border-radius: 12px;
    border: 1px solid var(--neutral-200);
}

/* Form Controls Enhancement */
.form-control:focus,
.form-select:focus {
    border-color: var(--primary-400);
    box-shadow: 0 0 0 3px rgba(var(--primary-600-rgb), 0.1);
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
    background-color: var(--primary-600) !important;
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

    // Init Select2 for Plot dropdown
    $('#plot_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search by plot number or title...',
        allowClear: true,
        width: '100%'
    });

    // Init Select2 for Customer dropdown
    $('#user_id').select2({
        theme: 'bootstrap-5',
        placeholder: 'Search by name or phone...',
        allowClear: true,
        width: '100%'
    });

    // Step navigation
    $('#continueBtn').on('click', function() {
        const plotId = $('#plot_id').val();
        const userId = $('#user_id').val();
        
        if (!plotId || !userId) {
            alert('Please select both plot and customer before continuing.');
            return;
        }
        
        // Show step 2
        $('#step2').slideDown();
        $('#step1').find('.text-end').hide();
        
        // Load customer data
        const selectedUser = $('#user_id').find('option:selected');
        $('#display_customer_name').text(selectedUser.data('name'));
        $('#display_customer_email').text(selectedUser.data('email'));
        $('#display_customer_phone').text(selectedUser.data('phone'));
        $('#display_customer_address').text(selectedUser.data('address') || 'N/A');
        
        // Load plot pricing data
        const selectedPlot = $('#plot_id').find('option:selected');
        $('#price').val(selectedPlot.data('price'));
        $('#booking_payment').val(selectedPlot.data('booking-payment'));
        $('#remaining_payment').val(selectedPlot.data('remaining-payment'));
        $('#installment_plan').val(selectedPlot.data('installment-plan') || '');
        $('#total_installments').val(selectedPlot.data('total-installments') || '');
        $('#installment_payment').val(selectedPlot.data('installment-payment') || '');
        
        // Scroll to step 2
        $('html, body').animate({
            scrollTop: $('#step2').offset().top - 100
        }, 500);
    });

    $('#backBtn').on('click', function() {
        $('#step2').slideUp();
        $('#step1').find('.text-end').show();
    });
    
    // Auto-calculate remaining payment
    function calculateRemainingPayment() {
        const totalPrice = parseFloat($('#price').val()) || 0;
        const bookingPayment = parseFloat($('#booking_payment').val()) || 0;
        
        if (totalPrice > 0 && bookingPayment >= 0) {
            const remainingPayment = (totalPrice - bookingPayment).toFixed(2);
            $('#remaining_payment').val(remainingPayment);
            calculateInstallment();
        }
    }
    
    // Auto-calculate installment payment
    function calculateInstallment() {
        const remainingPayment = parseFloat($('#remaining_payment').val()) || 0;
        const totalInstallments = parseInt($('#total_installments').val()) || 0;
        
        if (remainingPayment > 0 && totalInstallments > 0) {
            const installmentPayment = (remainingPayment / totalInstallments).toFixed(2);
            $('#installment_payment').val(installmentPayment);
        } else {
            $('#installment_payment').val('');
        }
    }
    
    // Trigger calculations
    $('#price, #booking_payment').on('input change', function() {
        calculateRemainingPayment();
    });
    
    $('#remaining_payment, #total_installments').on('input change', function() {
        calculateInstallment();
    });

    // Toggle custom booking amount field based on status
    $('#status').on('change', function() {
        if ($(this).val() === 'pre-booked') {
            $('#customBookingAmountSection').slideDown();
        } else {
            $('#customBookingAmountSection').slideUp();
            $('#custom_booking_amount').val('');
        }
    });

    // ===== Owners Management =====
    let ownerIndex = 0;

    function createOwnerCard(index) {
        return `
        <div class="owner-card card border mb-16" data-owner-index="${index}">
            <div class="card-header py-12 px-16 bg-neutral-50 d-flex justify-content-between align-items-center">
                <h6 class="mb-0 text-sm fw-semibold d-flex align-items-center">
                    <iconify-icon icon="mdi:account" class="me-1 d-flex text-primary-600"></iconify-icon>
                    Additional Owner #<span class="owner-number">${index + 1}</span>
                </h6>
                <button type="button" class="btn btn-sm btn-danger-light d-inline-flex align-items-center remove-owner-btn" title="Remove Owner">
                    <iconify-icon icon="mdi:close" class="d-flex"></iconify-icon>
                </button>
            </div>
            <div class="card-body p-16">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="form-label text-sm mb-4">Name <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][name]" placeholder="Full Name" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-sm mb-4">Phone <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][phone]" placeholder="Phone Number" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-sm mb-4">NID <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][nid]" placeholder="National ID" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-sm mb-4">Address <span class="text-danger-600">*</span></label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][address]" placeholder="Full Address" required>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-sm mb-4">Father's Name</label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][father_name]" placeholder="Father's Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-sm mb-4">Mother's Name</label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][mother_name]" placeholder="Mother's Name">
                    </div>
                    <div class="col-md-4">
                        <label class="form-label text-sm mb-4">Spouse's Name</label>
                        <input type="text" class="form-control radius-8 form-control-sm" name="owners[${index}][spouse_name]" placeholder="Spouse's Name">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label text-sm mb-4">Nominee Info</label>
                        <textarea rows="3" class="form-control radius-8 form-control-sm" name="owners[${index}][nominee_info]" placeholder="Nominee name, relation, NID, phone, address, etc."></textarea>
                    </div>
                </div>
            </div>
        </div>`;
    }

    function updateOwnerNumbers() {
        $('#ownersContainer .owner-card').each(function(i) {
            $(this).find('.owner-number').text(i + 1);
        });
        const hasOwners = $('#ownersContainer .owner-card').length > 0;
        $('#noOwnersMessage').toggle(!hasOwners);
    }

    $('#addOwnerBtn').on('click', function() {
        $('#ownersContainer').append(createOwnerCard(ownerIndex));
        ownerIndex++;
        updateOwnerNumbers();
    });

    $(document).on('click', '.remove-owner-btn', function() {
        $(this).closest('.owner-card').slideUp(200, function() {
            $(this).remove();
            updateOwnerNumbers();
        });
    });
});
</script>
@endpush
@endsection
