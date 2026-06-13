@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <h6 class="fw-semibold mb-0">Customer Details</h6>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">
            <a href="{{ route('admin.users.index') }}" class="hover-text-primary">Customers</a>
        </li>
        <li>-</li>
        <li class="fw-medium">{{ $user->name }}</li>
    </ul>
</div>

<div class="row gy-4">
    <!-- Left Column -->
    <div class="col-lg-4">
        <!-- Customer Profile Card -->
        <div class="card mb-24">
            <div class="card-body text-center">
                <div class="mb-20">
                    @if($user->photo)
                        <img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="w-120-px h-120-px rounded-circle object-fit-cover mx-auto mb-16">
                    @else
                        <div class="w-120-px h-120-px rounded-circle bg-primary-100 d-flex justify-content-center align-items-center mx-auto mb-16">
                            <span class="text-primary-600 fw-bold" style="font-size: 48px;">{{ strtoupper(substr($user->name, 0, 2)) }}</span>
                        </div>
                    @endif
                    <h5 class="mb-4">{{ $user->name }}</h5>
                    <span class="text-secondary-light text-sm d-block mb-8">CID-{{ str_pad($user->client_id, 5, '0', STR_PAD_LEFT) }}</span>
                    <span class="badge {{ $user->status == 'active' ? 'bg-success-600' : 'bg-neutral-400' }} text-white px-16 py-8">
                        {{ ucfirst($user->status) }}
                    </span>
                </div>

                <div class="text-start">
                    <ul class="list-unstyled mb-0">
                        <li class="mb-16 pb-16 border-bottom d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:email" class="text-primary-600 text-xl"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">Email</span>
                                <span class="fw-medium">{{ $user->email }}</span>
                            </div>
                        </li>
                        <li class="mb-16 pb-16 border-bottom d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:phone" class="text-primary-600 text-xl"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">Phone</span>
                                <span class="fw-medium">{{ $user->phone ?? 'Not provided' }}</span>
                            </div>
                        </li>
                        <li class="mb-16 pb-16 border-bottom d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:account" class="text-primary-600 text-xl"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">Father's Name</span>
                                <span class="fw-medium">{{ $user->father_name ?? 'Not provided' }}</span>
                            </div>
                        </li>
                        <li class="mb-16 pb-16 border-bottom d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:account" class="text-primary-600 text-xl"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">Mother's Name</span>
                                <span class="fw-medium">{{ $user->mother_name ?? 'Not provided' }}</span>
                            </div>
                        </li>
                        <li class="mb-16 pb-16 border-bottom d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:card-account-details" class="text-primary-600 text-xl"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">National ID (NID)</span>
                                <span class="fw-medium">{{ $user->nid ?? 'Not provided' }}</span>
                            </div>
                        </li>
                        @if($user->address)
                        <li class="mb-16 pb-16 border-bottom d-flex align-items-start gap-8">
                            <iconify-icon icon="mdi:map-marker" class="text-primary-600 text-xl mt-4"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">Address</span>
                                <span class="fw-medium">{{ $user->address }}</span>
                            </div>
                        </li>
                        @endif
                        <li class="mb-0 d-flex align-items-center gap-8">
                            <iconify-icon icon="mdi:calendar" class="text-primary-600 text-xl"></iconify-icon>
                            <div class="flex-grow-1">
                                <span class="text-secondary-light text-sm d-block mb-4">Member Since</span>
                                <span class="fw-medium">{{ $user->created_at->format('M d, Y') }}</span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="card">
            <div class="card-body">
                <div class="d-flex flex-column gap-12">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-primary w-100">
                        <iconify-icon icon="lucide:edit" class="me-2"></iconify-icon>
                        Edit Customer
                    </a>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary w-100">
                        <iconify-icon icon="mdi:arrow-left" class="me-2"></iconify-icon>
                        Back to List
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Right Column -->
    <div class="col-lg-8">
        <!-- Summary Cards -->
        <div class="row gy-4 mb-24">
            <div class="col-xxl-4 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-1">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Bookings</p>
                                <h6 class="mb-0">{{ $bookings->count() }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-cyan rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:document-text-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-2">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Paid</p>
                                <h6 class="mb-0">৳{{ format_bd_number($totalPaid, 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-success-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:wallet-money-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-4 col-sm-6">
                <div class="card shadow-none radius-8 border h-100 bg-gradient-start-4">
                    <div class="card-body p-20">
                        <div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
                            <div>
                                <p class="fw-medium text-primary-light mb-1">Total Due</p>
                                <h6 class="mb-0">৳{{ format_bd_number($totalDue, 2) }}</h6>
                            </div>
                            <div class="w-50-px h-50-px bg-warning-main rounded-circle d-flex justify-content-center align-items-center">
                                <iconify-icon icon="solar:clock-circle-bold" class="text-white text-2xl mb-0"></iconify-icon>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bookings List -->
        <div class="card mb-24">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:book-multiple" class="text-primary-600"></iconify-icon>
                    Bookings ({{ $bookings->count() }})
                </h6>
            </div>
            <div class="card-body p-24">
                @if($bookings->count() > 0)
                    <div class="table-responsive scroll-sm">
                        <table class="table bordered-table sm-table mb-0">
                            <thead>
                                <tr>
                                    <th scope="col">S.L</th>
                                    <th scope="col">Plot</th>
                                    <th scope="col">Booking Date</th>
                                    <th scope="col">Total Price</th>
                                    <th scope="col">Paid</th>
                                    <th scope="col">Due</th>
                                    <th scope="col" class="text-center">Status</th>
                                    <th scope="col" class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bookings as $index => $booking)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>
                                        <div>
                                            <span class="fw-semibold text-primary-600">{{ $booking->plot->plot_no }}</span>
                                            <small class="d-block text-secondary-light">{{ $booking->plot->title }}</small>
                                        </div>
                                    </td>
                                    <td>{{ $booking->created_at->format('d M, Y') }}</td>
                                    <td><span class="text-md mb-0 fw-normal text-secondary-light">৳{{ format_bd_number($booking->price, 2) }}</span></td>
                                    <td><span class="text-success-600 fw-medium">৳{{ format_bd_number($booking->payments->sum('amount'), 2) }}</span></td>
                                    <td><span class="text-warning-600 fw-medium">৳{{ format_bd_number($booking->price - $booking->payments->sum('amount'), 2) }}</span></td>
                                    <td class="text-center">
                                        @if($booking->status == 'approved')
                                            <span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Approved</span>
                                        @elseif($booking->status == 'pending')
                                            <span class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
                                        @elseif($booking->status == 'pre-booked')
                                            <span class="bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Pre-Booked</span>
                                        @else
                                            <span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">{{ ucfirst($booking->status) }}</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <a href="{{ route('admin.bookings.show', $booking->id) }}" class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
                                            <iconify-icon icon="lucide:eye" class="menu-icon"></iconify-icon>
                                        </a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="text-center py-32">
                        <iconify-icon icon="mdi:book-off" class="text-secondary-light" style="font-size: 64px;"></iconify-icon>
                        <p class="text-secondary-light mb-0 mt-12">No bookings found</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payments List -->
        <div class="card">
            <div class="card-header bg-base border-bottom py-16 px-24">
                <h6 class="mb-0 d-flex align-items-center gap-2">
                    <iconify-icon icon="mdi:currency-bdt" class="text-primary-600"></iconify-icon>
                    Payment History ({{ $payments->count() }})
                </h6>
            </div>
            <div class="card-body p-0">
                @if($payments->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-neutral-50">
                                <tr>
                                    <th class="ps-24">Date</th>
                                    <th>Plot</th>
                                    <th>Payment Type</th>
                                    <th>Amount</th>
                                    <th class="pe-24">Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                <tr>
                                    <td class="ps-24">{{ $payment->created_at->format('M d, Y') }}</td>
                                    <td>
                                        <div>
                                            <div class="fw-medium">{{ $payment->booking->plot->plot_no }}</div>
                                            <small class="text-secondary-light">{{ $payment->booking->plot->title }}</small>
                                        </div>
                                    </td>
                                    <td>
                                        <span class="badge bg-info-100 text-info-600 px-12 py-4">
                                            {{ $payment->payment_type }}
                                        </span>
                                    </td>
                                    <td class="text-success-600 fw-bold">৳{{ format_bd_number($payment->amount, 2) }}</td>
                                    <td class="pe-24">{{ $payment->payment_note ?? '-' }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                            <tfoot class="bg-neutral-50">
                                <tr>
                                    <td colspan="3" class="ps-24 fw-bold">Total Paid:</td>
                                    <td colspan="3" class="pe-24 fw-bold text-success-600">৳{{ format_bd_number($totalPaid, 2) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                @else
                    <div class="text-center py-32">
                        <iconify-icon icon="mdi:cash-remove" class="text-secondary-light" style="font-size: 64px;"></iconify-icon>
                        <p class="text-secondary-light mb-0 mt-12">No payments found</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
