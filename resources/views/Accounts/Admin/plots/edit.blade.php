@extends('Accounts.app')

@section('content')
    <div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
        <div class="d-flex align-items-center gap-3">
            <h6 class="fw-semibold mb-0">{{ isset($plot) ? 'Edit Plot' : 'Add New Plot' }}</h6>
            @if(isset($plot))
                <a href="{{ route('plot.details', $plot->id) }}" target="_blank" class="btn btn-sm btn-outline-success radius-8 px-20 py-11 d-flex align-items-center gap-2">
                    <iconify-icon icon="solar:eye-outline" class="text-xl"></iconify-icon>
                    View Plot
                </a>
            @endif
        </div>
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
            <li class="fw-medium">{{ isset($plot) ? 'Edit' : 'Add New' }}</li>
        </ul>
    </div>


    <form action="{{ isset($plot) ? route('admin.plots.update', $plot->id) : route('admin.plots.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @if(isset($plot))
            @method('PUT')
        @endif

        @if ($errors->any())
            <div class="alert alert-danger mb-20">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">
            <div class="col-lg-8">
                <div class="card border mb-24">
                    <div class="card-body">
                        
                        <div class="mb-20">
                            <label for="title" class="form-label fw-semibold text-primary-light text-sm mb-8">Plot Title <span class="text-danger-600">*</span></label>
                            <input type="text" class="form-control radius-8 @error('title') is-invalid @enderror" id="title" name="title" placeholder="e.g., Premium Residential Plot" value="{{ old('title', $plot->title ?? '') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-20">
                            <label for="description" class="form-label fw-semibold text-primary-light text-sm mb-8">Description</label>
                            <textarea class="form-control radius-8 @error('description') is-invalid @enderror" id="description" name="description" rows="3" placeholder="Enter plot description">{{ old('description', $plot->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <label for="plot_no" class="form-label fw-semibold text-primary-light text-sm mb-8">Plot No <span class="text-danger-600">*</span></label>
                                <input type="text" class="form-control radius-8 @error('plot_no') is-invalid @enderror" id="plot_no" name="plot_no" placeholder="e.g., A-101" value="{{ old('plot_no', $plot->plot_no ?? '') }}" required>
                                @error('plot_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label for="size_katha" class="form-label fw-semibold text-primary-light text-sm mb-8">Size (Katha) <span class="text-danger-600">*</span></label>
                                <input type="number" step="0.01" class="form-control radius-8 @error('size_katha') is-invalid @enderror" id="size_katha" name="size_katha" placeholder="e.g., 3.5" value="{{ old('size_katha', $plot->size_katha ?? '') }}" required>
                                @error('size_katha')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="block" class="form-label fw-semibold text-primary-light text-sm mb-8">Block <span class="text-danger-600">*</span></label>
                                <input type="text" class="form-control radius-8 @error('block') is-invalid @enderror" id="block" name="block" placeholder="e.g., A" value="{{ old('block', $plot->block ?? '') }}" required>
                                @error('block')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="road_no" class="form-label fw-semibold text-primary-light text-sm mb-8">Road No <span class="text-danger-600">*</span></label>
                                <input type="text" class="form-control radius-8 @error('road_no') is-invalid @enderror" id="road_no" name="road_no" placeholder="e.g., 5" value="{{ old('road_no', $plot->road_no ?? '') }}" required>
                                @error('road_no')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="facing" class="form-label fw-semibold text-primary-light text-sm mb-8">Facing <span class="text-danger-600">*</span></label>
                                <select class="form-control radius-8 form-select @error('facing') is-invalid @enderror" id="facing" name="facing" required>
                                    <option value="">Select Facing</option>
                                    <option value="North" {{ old('facing', $plot->facing ?? '') == 'North' ? 'selected' : '' }}>North</option>
                                    <option value="South" {{ old('facing', $plot->facing ?? '') == 'South' ? 'selected' : '' }}>South</option>
                                    <option value="East" {{ old('facing', $plot->facing ?? '') == 'East' ? 'selected' : '' }}>East</option>
                                    <option value="West" {{ old('facing', $plot->facing ?? '') == 'West' ? 'selected' : '' }}>West</option>
                                </select>
                                @error('facing')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-20">
                                <label for="agent_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Agent Name</label>
                                <input type="text" class="form-control radius-8 @error('agent_name') is-invalid @enderror" id="agent_name" name="agent_name" placeholder="e.g., John Doe" value="{{ old('agent_name', $plot->agent_name ?? '') }}">
                                @error('agent_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="plot_category" class="form-label fw-semibold text-primary-light text-sm mb-8">Plot Category</label>
                                <select class="form-control radius-8 form-select @error('plot_category') is-invalid @enderror" id="plot_category" name="plot_category">
                                    <option value="">Select Category</option>
                                    <option value="Residential" {{ old('plot_category', $plot->plot_category ?? '') == 'Residential' ? 'selected' : '' }}>Residential</option>
                                    <option value="Commercial" {{ old('plot_category', $plot->plot_category ?? '') == 'Commercial' ? 'selected' : '' }}>Commercial</option>
                                    <option value="Industrial" {{ old('plot_category', $plot->plot_category ?? '') == 'Industrial' ? 'selected' : '' }}>Industrial</option>
                                    <option value="Agricultural" {{ old('plot_category', $plot->plot_category ?? '') == 'Agricultural' ? 'selected' : '' }}>Agricultural</option>
                                    <option value="Mixed Use" {{ old('plot_category', $plot->plot_category ?? '') == 'Mixed Use' ? 'selected' : '' }}>Mixed Use</option>
                                </select>
                                @error('plot_category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="road_width" class="form-label fw-semibold text-primary-light text-sm mb-8">Road Width</label>
                                <input type="text" class="form-control radius-8 @error('road_width') is-invalid @enderror" id="road_width" name="road_width" placeholder="e.g., 40 feet" value="{{ old('road_width', $plot->road_width ?? '') }}">
                                @error('road_width')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border mb-24">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Pricing & Payment</h6>
                        
                        <div class="row">
                            <div class="col-md-6 mb-20">
                                <label for="price" class="form-label fw-semibold text-primary-light text-sm mb-8">Total Price (৳) <span class="text-danger-600">*</span></label>
                                <input type="number" step="0.01" class="form-control radius-8 @error('price') is-invalid @enderror" id="price" name="price" placeholder="0.00" value="{{ old('price', $plot->price ?? '') }}" required>
                                @error('price')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-20">
                                <label for="booking_payment" class="form-label fw-semibold text-primary-light text-sm mb-8">Booking Payment (৳)</label>
                                <input type="number" step="0.01" class="form-control radius-8 @error('booking_payment') is-invalid @enderror" id="booking_payment" name="booking_payment" placeholder="0.00" value="{{ old('booking_payment', $plot->booking_payment ?? 0) }}">
                                @error('booking_payment')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="installment_plan" class="form-label fw-semibold text-primary-light text-sm mb-8">Installment Plan</label>
                                <select class="form-control radius-8 form-select" id="installment_plan" name="installment_plan">
                                    <option value="">Select Plan</option>
                                    <option value="monthly" {{ old('installment_plan', $plot->installment_plan ?? '') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                    <option value="quarterly" {{ old('installment_plan', $plot->installment_plan ?? '') == 'quarterly' ? 'selected' : '' }}>Quarterly</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="total_installments" class="form-label fw-semibold text-primary-light text-sm mb-8">Total Installments</label>
                                <input type="number" class="form-control radius-8" id="total_installments" name="total_installments" placeholder="e.g., 36" value="{{ old('total_installments', $plot->total_installments ?? '') }}">
                            </div>

                            <div class="col-md-4 mb-20">
                                <label for="installment_payment" class="form-label fw-semibold text-primary-light text-sm mb-8">Installment Payment (৳)</label>
                                <input type="number" step="0.01" class="form-control radius-8" id="installment_payment" name="installment_payment" placeholder="0.00" value="{{ old('installment_payment', $plot->installment_payment ?? '') }}" readonly>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="card border mb-24">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Status</h6>
                        <select class="form-control radius-8 form-select @error('status') is-invalid @enderror" id="status" name="status" required>
                            <option value="available" {{ old('status', $plot->status ?? 'available') == 'available' ? 'selected' : '' }}>Available</option>
                            <option value="pending" {{ old('status', $plot->status ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="booked" {{ old('status', $plot->status ?? '') == 'booked' ? 'selected' : '' }}>Booked</option>
                            <option value="sold" {{ old('status', $plot->status ?? '') == 'sold' ? 'selected' : '' }}>Sold</option>
                        </select>
                        @error('status')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror

                        <div class="row mt-24">
                            <div class="col-md-6 mb-2">
                                <a href="{{ route('admin.plots.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-24 py-11 radius-8 w-100 text-center d-block">
                                    Back
                                </a>
                            </div>
                            <div class="col-md-6 mb-2">
                                <button type="submit" class="btn btn-primary border border-primary-600 text-md px-24 py-12 radius-8 w-100">
                                    {{ isset($plot) ? 'Update' : 'Save' }}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card border mb-24">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Plot Map/Layout Image</h6>

                        @if(isset($plot) && $plot->plot_map)
                            {{-- Current image preview with change option --}}
                            <div id="current-image-wrapper" class="mb-16">
                                @if(Str::endsWith($plot->plot_map, '.pdf'))
                                    <div class="d-flex align-items-center gap-12 p-12 border radius-8 bg-base">
                                        <iconify-icon icon="mdi:file-pdf-box" class="text-danger" style="font-size:2rem;"></iconify-icon>
                                        <a href="{{ asset($plot->plot_map) }}" target="_blank" class="text-primary-600 fw-semibold">View Current PDF</a>
                                    </div>
                                @else
                                    <div class="position-relative" style="display:inline-block; max-width:100%;">
                                        <img src="{{ asset($plot->plot_map) }}" alt="Plot Map" class="w-100 radius-8" style="max-height:260px; object-fit:cover;">
                                    </div>
                                @endif
                                <button type="button" class="btn btn-sm btn-outline-primary mt-10" id="change-image-btn">
                                    <iconify-icon icon="mdi:image-edit-outline"></iconify-icon> Change Image
                                </button>
                            </div>

                            {{-- Hidden file input shown after clicking Change --}}
                            <div id="new-image-wrapper" class="mb-16 d-none">
                                <input type="file" class="form-control radius-8 @error('plot_map') is-invalid @enderror" id="plot_map" name="plot_map" accept="image/*,.pdf">
                                @error('plot_map')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <div class="d-flex align-items-center gap-8 mt-8">
                                    <small class="text-secondary-light">Accepted: JPG, PNG, PDF (Max: 5MB)</small>
                                    <button type="button" class="btn btn-sm btn-outline-secondary ms-auto" id="cancel-change-btn">Cancel</button>
                                </div>
                            </div>
                        @else
                            {{-- No existing image: always show file input --}}
                            <div class="mb-16">
                                <input type="file" class="form-control radius-8 @error('plot_map') is-invalid @enderror" id="plot_map" name="plot_map" accept="image/*,.pdf">
                                @error('plot_map')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-secondary-light">Accepted: JPG, PNG, PDF (Max: 5MB)</small>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="card border mb-24">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Google Maps Location</h6>
                        <div>
                            <input type="text" class="form-control radius-8 @error('google_maps_location') is-invalid @enderror" id="google_maps_location" name="google_maps_location" placeholder="Paste Google Maps embed URL" value="{{ old('google_maps_location', $plot->google_maps_location ?? '') }}">
                            @error('google_maps_location')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-secondary-light">Example: https://www.google.com/maps/embed?pb=...</small>
                        </div>
                    </div>
                </div>

                <div class="card border">
                    <div class="card-body">
                        <h6 class="text-md text-primary-light mb-16">Nearby Facilities</h6>
                        <textarea class="form-control radius-8 @error('nearby_facilities') is-invalid @enderror" id="nearby_facilities" name="nearby_facilities" rows="4" placeholder="Enter nearby facilities (schools, hospitals, markets, etc.)">{{ old('nearby_facilities', $plot->nearby_facilities ?? '') }}</textarea>
                        @error('nearby_facilities')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>
    </form>
	
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Auto-calculate installment payment based on price, booking_payment, and total_installments
    function calculateInstallment() {
        const totalPrice = parseFloat($('#price').val()) || 0;
        const bookingPayment = parseFloat($('#booking_payment').val()) || 0;
        const remainingPayment = totalPrice - bookingPayment;
        const totalInstallments = parseInt($('#total_installments').val()) || 0;
        
        if (remainingPayment > 0 && totalInstallments > 0) {
            const installmentPayment = (remainingPayment / totalInstallments).toFixed(2);
            $('#installment_payment').val(installmentPayment);
        } else {
            $('#installment_payment').val('');
        }
    }
    
    // Trigger installment calculation when price, booking payment, or total installments change
    $('#price, #booking_payment, #total_installments').on('input change', function() {
        calculateInstallment();
    });
    
    // Calculate on page load if values exist
    calculateInstallment();

    // Change image toggle
    $('#change-image-btn').on('click', function() {
        $('#current-image-wrapper').addClass('d-none');
        $('#new-image-wrapper').removeClass('d-none');
    });

    $('#cancel-change-btn').on('click', function() {
        $('#new-image-wrapper').addClass('d-none');
        $('#current-image-wrapper').removeClass('d-none');
        $('#plot_map').val('');
    });
});
</script>
@endpush
