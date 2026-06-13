@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Booking Details</h6>
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
        <li class="fw-medium">View #{{ $booking->id }}</li>
    </ul>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if(session('error'))
<div class="alert alert-danger alert-dismissible fade show mb-24" role="alert">
    {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row gy-4">
    <!-- Left Column - Booking Overview -->
    <div class="col-lg-4">
        <!-- Customer Card -->
        <div class="card customer-card mb-24">
            <div class="customer-card-header">
                <div class="customer-avatar-wrapper">
                    @if($booking->user->photo)
                        <img src="{{ $booking->user->profile_image_url }}" alt="{{ $booking->user->name }}" class="customer-avatar">
                    @else
                        <div class="customer-avatar-placeholder">
                            {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                <div class="customer-name-section">
                    <h5 class="customer-name">{{ $booking->user->name }}</h5>
                    <span class="customer-role">CID-{{ str_pad($booking->user->client_id, 5, '0', STR_PAD_LEFT) }} | Customer</span>
                </div>
            </div>
            <div class="card-body">
                <ul class="customer-info-list">
                    <li>
                        <iconify-icon icon="mdi:phone" class="info-icon"></iconify-icon>
                        <div>
                            <span class="info-label">Phone</span>
                            <span class="info-value">{{ $booking->user->phone }}</span>
                        </div>
                    </li>
                    <li>
                        <iconify-icon icon="mdi:email" class="info-icon"></iconify-icon>
                        <div>
                            <span class="info-label">Email</span>
                            <span class="info-value">{{ $booking->user->email }}</span>
                        </div>
                    </li>
                    @if($booking->user->address)
                    <li>
                        <iconify-icon icon="mdi:map-marker" class="info-icon"></iconify-icon>
                        <div>
                            <span class="info-label">Address</span>
                            <span class="info-value">{{ $booking->user->address }}</span>
                        </div>
                    </li>
                    @endif
                </ul>
                <div class="mt-16 pt-16 border-top">
                    <a href="{{ route('admin.users.show', $booking->user->id) }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
                        <iconify-icon icon="mdi:eye"></iconify-icon>
                        View Customer
                    </a>
                </div>
            </div>
        </div>

        <!-- Booking Status Card -->
        <div class="card booking-overview-card">
            <div class="booking-status-header status-{{ $booking->status }}">
                <div class="status-icon-wrapper">
                    @if($booking->status == 'approved')
                        <iconify-icon icon="mdi:check-circle" class="status-icon"></iconify-icon>
                    @elseif($booking->status == 'pending')
                        <iconify-icon icon="mdi:clock-outline" class="status-icon"></iconify-icon>
                    @elseif($booking->status == 'pre-booked')
                        <iconify-icon icon="mdi:bookmark-outline" class="status-icon"></iconify-icon>
                    @else
                        <iconify-icon icon="mdi:close-circle" class="status-icon"></iconify-icon>
                    @endif
                </div>
                <div class="status-info">
                    <span class="status-label">Booking Status</span>
                    <span class="status-value">{{ ucfirst($booking->status) }}</span>
                </div>
                <button type="button" class="btn btn-sm btn-light edit-status-btn d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editBookingModal">
                    <iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Edit
                </button>
            </div>
            <div class="card-body">
                <div class="booking-meta">
                    <div class="meta-item">
                        <iconify-icon icon="mdi:pound" class="meta-icon"></iconify-icon>
                        <div class="flex-grow-1">
                            <span class="meta-label">Booking ID</span>
                            <span class="meta-value">#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editBookingIdModal">
                            <iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Edit
                        </button>
                    </div>
                    <div class="meta-item">
                        <iconify-icon icon="mdi:calendar" class="meta-icon"></iconify-icon>
                        <div class="flex-grow-1">
                            <span class="meta-label">Booking Date</span>
                            <span class="meta-value">
                                @if($booking->booking_date)
                                    {{ $booking->booking_date->format('d M, Y h:i A') }}
                                @else
                                    {{ $booking->created_at->format('d M, Y') }}
                                @endif
                            </span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-info d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editBookingDateModal">
                            <iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Edit
                        </button>
                    </div>
                    <div class="meta-item">
                        <iconify-icon icon="mdi:clock" class="meta-icon"></iconify-icon>
                        <div>
                            <span class="meta-label">Last Updated</span>
                            <span class="meta-value">{{ $booking->updated_at->format('d M, Y H:i') }}</span>
                        </div>
                    </div>
                    @if($booking->referral_agent_id && $booking->agent)
                    <div class="meta-item">
                        <iconify-icon icon="mdi:account-tie" class="meta-icon"></iconify-icon>
                        <div class="flex-grow-1">
                            <span class="meta-label">Seller</span>
                            <span class="meta-value">{{ $booking->agent->name }}@if($booking->agent->commission_type) <span class="badge bg-primary-50 text-primary-600">{{ $booking->agent->commissionTypeLabel() }}</span>@endif</span>
                            @if($booking->agent->referral_code)
                            <span class="meta-sub">Code: {{ $booking->agent->referral_code }}</span>
                            @endif
                            @if($booking->isFlatScheme() && $booking->agent_commission)
                            <span class="meta-sub text-success-600">Commission: {{ $booking->agent_commission }}% (legacy flat rate)</span>
                            @endif
                            @if($booking->isHierarchyScheme())
                            <span class="meta-sub text-success-600">Commission: distributed per chart on each payment</span>
                            @endif
                            @if($booking->agent_changed_at)
                            <span class="meta-sub text-warning-600">Changed on: {{ $booking->agent_changed_at->format('d M, Y h:i A') }}</span>
                            @endif
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-warning d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#changeAgentModal">
                            <iconify-icon icon="mdi:swap-horizontal" class="me-1 d-flex"></iconify-icon> Change
                        </button>
                    </div>
                    @else
                    <div class="meta-item">
                        <iconify-icon icon="mdi:account-tie" class="meta-icon"></iconify-icon>
                        <div class="flex-grow-1">
                            <span class="meta-label">Seller</span>
                            <span class="meta-value text-secondary-light">No Seller Assigned</span>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-primary d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#changeAgentModal">
                            <iconify-icon icon="mdi:plus" class="me-1 d-flex"></iconify-icon> Assign
                        </button>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Pre-Booking Expiry Notice -->
        @if($booking->status == 'pre-booked' && $booking->pre_booking_expires_at)
        <div class="card mt-24 border-warning">
            <div class="card-body p-16">
                <div class="d-flex align-items-start gap-12">
                    <div class="flex-shrink-0">
                        <iconify-icon icon="mdi:clock-alert" class="text-warning-600" style="font-size: 32px;"></iconify-icon>
                    </div>
                    <div>
                        <h6 class="mb-4 text-warning-600 fw-bold">Pre-Booking Notice</h6>
                        <p class="mb-4 text-sm">This is a <strong>pre-booked</strong> booking with a custom payment amount of <strong>৳{{ format_bd_number($booking->custom_booking_amount, 2) }}</strong>.</p>
                        <p class="mb-0 text-sm {{ $booking->pre_booking_expires_at->isPast() ? 'text-danger-600 fw-bold' : '' }}">
                            @if($booking->pre_booking_expires_at->isPast())
                                <iconify-icon icon="mdi:alert" class="me-1"></iconify-icon>
                                <strong>EXPIRED:</strong> This pre-booking expired on {{ $booking->pre_booking_expires_at->format('d M, Y h:i A') }}. The full booking money was not paid in time.
                            @else
                                Expires on: <strong>{{ $booking->pre_booking_expires_at->format('d M, Y h:i A') }}</strong> 
                                ({{ $booking->pre_booking_expires_at->diffForHumans() }})
                            @endif
                        </p>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <!-- Additional Information Card -->
        <div class="card additional-info-card mt-24">
            <div class="card-header py-16 px-24 bg-base d-flex justify-content-between align-items-center">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:note-text" class="text-primary-600"></iconify-icon>
                    Additional Information
                </h6>
                <button type="button" class="btn btn-sm btn-primary-light d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editBookingModal">
                    <iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Edit
                </button>
            </div>
            <div class="card-body">
                @if($booking->additional_info)
                    <p class="mb-0 additional-info-text">{{ $booking->additional_info }}</p>
                @else
                    <div class="no-info-placeholder">
                        <iconify-icon icon="mdi:text-box-outline" class="no-info-icon"></iconify-icon>
                        <span>No additional information provided</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Additional Owners Card -->
        <div class="card mt-24">
            <div class="card-header py-16 px-24 bg-base d-flex justify-content-between align-items-center">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:account-group" class="text-primary-600"></iconify-icon>
                    Additional Owners
                    @if($booking->owners && count($booking->owners) > 0)
                        <span class="badge bg-primary-600 text-white ms-2">{{ count($booking->owners) }}</span>
                    @endif
                </h6>
                <button type="button" class="btn btn-sm btn-primary-light d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#editOwnersModal">
                    <iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Edit
                </button>
            </div>
            <div class="card-body">
                @if($booking->owners && count($booking->owners) > 0)
                    <div class="row g-3">
                        @foreach($booking->owners as $index => $owner)
                        <div class="col-md-6">
                            <div class="border radius-12 p-16 h-100 owner-detail-card">
                                <div class="d-flex align-items-center gap-12 mb-12 pb-12 border-bottom">
                                    <div>
                                        <h6 class="mb-0 fw-bold text-md">{{ $owner['name'] ?? 'N/A' }}</h6>
                                        <span class="text-sm text-secondary-light">Additional Owner #{{ $index + 1 }}</span>
                                    </div>
                                </div>
                                <div class="owner-info-grid">
                                    <div class="owner-info-row">
                                        <iconify-icon icon="mdi:phone" class="text-primary-600"></iconify-icon>
                                        <span class="text-sm"><strong>Phone:</strong> {{ $owner['phone'] ?? 'N/A' }}</span>
                                    </div>
                                    <div class="owner-info-row">
                                        <iconify-icon icon="mdi:card-account-details" class="text-primary-600"></iconify-icon>
                                        <span class="text-sm"><strong>NID:</strong> {{ $owner['nid'] ?? 'N/A' }}</span>
                                    </div>
                                    <div class="owner-info-row">
                                        <iconify-icon icon="mdi:map-marker" class="text-primary-600"></iconify-icon>
                                        <span class="text-sm"><strong>Address:</strong> {{ $owner['address'] ?? 'N/A' }}</span>
                                    </div>
                                    @if(!empty($owner['father_name']))
                                    <div class="owner-info-row">
                                        <iconify-icon icon="mdi:account" class="text-info-600"></iconify-icon>
                                        <span class="text-sm"><strong>Father:</strong> {{ $owner['father_name'] }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($owner['mother_name']))
                                    <div class="owner-info-row">
                                        <iconify-icon icon="mdi:account" class="text-info-600"></iconify-icon>
                                        <span class="text-sm"><strong>Mother:</strong> {{ $owner['mother_name'] }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($owner['spouse_name']))
                                    <div class="owner-info-row">
                                        <iconify-icon icon="mdi:heart" class="text-danger-600"></iconify-icon>
                                        <span class="text-sm"><strong>Spouse:</strong> {{ $owner['spouse_name'] }}</span>
                                    </div>
                                    @endif
                                    @if(!empty($owner['nominee_info']))
                                    <div class="owner-info-row align-items-start">
                                        <iconify-icon icon="mdi:account-multiple" class="text-success-600 mt-1"></iconify-icon>
                                        <span class="text-sm"><strong>Nominee Info:</strong><br>{!! nl2br(e($owner['nominee_info'])) !!}</span>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-24">
                        <iconify-icon icon="mdi:account-group-outline" class="text-neutral-400" style="font-size: 40px;"></iconify-icon>
                        <p class="text-neutral-600 mt-8 mb-0">No owners added for this booking</p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Right Column - Plot & Payment Details -->
    <div class="col-lg-8">
        <!-- Plot Details Card -->
        <div class="card plot-details-card mb-24">
            <div class="plot-header">
                <div class="plot-badge">
                    <iconify-icon icon="mdi:land-plots" class="me-2"></iconify-icon>
                    Plot Details
                </div>
                <div class="plot-number">{{ $booking->plot->plot_no }}</div>
            </div>
            <div class="card-body">
                <div class="plot-title-section mb-20">
                    <h4 class="plot-title">{{ $booking->plot->title }}</h4>
                    @if($booking->plot->description)
                        <p class="plot-description text-secondary-light">{{ Str::limit($booking->plot->description, 150) }}</p>
                    @endif
                </div>
                
                <div class="row g-3">
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:resize" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Size</span>
                            <span class="plot-info-value">{{ $booking->plot->size_katha }} Katha</span>
                        </div>
                    </div>
                    @if($booking->plot->block)
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:grid" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Block</span>
                            <span class="plot-info-value">{{ $booking->plot->block }}</span>
                        </div>
                    </div>
                    @endif
                    @if($booking->plot->road_no)
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:road" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Road No</span>
                            <span class="plot-info-value">{{ $booking->plot->road_no }}</span>
                        </div>
                    </div>
                    @endif
                    @if($booking->plot->facing)
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:compass" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Facing</span>
                            <span class="plot-info-value">{{ $booking->plot->facing }}</span>
                        </div>
                    </div>
                    @endif
                    @if($booking->plot->plot_category)
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:tag" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Category</span>
                            <span class="plot-info-value">{{ $booking->plot->plot_category }}</span>
                        </div>
                    </div>
                    @endif
                    @if($booking->plot->road_width)
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:arrow-expand-horizontal" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Road Width</span>
                            <span class="plot-info-value">{{ $booking->plot->road_width }}</span>
                        </div>
                    </div>
                    @endif
                    @if($booking->plot->agent_name)
                    <div class="col-sm-6 col-md-3">
                        <div class="plot-info-box">
                            <iconify-icon icon="mdi:account-tie" class="plot-info-icon"></iconify-icon>
                            <span class="plot-info-label">Agent</span>
                            <span class="plot-info-value">{{ $booking->plot->agent_name }}</span>
                        </div>
                    </div>
                    @endif
                </div>

                @if($booking->plot->plot_map)
                <div class="plot-map-preview mt-20">
                    <a href="{{ asset('storage/' . $booking->plot->plot_map) }}" target="_blank" class="plot-map-link">
                        <img src="{{ asset('storage/' . $booking->plot->plot_map) }}" alt="Plot Map" class="plot-map-image">
                        <div class="plot-map-overlay">
                            <iconify-icon icon="mdi:magnify-plus" class="text-2xl"></iconify-icon>
                            <span>View Full Map</span>
                        </div>
                    </a>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment Details Card -->
        <div class="card payment-details-card mb-24">
            <div class="card-header py-16 px-24 bg-base d-flex justify-content-between align-items-center">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:currency-bdt" class="text-primary-600"></iconify-icon>
                    Payment Summary
                </h6>
                @if($booking->status == 'approved')
                <a href="{{ route('admin.payments.create', ['booking_id' => $booking->id]) }}" class="btn btn-sm btn-success-600 d-inline-flex align-items-center">
                    <iconify-icon icon="mdi:plus" class="me-1 d-flex"></iconify-icon> Add Payment
                </a>
                @endif
            </div>
            <div class="card-body">
                @php
                    $totalPaid = $booking->payments->sum('amount');
                    $totalDue = $booking->price - $totalPaid;
                    $bookingPaymentsPaid = $booking->payments->where('payment_type', 'Booking Payment')->sum('amount');
                    $installmentsPaid = (int) $booking->payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sum('instalment_quantity');
                    $remainingBookingMoney = $booking->booking_payment - $bookingPaymentsPaid;
                    
                    // Calculate next installment date
                    $nextInstallmentDate = null;
                    if ($booking->installment_plan && $booking->total_installments > $installmentsPaid) {
                        $lastPayment = $booking->payments->where('payment_type', 'Installment Payment')->sortByDesc('created_at')->first();
                        $baseDate = $lastPayment ? $lastPayment->created_at : $booking->created_at;
                        
                        switch($booking->installment_plan) {
                            case 'monthly':
                                $nextInstallmentDate = $baseDate->copy()->addMonth();
                                break;
                            case 'quarterly':
                                $nextInstallmentDate = $baseDate->copy()->addMonths(3);
                                break;
                            case 'half-yearly':
                                $nextInstallmentDate = $baseDate->copy()->addMonths(6);
                                break;
                            case 'yearly':
                                $nextInstallmentDate = $baseDate->copy()->addYear();
                                break;
                        }
                    }
                @endphp
                
                <div class="row g-4">
                    <!-- Plot Booking Money Info -->
                    <div class="col-md-6">
                        <div class="payment-summary-list">
                            <div class="payment-item">
                                <span class="payment-label">Plot Total Price</span>
                                <span class="payment-value total-price">৳{{ format_bd_number($booking->price, 2) }}</span>
                            </div>
                            <div class="payment-item">
                                <span class="payment-label">Plot Booking Money (Original)</span>
                                <span class="payment-value text-info-600">৳{{ format_bd_number($booking->booking_payment, 2) }}</span>
                            </div>
                            <div class="payment-item">
                                <span class="payment-label">Paid Booking Money</span>
                                <span class="payment-value text-success-600">৳{{ format_bd_number($bookingPaymentsPaid, 2) }}</span>
                            </div>
                            <div class="payment-item {{ $remainingBookingMoney > 0 ? 'danger-item' : 'success-item' }}">
                                <span class="payment-label">Remaining Booking Money</span>
                                <span class="payment-value {{ $remainingBookingMoney > 0 ? 'text-danger-600' : 'text-success-600' }}">৳{{ format_bd_number(max($remainingBookingMoney, 0), 2) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Actual Payment Status -->
                    <div class="col-md-6">
                        <div class="payment-summary-list">
                            <div class="payment-item success-item">
                                <span class="payment-label">Total Paid</span>
                                <span class="payment-value text-success-600">৳{{ format_bd_number($totalPaid, 2) }}</span>
                            </div>
                            <div class="payment-item {{ $totalDue > 0 ? 'danger-item' : 'success-item' }}">
                                <span class="payment-label">Total Due</span>
                                <span class="payment-value {{ $totalDue > 0 ? 'text-danger-600' : 'text-success-600' }}">৳{{ format_bd_number(max($totalDue, 0), 2) }}</span>
                            </div>
                            @if($booking->installment_plan)
                            <div class="payment-item">
                                <span class="payment-label">Installment Paid</span>
                                <span class="payment-value text-primary-600">{{ $installmentsPaid }} / {{ $booking->total_installments }}</span>
                            </div>
                            @endif
                            <div class="payment-item">
                                <span class="payment-label">Payments Made</span>
                                <span class="payment-value text-primary-600">{{ $booking->payments->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Installment Plan Section -->
                @if($booking->installment_plan)
                <div class="installment-section mt-24">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <div class="installment-box">
                                <h6 class="installment-title">
                                    <iconify-icon icon="mdi:calendar-month" class="me-2 d-flex"></iconify-icon>
                                    Installment Plan
                                </h6>
                                <div class="installment-details">
                                    <div class="installment-item">
                                        <span class="inst-label">Plan Type</span>
                                        <span class="inst-value">{{ ucfirst($booking->installment_plan) }}</span>
                                    </div>
                                    <div class="installment-item">
                                        <span class="inst-label">Total Installments</span>
                                        <span class="inst-value">{{ $booking->total_installments }}</span>
                                    </div>
                                    <div class="installment-item">
                                        <span class="inst-label">Per Installment</span>
                                        <span class="inst-value">৳{{ format_bd_number($booking->installment_payment, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="installment-progress-box">
                                <h6 class="installment-title">
                                    <iconify-icon icon="mdi:chart-timeline-variant" class="me-2 d-flex"></iconify-icon>
                                    Installment Progress
                                </h6>
                                <div class="installment-details">
                                    <div class="installment-item">
                                        <span class="inst-label">Paid Installments</span>
                                        <span class="inst-value">
                                            <span class="badge bg-success-600">{{ $installmentsPaid }}</span> / {{ $booking->total_installments }}
                                        </span>
                                    </div>
                                    <div class="installment-item">
                                        <span class="inst-label">Remaining Installments</span>
                                        <span class="inst-value">
                                            <span class="badge bg-warning-600">{{ $booking->total_installments - $installmentsPaid }}</span>
                                        </span>
                                    </div>
                                    <div class="installment-item">
                                        <span class="inst-label">Next Installment Date</span>
                                        <span class="inst-value {{ $nextInstallmentDate && $nextInstallmentDate->isPast() ? 'text-danger-600 fw-bold' : '' }}">
                                            @if($nextInstallmentDate)
                                                @if($nextInstallmentDate->isPast())
                                                    <iconify-icon icon="mdi:alert" class="me-1"></iconify-icon>
                                                @endif
                                                {{ $nextInstallmentDate->format('d M, Y') }}
                                            @else
                                                <span class="text-success-600">All Paid</span>
                                            @endif
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @else
                <div class="no-installment-section mt-24">
                    <div class="no-installment-box">
                        <iconify-icon icon="mdi:cash-multiple" class="no-inst-icon"></iconify-icon>
                        <span>Full Payment Mode</span>
                        <small class="text-secondary-light">No installment plan selected</small>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Payment History Card -->
        <div class="card payment-history-card mb-24">
            <div class="card-header py-16 px-24 bg-base">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:history" class="text-primary-600"></iconify-icon>
                    All Payments for this Booking
                </h6>
            </div>
            <div class="card-body p-0">
                @if($booking->payments->count() > 0)
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-24 py-12">ID</th>
                                <th class="px-24 py-12">Type</th>
                                <th class="px-24 py-12">Amount</th>
                                <th class="px-24 py-12">Date</th>
                                <th class="px-24 py-12 text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->payments as $p)
                            <tr>
                                <td class="px-24 py-12">
                                    <span class="fw-medium">#{{ str_pad($p->id, 5, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-24 py-12">
                                    @if($p->payment_type == 'Booking Payment')
                                        <span class="badge bg-info-focus text-info-600">{{ $p->payment_type }}</span>
                                    @elseif($p->payment_type == 'Down Payment')
                                        <span class="badge bg-success-focus text-success-600">{{ $p->payment_type }}</span>
                                    @elseif($p->payment_type == 'Installment Payment')
                                        <span class="badge bg-warning-focus text-warning-600">{{ $p->payment_type }}</span>
                                    @else
                                        <span class="badge bg-neutral-100 text-neutral-600">{{ $p->payment_type }}</span>
                                    @endif
                                </td>
                                <td class="px-24 py-12">
                                    <span class="fw-semibold text-success-600">৳{{ format_bd_number($p->amount, 2) }}</span>
                                </td>
                                <td class="px-24 py-12 text-secondary-light">{{ $p->created_at->format('d M, Y h:i A') }}</td>
                                <td class="px-24 py-12 text-center">
                                    <a href="{{ route('admin.payments.show', $p->id) }}" class="btn btn-sm btn-primary-light d-inline-flex align-items-center">
                                        <iconify-icon icon="mdi:eye" class="me-1 d-flex"></iconify-icon> View
                                    </a>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-neutral-50">
                            <tr>
                                <td colspan="2" class="px-24 py-12 fw-semibold">Total</td>
                                <td class="px-24 py-12">
                                    <span class="fw-bold text-success-600">৳{{ format_bd_number($booking->payments->sum('amount'), 2) }}</span>
                                </td>
                                <td colspan="2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
                @else
                <div class="text-center py-32">
                    <iconify-icon icon="mdi:cash-remove" class="text-neutral-400" style="font-size: 48px;"></iconify-icon>
                    <p class="text-neutral-600 mt-12 mb-0">No payments recorded yet</p>
                </div>
                @endif
            </div>
        </div>

        @if($booking->isHierarchyScheme() && $booking->commissionEarnings->count() > 0)
        <!-- Commission Distribution Card -->
        <div class="card payment-history-card mb-24">
            <div class="card-header py-16 px-24 bg-base">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:account-cash" class="text-primary-600"></iconify-icon>
                    Commission Distribution (per beneficiary)
                </h6>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="bg-neutral-50">
                            <tr>
                                <th class="px-24 py-12">Beneficiary</th>
                                <th class="px-24 py-12">Type</th>
                                <th class="px-24 py-12">Booking Pool</th>
                                <th class="px-24 py-12">Down Pool</th>
                                <th class="px-24 py-12">Instalment Pool</th>
                                <th class="px-24 py-12">Total</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($booking->commissionEarnings->groupBy('user_id') as $rows)
                            @php $first = $rows->first(); @endphp
                            <tr>
                                <td class="px-24 py-12 fw-medium">{{ $first->beneficiary->name ?? 'N/A' }}</td>
                                <td class="px-24 py-12"><span class="badge bg-primary-50 text-primary-600">{{ config('commission.types.' . $first->beneficiary_type . '.label', $first->beneficiary_type) }}</span></td>
                                <td class="px-24 py-12">৳{{ format_bd_number($rows->where('pool_type', 'booking')->sum('amount'), 2) }}</td>
                                <td class="px-24 py-12">৳{{ format_bd_number($rows->where('pool_type', 'down')->sum('amount'), 2) }}</td>
                                <td class="px-24 py-12">৳{{ format_bd_number($rows->where('pool_type', 'instalment')->sum('amount'), 2) }}</td>
                                <td class="px-24 py-12 fw-semibold text-success-600">৳{{ format_bd_number($rows->sum('amount'), 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot class="bg-neutral-50">
                            <tr>
                                <td colspan="5" class="px-24 py-12 fw-semibold">Total Distributed</td>
                                <td class="px-24 py-12 fw-bold text-success-600">৳{{ format_bd_number($booking->commissionEarnings->sum('amount'), 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        @endif
    </div>
</div>

<!-- Back Button -->
<div class="mt-24">
    <a href="{{ route('admin.bookings.index') }}" class="btn btn-outline-secondary px-24 py-12 radius-8 d-inline-flex align-items-center">
        <iconify-icon icon="mdi:arrow-left" class="me-2 d-flex"></iconify-icon> Back to Bookings
    </a>
</div>

<!-- Edit Booking Modal -->
<div class="modal fade" id="editBookingModal" tabindex="-1" aria-labelledby="editBookingModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-primary-600 py-16">
                <h5 class="modal-title text-white" id="editBookingModalLabel">
                    <iconify-icon icon="mdi:pencil" class="me-2"></iconify-icon>
                    Update Booking
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.update-quick', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:flag" class="me-1"></iconify-icon>
                            Booking Status <span class="text-danger-600">*</span>
                        </label>
                        <select class="form-control radius-8 form-select" name="status" required>
                            <option value="pending" {{ $booking->status == 'pending' ? 'selected' : '' }}>
                                🕐 Pending
                            </option>
                            <option value="pre-booked" {{ $booking->status == 'pre-booked' ? 'selected' : '' }}>
                                📋 Pre-Booked
                            </option>
                            <option value="approved" {{ $booking->status == 'approved' ? 'selected' : '' }}>
                                ✅ Approved
                            </option>
                            <option value="cancelled" {{ $booking->status == 'cancelled' ? 'selected' : '' }}>
                                ❌ Cancelled
                            </option>
                        </select>
                        <small class="text-secondary-light d-block mt-8">
                            <iconify-icon icon="mdi:information-outline" class="me-1"></iconify-icon>
                            Approving will mark the plot as "Booked"
                        </small>
                    </div>

                    <div class="mb-0">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:note-text" class="me-1"></iconify-icon>
                            Additional Information
                        </label>
                        <textarea class="form-control radius-8" name="additional_info" rows="4" placeholder="Enter any additional notes...">{{ $booking->additional_info }}</textarea>
                    </div>
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-outline-secondary px-20 py-10 radius-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-20 py-10 radius-8 d-inline-flex align-items-center">
                        <iconify-icon icon="mdi:check" class="me-1 d-flex"></iconify-icon> Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Booking ID Modal -->
<div class="modal fade" id="editBookingIdModal" tabindex="-1" aria-labelledby="editBookingIdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-warning-600 py-16">
                <h5 class="modal-title text-white" id="editBookingIdModalLabel">
                    <iconify-icon icon="mdi:pencil" class="me-2"></iconify-icon>
                    Change Booking ID
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.update-id', $booking->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to change this Booking ID? This will update related payments, commission payouts and commission earnings as well.');">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="alert alert-warning radius-8 mb-20">
                        <iconify-icon icon="mdi:alert" class="me-1"></iconify-icon>
                        Changing the Booking ID will also update all linked records in <strong>payments</strong>, <strong>commission_payouts</strong> and <strong>commission_earnings</strong> tables. This action cannot be undone automatically.
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:pound" class="me-1"></iconify-icon>
                            Current Booking ID
                        </label>
                        <input type="text" class="form-control radius-8" value="#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }}" readonly disabled>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:pound" class="me-1"></iconify-icon>
                            New Booking ID <span class="text-danger-600">*</span>
                        </label>
                        <input type="number" class="form-control radius-8" name="new_id" min="1" step="1" placeholder="Enter the new Booking ID" required>
                        <small class="text-secondary-light d-block mt-8">
                            <iconify-icon icon="mdi:information-outline" class="me-1"></iconify-icon>
                            The new ID must be a positive integer that is not already in use by another booking.
                        </small>
                    </div>
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-outline-secondary px-20 py-10 radius-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning px-20 py-10 radius-8 d-inline-flex align-items-center">
                        <iconify-icon icon="mdi:check" class="me-1 d-flex"></iconify-icon> Change ID
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Booking Date Modal -->
<div class="modal fade" id="editBookingDateModal" tabindex="-1" aria-labelledby="editBookingDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-info-600 py-16">
                <h5 class="modal-title text-white" id="editBookingDateModalLabel">
                    <iconify-icon icon="mdi:calendar-edit" class="me-2"></iconify-icon>
                    Edit Booking Date & Time
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.update-booking-date', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:calendar" class="me-1"></iconify-icon>
                            Booking Date <span class="text-danger-600">*</span>
                        </label>
                        <input type="date" class="form-control radius-8" name="booking_date"
                            value="{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d') : $booking->created_at->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:clock" class="me-1"></iconify-icon>
                            Booking Time <span class="text-danger-600">*</span>
                        </label>
                        <input type="time" class="form-control radius-8" name="booking_time"
                            value="{{ $booking->booking_date ? $booking->booking_date->format('H:i') : $booking->created_at->format('H:i') }}" required>
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

<!-- Edit Booking Date Modal -->
<div class="modal fade" id="editBookingDateModal" tabindex="-1" aria-labelledby="editBookingDateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-info-600 py-16">
                <h5 class="modal-title text-white" id="editBookingDateModalLabel">
                    <iconify-icon icon="mdi:calendar-edit" class="me-2"></iconify-icon>
                    Edit Booking Date & Time
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.update-booking-date', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:calendar" class="me-1"></iconify-icon>
                            Booking Date <span class="text-danger-600">*</span>
                        </label>
                        <input type="date" class="form-control radius-8" name="booking_date"
                            value="{{ $booking->booking_date ? $booking->booking_date->format('Y-m-d') : $booking->created_at->format('Y-m-d') }}" required>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:clock" class="me-1"></iconify-icon>
                            Booking Time <span class="text-danger-600">*</span>
                        </label>
                        <input type="time" class="form-control radius-8" name="booking_time"
                            value="{{ $booking->booking_date ? $booking->booking_date->format('H:i') : $booking->created_at->format('H:i') }}" required>
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

<!-- Edit Owners Modal -->
<div class="modal fade" id="editOwnersModal" tabindex="-1" aria-labelledby="editOwnersModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-primary-600 py-16">
                <h5 class="modal-title text-white" id="editOwnersModalLabel">
                    <iconify-icon icon="mdi:account-group" class="me-2"></iconify-icon>
                    Edit Additional Owners
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.update-owners', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="alert alert-info-600 bg-info-50 border-info-200 mb-20">
                        <div class="d-flex align-items-start gap-8">
                            <iconify-icon icon="mdi:information" class="text-info-600 flex-shrink-0" style="font-size: 20px; margin-top: 2px;"></iconify-icon>
                            <div class="text-sm">
                                Add multiple owners for this booking. You can add or remove owners as needed.
                            </div>
                        </div>
                    </div>

                    <div id="ownersContainer">
                        @if($booking->owners && count($booking->owners) > 0)
                            @foreach($booking->owners as $index => $owner)
                            <div class="owner-form-group mb-20 pb-20 border-bottom" data-owner-index="{{ $index }}">
                                <div class="d-flex justify-content-between align-items-center mb-12">
                                    <h6 class="mb-0 text-primary-600">
                                        <iconify-icon icon="mdi:account" class="me-1"></iconify-icon>
                                        Owner #<span class="owner-number">{{ $index + 1 }}</span>
                                    </h6>
                                    <button type="button" class="btn btn-sm btn-danger-600 remove-owner-btn" onclick="removeOwner(this)">
                                        <iconify-icon icon="mdi:delete" class="me-1"></iconify-icon> Remove
                                    </button>
                                </div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Name <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][name]" value="{{ $owner['name'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Phone <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][phone]" value="{{ $owner['phone'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            NID <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][nid]" value="{{ $owner['nid'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Address <span class="text-danger-600">*</span>
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][address]" value="{{ $owner['address'] ?? '' }}" required>
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Father's Name
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][father_name]" value="{{ $owner['father_name'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Mother's Name
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][mother_name]" value="{{ $owner['mother_name'] ?? '' }}">
                                    </div>
                                    <div class="col-md-4">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Spouse's Name
                                        </label>
                                        <input type="text" class="form-control radius-8" name="owners[{{ $index }}][spouse_name]" value="{{ $owner['spouse_name'] ?? '' }}">
                                    </div>
                                    <div class="col-md-12">
                                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Nominee Info
                                        </label>
                                        <textarea class="form-control radius-8" rows="3" name="owners[{{ $index }}][nominee_info]" placeholder="Nominee name, relation, NID, phone, address, etc.">{{ $owner['nominee_info'] ?? '' }}</textarea>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        @endif
                    </div>

                    <button type="button" class="btn btn-outline-primary w-100 d-inline-flex align-items-center justify-content-center gap-2" onclick="addOwner()">
                        <iconify-icon icon="mdi:plus-circle" style="font-size: 20px;"></iconify-icon>
                        Add Another Owner
                    </button>
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-outline-secondary px-20 py-10 radius-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary px-20 py-10 radius-8 d-inline-flex align-items-center">
                        <iconify-icon icon="mdi:check" class="me-1 d-flex"></iconify-icon> Save Owners
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Change Agent Modal -->
<div class="modal fade" id="changeAgentModal" tabindex="-1" aria-labelledby="changeAgentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-warning-600 py-16">
                <h5 class="modal-title text-white" id="changeAgentModalLabel">
                    <iconify-icon icon="mdi:account-switch" class="me-2"></iconify-icon>
                    Change Seller
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.bookings.change-agent', $booking->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    @if($booking->agent)
                    <div class="alert alert-info-600 bg-info-50 border-info-200 mb-20">
                        <div class="d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:information" class="text-info-600" style="font-size: 20px;"></iconify-icon>
                            <div>
                                <strong>Current Seller:</strong> {{ $booking->agent->name }}
                                @if($booking->agent->referral_code)
                                    ({{ $booking->agent->referral_code }})
                                @endif
                            </div>
                        </div>
                    </div>
                    @endif

                    <div class="alert alert-warning-600 bg-warning-50 border-warning-200 mb-20">
                        <div class="d-flex align-items-start gap-8">
                            <iconify-icon icon="mdi:alert" class="text-warning-600 flex-shrink-0" style="font-size: 20px; margin-top: 2px;"></iconify-icon>
                            <div class="text-sm">
                                @if($booking->isHierarchyScheme())
                                <strong>Important:</strong> Commission already distributed on past payments stays with the previous seller's chain. Payments recorded <strong>after</strong> this change will be distributed to the new seller's chain.
                                @else
                                <strong>Important:</strong> The new agent's commission will be calculated only on payments received <strong>after</strong> this change. Previous payments will not count towards the new agent's commission.
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:account-tie" class="me-1"></iconify-icon>
                            Select New Seller
                        </label>
                        <select class="form-control radius-8 form-select" name="referral_agent_id" id="changeAgentSelect">
                            <option value="" data-commission-rate="0">-- No Seller (Remove) --</option>
                            @foreach($agents as $agent)
                                <option value="{{ $agent->id }}" data-commission-rate="{{ $agent->commission_rate ?? 0 }}" {{ $booking->referral_agent_id == $agent->id ? 'selected' : '' }}>
                                    {{ $agent->name }} — {{ $agent->commissionTypeLabel() }} ({{ $agent->referral_code ?? 'No Code' }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    @if($booking->isFlatScheme())
                    <div class="mb-0" id="changeAgentCommissionSection" style="{{ $booking->referral_agent_id ? '' : 'display:none' }}">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            <iconify-icon icon="mdi:percent" class="me-1"></iconify-icon>
                            Agent Commission Rate (%)
                        </label>
                        <input type="number" step="0.01" min="0" max="100" class="form-control radius-8" name="agent_commission" id="changeAgentCommission" value="{{ $booking->agent_commission ?? ($booking->agent->commission_rate ?? '') }}" placeholder="0.00">
                        <small class="text-secondary-light">Commission rate for this booking (legacy flat scheme)</small>
                    </div>
                    @endif
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-outline-secondary px-20 py-10 radius-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-warning-600 px-20 py-10 radius-8 d-inline-flex align-items-center text-white">
                        <iconify-icon icon="mdi:check" class="me-1 d-flex"></iconify-icon> Change Seller
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('styles')
<style>
/* Owner Detail Card */
.owner-detail-card {
    background: linear-gradient(135deg, #fafbfc 0%, #f1f5f9 100%);
    border-color: #e2e8f0 !important;
    transition: all 0.2s;
}
.owner-detail-card:hover {
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    border-color: var(--primary-300) !important;
}
.owner-avatar {
    width: 40px;
    height: 40px;
    border-radius: 10px;
    background: linear-gradient(135deg, var(--primary-600), var(--primary-400));
    color: white;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 16px;
    flex-shrink: 0;
}
.owner-info-grid {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.owner-info-row {
    display: flex;
    align-items: flex-start;
    gap: 8px;
}
.owner-info-row iconify-icon {
    flex-shrink: 0;
    margin-top: 2px;
}

/* Booking Overview Card */
.booking-overview-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.booking-status-header {
    padding: 20px 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    position: relative;
}

.booking-status-header.status-pending {
    background: #fef3c7;
    border-left: 4px solid #f59e0b;
}

.booking-status-header.status-approved {
    background: #dcfce7;
    border-left: 4px solid #22c55e;
}

.booking-status-header.status-cancelled {
    background: #fee2e2;
    border-left: 4px solid #ef4444;
}

.booking-status-header.status-pre-booked {
    background: #dbeafe;
    border-left: 4px solid #3b82f6;
}

.status-icon-wrapper {
    width: 48px;
    height: 48px;
    background: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.status-icon {
    font-size: 28px;
}

.status-pending .status-icon {
    color: #f59e0b;
}

.status-approved .status-icon {
    color: #22c55e;
}

.status-cancelled .status-icon {
    color: #ef4444;
}

.status-pre-booked .status-icon {
    color: #3b82f6;
}

.status-info {
    flex: 1;
}

.status-label {
    display: block;
    font-size: 12px;
    color: #6b7280;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-value {
    font-size: 20px;
    font-weight: 700;
    color: #1f2937;
}

.edit-status-btn {
    position: absolute;
    top: 16px;
    right: 16px;
    font-size: 12px;
    padding: 4px 12px;
}

.booking-meta {
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
    color: var(--secondary-light);
}

.meta-value {
    font-weight: 600;
    color: #1f2937;
}

.meta-sub {
    display: block;
    font-size: 11px;
    color: var(--secondary-light);
}

/* Customer Card */
.customer-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.customer-card-header {
    background: #f9fafb;
    border-bottom: 1px solid var(--neutral-200);
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
    width: 80px;
    height: 80px;
    border-radius: 50%;
    border: 4px solid var(--neutral-200);
    object-fit: cover;
}

.customer-avatar-placeholder {
    background: var(--primary-100);
    color: var(--primary-600);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 32px;
    font-weight: 700;
}

.online-indicator {
    position: absolute;
    bottom: 4px;
    right: 4px;
    width: 16px;
    height: 16px;
    background: #22c55e;
    border: 3px solid white;
    border-radius: 50%;
}

.customer-name {
    color: #1f2937;
    margin-bottom: 4px;
}

.customer-role {
    color: #6b7280;
    font-size: 14px;
}

.section-title {
    font-size: 14px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 16px;
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
    padding: 12px 0;
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
    color: var(--secondary-light);
    text-transform: uppercase;
}

.info-value {
    font-weight: 500;
    color: #1f2937;
    word-break: break-word;
}

/* Plot Details Card */
.plot-details-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.plot-header {
    background: #f9fafb;
    border-bottom: 1px solid var(--neutral-200);
    padding: 20px 24px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.plot-badge {
    background: white;
    padding: 6px 16px;
    border-radius: 20px;
    color: #0284c7;
    font-size: 13px;
    font-weight: 500;
    display: flex;
    align-items: center;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
}

.plot-number {
    font-size: 24px;
    font-weight: 700;
    color: #0c4a6e;
}

.plot-title {
    font-size: 20px;
    font-weight: 600;
    color: #1f2937;
    margin-bottom: 8px;
}

.plot-description {
    font-size: 14px;
    line-height: 1.6;
}

.plot-info-box {
    background: var(--neutral-100);
    border-radius: 12px;
    padding: 16px;
    text-align: center;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 4px;
}

.plot-info-icon {
    font-size: 24px;
    color: var(--primary-600);
}

.plot-info-label {
    font-size: 11px;
    color: var(--secondary-light);
    text-transform: uppercase;
}

.plot-info-value {
    font-weight: 600;
    color: #1f2937;
}

.plot-map-preview {
    position: relative;
    border-radius: 12px;
    overflow: hidden;
    max-height: 200px;
}

.plot-map-link {
    display: block;
    position: relative;
}

.plot-map-image {
    width: 100%;
    height: 200px;
    object-fit: cover;
}

.plot-map-overlay {
    position: absolute;
    inset: 0;
    background: rgba(0, 0, 0, 0.5);
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 8px;
    color: white;
    opacity: 0;
    transition: opacity 0.3s;
}

.plot-map-link:hover .plot-map-overlay {
    opacity: 1;
}

/* Payment Details Card */
.payment-details-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.payment-summary-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.payment-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 12px 16px;
    background: var(--neutral-50);
    border-radius: 8px;
}

.payment-item.highlight {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border: 1px solid #f59e0b;
}

.payment-label {
    color: var(--secondary-light);
    font-size: 14px;
}

.payment-value {
    font-weight: 700;
    font-size: 16px;
}

.payment-value.total-price {
    color: var(--primary-600);
}

.payment-value.remaining {
    color: #b45309;
}

.installment-box {
    background: linear-gradient(135deg, #e0f2fe 0%, #bae6fd 100%);
    border-radius: 12px;
    padding: 20px;
    height: 100%;
}

.installment-title {
    font-size: 14px;
    font-weight: 600;
    color: #0369a1;
    margin-bottom: 16px;
    display: flex;
    align-items: center;
}

.installment-details {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.installment-item {
    display: flex;
    justify-content: space-between;
}

.inst-label {
    color: #0284c7;
    font-size: 13px;
}

.inst-value {
    font-weight: 600;
    color: #0c4a6e;
}

.no-installment-box {
    background: var(--neutral-100);
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    height: 100%;
    justify-content: center;
}

.no-inst-icon {
    font-size: 40px;
    color: var(--neutral-400);
}

/* Payment Section Enhancements */
.payment-section-title {
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    display: flex;
    align-items: center;
}

.payment-item.success-item {
    background: linear-gradient(135deg, #dcfce7 0%, #bbf7d0 100%);
    border: 1px solid #22c55e;
}

.payment-item.danger-item {
    background: linear-gradient(135deg, #fef2f2 0%, #fecaca 100%);
    border: 1px solid #ef4444;
}

.installment-section {
    border-top: 1px solid var(--neutral-200);
    padding-top: 20px;
}

.installment-progress-box {
    background: linear-gradient(135deg, #fef3c7 0%, #fde68a 100%);
    border-radius: 12px;
    padding: 20px;
    height: 100%;
}

.installment-progress-box .installment-title {
    color: #b45309;
}

.installment-progress-box .inst-label {
    color: #d97706;
}

.installment-progress-box .inst-value {
    color: #92400e;
}

.no-installment-section {
    border-top: 1px solid var(--neutral-200);
    padding-top: 20px;
}

/* Payment History Card */
.payment-history-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

/* Additional Info Card */
.additional-info-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
}

.additional-info-text {
    background: var(--neutral-50);
    padding: 16px;
    border-radius: 8px;
    border-left: 4px solid var(--primary-600);
    font-style: italic;
    color: #374151;
    line-height: 1.6;
}

.no-info-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 32px;
    color: var(--neutral-400);
}

.no-info-icon {
    font-size: 40px;
}

/* Modal Enhancements */
.modal-content {
    border: none;
}

.modal-header {
    border-bottom: none;
}

.modal-footer {
    border-top: 1px solid var(--neutral-200);
    background: var(--neutral-50);
}

/* Owner Form Groups */
.owner-form-group {
    background: #f9fafb;
    padding: 16px;
    border-radius: 12px;
}

.owner-form-group:last-child {
    border-bottom: none !important;
}

.remove-owner-btn {
    font-size: 12px;
    padding: 6px 12px;
}

/* Responsive */
@media (max-width: 991px) {
    .booking-status-header {
        flex-wrap: wrap;
    }
    
    .edit-status-btn {
        position: static;
        margin-top: 8px;
    }
}
</style>
@endpush

@push('scripts')
<script>
let ownerIndex = {{ $booking->owners ? count($booking->owners) : 0 }};

function addOwner() {
    const container = document.getElementById('ownersContainer');
    const ownerHtml = `
        <div class="owner-form-group mb-20 pb-20 border-bottom" data-owner-index="${ownerIndex}">
            <div class="d-flex justify-content-between align-items-center mb-12">
                <h6 class="mb-0 text-primary-600">
                    <iconify-icon icon="mdi:account" class="me-1"></iconify-icon>
                    Owner #<span class="owner-number">${ownerIndex + 1}</span>
                </h6>
                <button type="button" class="btn btn-sm btn-danger-600 remove-owner-btn" onclick="removeOwner(this)">
                    <iconify-icon icon="mdi:delete" class="me-1"></iconify-icon> Remove
                </button>
            </div>
            <div class="row g-3">
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Name <span class="text-danger-600">*</span>
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][name]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Phone <span class="text-danger-600">*</span>
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][phone]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        NID <span class="text-danger-600">*</span>
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][nid]" required>
                </div>
                <div class="col-md-6">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Address <span class="text-danger-600">*</span>
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][address]" required>
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Father's Name
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][father_name]">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Mother's Name
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][mother_name]">
                </div>
                <div class="col-md-4">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Spouse's Name
                    </label>
                    <input type="text" class="form-control radius-8" name="owners[${ownerIndex}][spouse_name]">
                </div>
                <div class="col-md-12">
                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                        Nominee Info
                    </label>
                    <textarea class="form-control radius-8" rows="3" name="owners[${ownerIndex}][nominee_info]" placeholder="Nominee name, relation, NID, phone, address, etc."></textarea>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', ownerHtml);
    ownerIndex++;
    updateOwnerNumbers();
}

function removeOwner(button) {
    const ownerGroup = button.closest('.owner-form-group');
    ownerGroup.remove();
    updateOwnerNumbers();
}

function updateOwnerNumbers() {
    const ownerGroups = document.querySelectorAll('.owner-form-group');
    ownerGroups.forEach((group, index) => {
        const numberSpan = group.querySelector('.owner-number');
        if (numberSpan) {
            numberSpan.textContent = index + 1;
        }
    });
}

$(document).ready(function() {
    // Auto-fill agent commission rate when agent is changed in the Change Agent modal
    $('#changeAgentSelect').on('change', function() {
        var selected = $(this).find('option:selected');
        if ($(this).val()) {
            var rate = selected.data('commission-rate') || 0;
            $('#changeAgentCommission').val(rate);
            $('#changeAgentCommissionSection').slideDown();
        } else {
            $('#changeAgentCommission').val('');
            $('#changeAgentCommissionSection').slideUp();
        }
    });
});
</script>
@endpush
@endsection
