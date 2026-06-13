@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Plot Details</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('admin.plots.index') }}" class="hover-text-primary">Plots</a>
        </li>
        <li>-</li>
        <li class="fw-medium">{{ $plot->plot_no }}</li>
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
    <!-- Left Column - Plot Details -->
    <div class="col-lg-8">
        <!-- Main Plot Info Card -->
        <div class="card mb-24">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <div class="d-flex align-items-center justify-content-between">
                    <h6 class="mb-0 d-flex align-items-center gap-2">
                        <iconify-icon icon="mdi:land-plots" class="text-primary-600"></iconify-icon>
                        Plot Information
                    </h6>
                    <span class="badge {{ $plot->status == 'available' ? 'bg-success-600' : ($plot->status == 'pending' ? 'bg-info-600' : ($plot->status == 'booked' ? 'bg-warning-600' : 'bg-danger-600')) }} px-16 py-8 text-white">
                        {{ ucfirst($plot->status) }}
                    </span>
                </div>
            </div>
            <div class="card-body">
                <div class="mb-20">
                    <h5 class="mb-8">{{ $plot->title }}</h5>
                    @if($plot->description)
                        <p class="text-secondary-light mb-0">{{ $plot->description }}</p>
                    @endif
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Plot No</span>
                            <span class="fw-semibold text-primary-600">{{ $plot->plot_no }}</span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Size</span>
                            <span class="fw-semibold">{{ $plot->size_katha }} Katha</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Block</span>
                            <span class="fw-semibold">{{ $plot->block }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Road No</span>
                            <span class="fw-semibold">{{ $plot->road_no }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Facing</span>
                            <span class="fw-semibold">{{ $plot->facing }}</span>
                        </div>
                    </div>
                    @if($plot->plot_category)
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Category</span>
                            <span class="fw-semibold">{{ $plot->plot_category }}</span>
                        </div>
                    </div>
                    @endif
                    @if($plot->road_width)
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Road Width</span>
                            <span class="fw-semibold">{{ $plot->road_width }}</span>
                        </div>
                    </div>
                    @endif
                    @if($plot->agent_name)
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Agent Name</span>
                            <span class="fw-semibold">{{ $plot->agent_name }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Bookings List Card -->
        @if($bookings->count() > 0)
        <div class="card mb-24">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:book-multiple" class="text-primary-600"></iconify-icon>
                    Booking History ({{ $bookings->count() }})
                </h6>
            </div>
            <div class="card-body p-24">
                <div class="table-responsive scroll-sm">
                    <table class="table bordered-table sm-table mb-0">
                        <thead>
                            <tr>
                                <th scope="col">S.L</th>
                                <th scope="col">Customer</th>
                                <th scope="col">Booking Date</th>
                                <th scope="col">Total Price</th>
                                <th scope="col" class="text-center">Status</th>
                                <th scope="col" class="text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bookings as $index => $booking)
                            @php
                                $paidAmount = $booking->payments->sum('amount');
                                $dueAmount = $booking->price - $paidAmount;
                            @endphp
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>
                                    <div class="d-flex align-items-center gap-10">
                                        @if($booking->user->photo)
                                            <img src="{{ $booking->user->profile_image_url }}" alt="{{ $booking->user->name }}" class="w-40-px h-40-px rounded-circle object-fit-cover">
                                        @else
                                            <span class="w-40-px h-40-px rounded-circle bg-primary-100 text-primary-600 d-flex justify-content-center align-items-center fw-semibold">
                                                {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                            </span>
                                        @endif
                                        <div>
                                            <span class="text-xs text-primary-600 fw-semibold">CID-{{ str_pad($booking->user->client_id, 5, '0', STR_PAD_LEFT) }}</span>
                                            <span class="fw-medium d-block">{{ $booking->user->name }}</span>
                                            <small class="d-block text-secondary-light">{{ $booking->user->phone }}</small>
                                        </div>
                                    </div>
                                </td>
                                <td>{{ $booking->created_at->format('d M, Y') }}</td>
                                <td><span class="text-md mb-0 fw-normal text-secondary-light">৳{{ format_bd_number($booking->price, 2) }}</span></td>
                                <td class="text-center">
                                    @if($booking->status == 'approved')
                                        <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Approved</span>
                                    @elseif($booking->status == 'pending')
                                        <span class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
                                    @else
                                        <span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">{{ ucfirst($booking->status) }}</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <div class="d-flex align-items-center gap-10 justify-content-center">
                                        <a href="{{ route('admin.users.show', $booking->user->id) }}" class="bg-cyan-focus text-cyan-600 bg-hover-cyan-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Customer">
                                            <iconify-icon icon="mdi:account" class="menu-icon"></iconify-icon>
                                        </a>
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Booking">
                                            <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        @endif

        <!-- Pricing Details Card -->
        <div class="card mb-24">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:currency-bdt" class="text-primary-600"></iconify-icon>
                    Pricing & Payment Details
                </h6>
            </div>
            <div class="card-body">
                <div class="row g-3">
                    <div class="col-md-4">
                        <div class="p-16 bg-success-50 radius-8 border border-success-200">
                            <span class="text-secondary-light text-sm d-block mb-4">Total Price</span>
                            <span class="fw-bold text-success-600 text-xl">৳{{ format_bd_number($plot->price, 2) }}</span>
                        </div>
                    </div>
                    @if($plot->booking_payment)
                    <div class="col-md-4">
                        <div class="p-16 bg-warning-50 radius-8 border border-warning-200">
                            <span class="text-secondary-light text-sm d-block mb-4">Booking Payment</span>
                            <span class="fw-bold text-warning-600 text-xl">৳{{ format_bd_number($plot->booking_payment, 2) }}</span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-16 bg-primary-50 radius-8 border border-primary-200">
                            <span class="text-secondary-light text-sm d-block mb-4">Remaining Payment</span>
                            <span class="fw-bold text-primary-600 text-xl">৳{{ format_bd_number($plot->price - $plot->booking_payment, 2) }}</span>
                        </div>
                    </div>
                    @endif
                    @if($plot->installment_plan)
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Installment Plan</span>
                            <span class="fw-semibold">{{ ucfirst($plot->installment_plan) }}</span>
                        </div>
                    </div>
                    @endif
                    @if($plot->total_installments)
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Total Installments</span>
                            <span class="fw-semibold">{{ $plot->total_installments }}</span>
                        </div>
                    </div>
                    @endif
                    @if($plot->installment_payment)
                    <div class="col-md-4">
                        <div class="p-16 bg-neutral-50 radius-8">
                            <span class="text-secondary-light text-sm d-block mb-4">Installment Payment</span>
                            <span class="fw-semibold">৳{{ format_bd_number($plot->installment_payment, 2) }}</span>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Additional Info Card -->
        @if($plot->nearby_facilities || $plot->google_maps_location)
        <div class="card mb-24">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:information" class="text-primary-600"></iconify-icon>
                    Additional Information
                </h6>
            </div>
            <div class="card-body">
                @if($plot->nearby_facilities)
                <div class="mb-20">
                    <h6 class="text-md mb-8">Nearby Facilities</h6>
                    <p class="text-secondary-light mb-0">{{ $plot->nearby_facilities }}</p>
                </div>
                @endif
                
                @if($plot->google_maps_location)
                <div>
                    <h6 class="text-md mb-8">Google Maps Location</h6>
                    <a href="{{ $plot->google_maps_location }}" target="_blank" class="btn btn-sm btn-outline-primary">
                        <iconify-icon icon="mdi:map-marker" class="me-1"></iconify-icon>
                        View on Google Maps
                    </a>
                </div>
                @endif
            </div>
        </div>
        @endif
    </div>

    <!-- Right Column - Actions & Media -->
    <div class="col-lg-4">
        <!-- Action Buttons Card -->
        <div class="card mb-24">
            <div class="card-body">
                <div class="d-flex flex-column gap-12">
                    @if($plot->status === 'available')
                    <a href="{{ route('admin.plots.edit', $plot->id) }}" class="btn btn-primary w-100">
                        <iconify-icon icon="lucide:edit" class="me-2"></iconify-icon>
                        Edit Plot
                    </a>
                    @else
                    <div class="alert alert-warning mb-0 py-8 px-12 text-sm">
                        <iconify-icon icon="mdi:lock" class="me-1"></iconify-icon>
                        Plot cannot be edited while status is "{{ ucfirst($plot->status) }}". Remove all bookings first.
                    </div>
                    @endif

                    @if($bookings->count() === 0)
                    <form action="{{ route('admin.plots.update-status', $plot->id) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Change Status</label>
                        <div class="d-flex gap-8">
                            <select name="status" class="form-control radius-8 form-select" required>
                                <option value="available" {{ $plot->status === 'available' ? 'selected' : '' }}>Available</option>
                                <option value="pending" {{ $plot->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="booked" {{ $plot->status === 'booked' ? 'selected' : '' }}>Booked</option>
                                <option value="sold" {{ $plot->status === 'sold' ? 'selected' : '' }}>Sold</option>
                            </select>
                            <button type="submit" class="btn btn-outline-primary px-16">
                                <iconify-icon icon="mdi:check" class="d-flex"></iconify-icon>
                            </button>
                        </div>
                    </form>
                    @endif
                    <a href="{{ route('admin.plots.index') }}" class="btn btn-outline-secondary w-100">
                        <iconify-icon icon="mdi:arrow-left" class="me-2"></iconify-icon>
                        Back to List
                    </a>
                    @if($plot->status === 'available')
                    <form action="{{ route('admin.plots.destroy', $plot->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this plot?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger w-100">
                            <iconify-icon icon="fluent:delete-24-regular" class="me-2"></iconify-icon>
                            Delete Plot
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>

        <!-- Plot Map/Image Card -->
        @if($plot->plot_map)
        <div class="card mb-24">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0">Plot Map/Layout</h6>
            </div>
            <div class="card-body">
                @if(Str::endsWith($plot->plot_map, '.pdf'))
                    <a href="{{ asset($plot->plot_map) }}" target="_blank" class="btn btn-outline-primary w-100">
                        <iconify-icon icon="mdi:file-pdf-box" class="me-2"></iconify-icon>
                        View PDF
                    </a>
                @else
                    <img src="{{ asset($plot->plot_map) }}" alt="Plot Map" class="w-100 radius-8">
                    <a href="{{ asset($plot->plot_map) }}" target="_blank" class="btn btn-sm btn-outline-primary w-100 mt-12">
                        <iconify-icon icon="mdi:magnify-plus" class="me-1"></iconify-icon>
                        View Full Size
                    </a>
                @endif
            </div>
        </div>
        @endif

        <!-- Meta Info Card -->
        <div class="card">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0">Meta Information</h6>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-12 pb-12 border-bottom">
                        <span class="text-secondary-light text-sm d-block mb-4">Created At</span>
                        <span class="fw-medium">{{ $plot->created_at->format('M d, Y h:i A') }}</span>
                    </li>
                    <li class="mb-0">
                        <span class="text-secondary-light text-sm d-block mb-4">Last Updated</span>
                        <span class="fw-medium">{{ $plot->updated_at->format('M d, Y h:i A') }}</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
