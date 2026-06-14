@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">All Bookings</h6>
    <a href="{{ route('admin.bookings.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
        <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
        Add Booking
    </a>
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

<div class="card h-100 p-0 radius-12">
    <div class="card-header border-bottom bg-base py-16 px-24">
        <form method="GET" action="{{ route('admin.bookings.index') }}" class="d-flex align-items-center flex-wrap gap-3">
            <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
            <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="per_page" id="perPage">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <input type="text" class="form-control form-control-sm w-auto ps-12 py-6 radius-12 h-40-px filter-id-input" name="booking_id" placeholder="Booking ID" value="{{ request('booking_id') }}">
            <input type="text" class="form-control form-control-sm w-auto ps-12 py-6 radius-12 h-40-px filter-id-input" name="client_id" placeholder="Client ID" value="{{ request('client_id') }}">
            <input type="text" class="form-control form-control-sm w-auto ps-12 py-6 radius-12 h-40-px filter-id-input" name="plot_no" placeholder="Plot No" value="{{ request('plot_no') }}">
            <input type="text" class="form-control w-auto ps-12 py-6 radius-12 h-40-px" name="date_range" id="dateRange" placeholder="Select Date Range" value="{{ request('date_from') && request('date_to') ? request('date_from') . ' to ' . request('date_to') : '' }}" readonly>
            <input type="hidden" name="date_from" id="dateFrom" value="{{ request('date_from') }}">
            <input type="hidden" name="date_to" id="dateTo" value="{{ request('date_to') }}">
            <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="status">
                <option value="">All Status</option>
                <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="pre-booked" {{ request('status') == 'pre-booked' ? 'selected' : '' }}>Pre-Booked</option>
                <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="cancelled" {{ request('status') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
            <button type="submit" class="btn btn-sm btn-success px-12 py-6 radius-8">
                <iconify-icon icon="material-symbols:filter-alt" class="icon"></iconify-icon>
                Filter
            </button>
            @if(request()->hasAny(['status', 'per_page', 'date_from', 'date_to', 'booking_id', 'client_id', 'plot_no']))
            <a href="{{ route('admin.bookings.index') }}" class="btn btn-sm btn-outline-danger px-12 py-6 radius-8">
                <iconify-icon icon="material-symbols:filter-alt-off" class="icon"></iconify-icon>
                Clear
            </a>
            @endif
        </form>
    </div>
    <div class="card-body p-24">
        <div class="table-responsive scroll-sm">
            <table class="table bordered-table sm-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">S.L</th>
                        <th scope="col">Plot</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Referral Agent</th>
                        <th scope="col">Booking Date</th>
                        <th scope="col" class="text-center">Status</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bookings as $index => $booking)
                    <tr>
                        <td>{{ $bookings->firstItem() + $index }}</td>
                        <td>
                            <div>
                                <span class="fw-semibold text-primary-600">{{ $booking->plot->plot_no }}</span>
                                <small class="d-block text-secondary-light">{{ $booking->plot->title }}</small>
                            </div>
                        </td>
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
                                    <span class="fw-medium">{{ $booking->user->name }}</span>
                                    <small class="d-block text-secondary-light">CID-{{ str_pad($booking->user->client_id, 5, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($booking->agent)
                                <span class="fw-medium">{{ $booking->agent->name }}</span>
                            @else
                                <span class="text-secondary-light">-</span>
                            @endif
                        </td>
                        <td>{{ $booking->created_at->format('d M, Y') }}</td>
                        <td class="text-center">
                            @if($booking->status == 'pending')
                                <span class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
                            @elseif($booking->status == 'pre-booked')
                                <span class="bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Pre-Booked</span>
                            @elseif($booking->status == 'approved')
                                <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Approved</span>
                            @else
                                <span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">Cancelled</span>
                            @endif
                        </td>
                        <td class="text-center">
                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Details">
                                    <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                </a>
                                @if($booking->payments_count == 0)
                                <form action="{{ route('admin.bookings.destroy', $booking->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Delete">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                </form>
                                @else
                                <span class="bg-neutral-100 text-neutral-400 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="Cannot delete: has {{ $booking->payments_count }} payment(s). Remove payments first.">
                                    <iconify-icon icon="mdi:lock" class="menu-icon"></iconify-icon>
                                </span>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="8" class="text-center py-4">
                            <div class="text-secondary-light">
                                <iconify-icon icon="hugeicons:invoice-03" class="text-4xl mb-2"></iconify-icon>
                                <p class="mb-0">No bookings found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($bookings->hasPages())
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
            <span>Showing {{ $bookings->firstItem() }} to {{ $bookings->lastItem() }} of {{ $bookings->total() }} entries</span>
            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                {{ $bookings->links() }}
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<style>
    .filter-id-input { width: 130px; }
    @media (max-width: 575.98px) {
        .filter-id-input { width: 100%; flex: 1 1 100%; }
    }
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script>
    flatpickr("#dateRange", {
        mode: "range",
        dateFormat: "Y-m-d",
        onChange: function(selectedDates, dateStr, instance) {
            if (selectedDates.length === 2) {
                document.getElementById('dateFrom').value = instance.formatDate(selectedDates[0], 'Y-m-d');
                document.getElementById('dateTo').value = instance.formatDate(selectedDates[1], 'Y-m-d');
            }
        }
    });
</script>
@endpush