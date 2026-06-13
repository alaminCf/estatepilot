@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">All Payments</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Payments</li>
    </ul>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card h-100 p-0 radius-12">
    <div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
        <form method="GET" action="{{ route('admin.payments.index') }}" class="d-flex align-items-center flex-wrap gap-3 flex-grow-1">
            <span class="text-md fw-medium text-secondary-light mb-0">Show</span>
            <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="per_page" id="perPage">
                <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                <option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
                <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
            </select>
            <div class="navbar-search">
                <input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search" value="{{ request('search') }}">
                <iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
            </div>
            <input type="text" class="form-control w-auto ps-12 py-6 radius-12 h-40-px" name="date_range" id="dateRange" placeholder="Select Date Range" value="{{ request('date_from') && request('date_to') ? request('date_from') . ' to ' . request('date_to') : '' }}" readonly>
            <input type="hidden" name="date_from" id="dateFrom" value="{{ request('date_from') }}">
            <input type="hidden" name="date_to" id="dateTo" value="{{ request('date_to') }}">
            <select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="payment_type">
                <option value="">All Types</option>
                <option value="Booking Payment" {{ request('payment_type') == 'Booking Payment' ? 'selected' : '' }}>Booking Payment</option>
                <option value="Down Payment" {{ request('payment_type') == 'Down Payment' ? 'selected' : '' }}>Down Payment</option>
                <option value="Installment Payment" {{ request('payment_type') == 'Installment Payment' ? 'selected' : '' }}>Installment Payment</option>
                <option value="Part Of Installment" {{ request('payment_type') == 'Part Of Installment' ? 'selected' : '' }}>Part Of Installment</option>
            </select>
            <button type="submit" class="btn btn-sm btn-success px-12 py-6 radius-8">
                <iconify-icon icon="material-symbols:filter-alt" class="icon"></iconify-icon>
                Filter
            </button>
            @if(request()->hasAny(['search', 'payment_type', 'per_page', 'date_from', 'date_to']))
            <a href="{{ route('admin.payments.index') }}" class="btn btn-sm btn-outline-danger px-12 py-6 radius-8">
                <iconify-icon icon="material-symbols:filter-alt-off" class="icon"></iconify-icon>
                Clear
            </a>
            @endif
        </form>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.payments.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
                <iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
                Add Payment
            </a>
        </div>
    </div>
    <div class="card-body p-24">
        <div class="table-responsive scroll-sm">
            <table class="table bordered-table sm-table mb-0">
                <thead>
                    <tr>
                        <th scope="col">S.L</th>
                        <th scope="col">Booking</th>
                        <th scope="col">Customer</th>
                        <th scope="col">Payment Type</th>
                        <th scope="col">Amount</th>
                        <th scope="col">Date</th>
                        <th scope="col" class="text-center">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($payments as $index => $payment)
                    <tr>
                        <td>{{ $payments->firstItem() + $index }}</td>
                        <td>
                            <div>
                                <span class="fw-semibold text-primary-600">#{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</span>
                                <small class="d-block text-secondary-light">{{ $payment->booking->plot->plot_no }}</small>
                            </div>
                        </td>
                        <td>
                            <div class="d-flex align-items-center gap-10">
                                @if($payment->booking->user->photo)
                                    <img src="{{ $payment->booking->user->profile_image_url }}" alt="{{ $payment->booking->user->name }}" class="w-40-px h-40-px rounded-circle object-fit-cover">
                                @else
                                    <span class="w-40-px h-40-px rounded-circle bg-primary-100 text-primary-600 d-flex justify-content-center align-items-center fw-semibold">
                                        {{ strtoupper(substr($payment->booking->user->name, 0, 1)) }}
                                    </span>
                                @endif
                                <div>
                                    <span class="fw-medium">{{ $payment->booking->user->name }}</span>
                                    <small class="d-block text-secondary-light">CID-{{ str_pad($payment->booking->user->client_id, 5, '0', STR_PAD_LEFT) }}</small>
                                </div>
                            </div>
                        </td>
                        <td>
                            @if($payment->payment_type == 'Booking Payment')
                                <span class="bg-info-focus text-info-600 border border-info-main px-12 py-4 radius-4 fw-medium text-sm">{{ $payment->payment_type }}</span>
                            @elseif($payment->payment_type == 'Down Payment')
                                <span class="bg-success-focus text-success-600 border border-success-main px-12 py-4 radius-4 fw-medium text-sm">{{ $payment->payment_type }}</span>
                            @elseif($payment->payment_type == 'Installment Payment')
                                <span class="bg-warning-focus text-warning-600 border border-warning-main px-12 py-4 radius-4 fw-medium text-sm">{{ $payment->payment_type }}{{ $payment->instalment_quantity > 1 ? ' ×'.$payment->instalment_quantity : '' }}</span>
                            @elseif($payment->payment_type == 'Part Of Installment')
                                <span class="bg-lilac-focus text-lilac-600 border border-lilac-main px-12 py-4 radius-4 fw-medium text-sm" style="background:#fef3c7;color:#92400e;border-color:#fcd34d;">{{ $payment->payment_type }}</span>
                            @else
                                <span class="bg-neutral-100 text-neutral-600 border border-neutral-300 px-12 py-4 radius-4 fw-medium text-sm">{{ $payment->payment_type }}</span>
                            @endif
                        </td>
                        <td>
                            <span class="fw-semibold text-success-600">৳{{ format_bd_number($payment->amount, 2) }}</span>
                        </td>
                        <td>{{ $payment->created_at->format('d M, Y') }}</td>
                        <td class="text-center">
                            <div class="d-flex align-items-center gap-10 justify-content-center">
                                <a href="{{ route('admin.payments.invoice', $payment->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Invoice" target="_blank">
                                    <iconify-icon icon="mdi:file-document-outline" class="menu-icon"></iconify-icon>
                                </a>
                                <a href="{{ route('admin.payments.show', $payment->id) }}" class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Details">
                                    <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                </a>
                                <form action="{{ route('admin.payments.destroy', $payment->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this payment?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0">
                                        <iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-4">
                            <div class="text-secondary-light">
                                <iconify-icon icon="mdi:cash-multiple" class="text-4xl mb-2"></iconify-icon>
                                <p class="mb-0">No payments found</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        @if($payments->hasPages())
        <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
            <span>Showing {{ $payments->firstItem() }} to {{ $payments->lastItem() }} of {{ $payments->total() }} entries</span>
            <ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
                {{ $payments->links() }}
            </ul>
        </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
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