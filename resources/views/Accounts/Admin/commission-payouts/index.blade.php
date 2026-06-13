@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">Commission Payouts</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
		<li>-</li>
		<li class="fw-medium">Commission Payouts</li>
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
		<form method="GET" action="{{ route('admin.commission-payouts.index') }}" class="d-flex align-items-center flex-wrap gap-3 flex-grow-1">
			<span class="text-md fw-medium text-secondary-light mb-0">Show</span>
			<select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="per_page">
				<option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
				<option value="25" {{ request('per_page', 25) == 25 ? 'selected' : '' }}>25</option>
				<option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
				<option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
			</select>
			<div class="navbar-search">
				<input type="text" class="bg-base h-40-px w-auto" name="search" placeholder="Search" value="{{ request('search') }}">
				<iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
			</div>
			<select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="user_id">
				<option value="">All Commission Users</option>
				@foreach($commissionUsers as $cu)
					<option value="{{ $cu->id }}" {{ request('user_id') == $cu->id ? 'selected' : '' }}>{{ $cu->name }}{{ $cu->commission_type ? ' (' . $cu->commissionTypeLabel() . ')' : '' }}</option>
				@endforeach
			</select>
			<input type="date" class="form-control form-control-sm w-auto ps-12 py-6 radius-12 h-40-px" name="date_from" value="{{ request('date_from') }}">
			<input type="date" class="form-control form-control-sm w-auto ps-12 py-6 radius-12 h-40-px" name="date_to" value="{{ request('date_to') }}">
			<button type="submit" class="btn btn-sm btn-success px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt" class="icon"></iconify-icon>
				Filter
			</button>
			@if(request()->hasAny(['search', 'user_id', 'per_page', 'date_from', 'date_to']))
			<a href="{{ route('admin.commission-payouts.index') }}" class="btn btn-sm btn-outline-danger px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt-off" class="icon"></iconify-icon>
				Clear
			</a>
			@endif
		</form>
		<div class="d-flex gap-2">
			<a href="{{ route('admin.commission-payouts.export', request()->all()) }}" class="btn btn-outline-success text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
				<iconify-icon icon="mdi:file-export" class="icon text-xl line-height-1"></iconify-icon>
				Export CSV
			</a>
			<a href="{{ route('admin.commission-payouts.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
				<iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
				New Payout
			</a>
		</div>
	</div>
	<div class="card-body p-24">
		<div class="table-responsive scroll-sm">
			<table class="table bordered-table sm-table mb-0">
				<thead>
					<tr>
						<th scope="col">ID</th>
						<th scope="col">Commission User</th>
						<th scope="col">Type</th>
						<th scope="col">Amount</th>
						<th scope="col">Reference</th>
						<th scope="col">Date</th>
						<th scope="col">Note</th>
						<th scope="col" class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($payouts as $payout)
					<tr>
						<td>#{{ str_pad($payout->id, 5, '0', STR_PAD_LEFT) }}</td>
						<td>
							<div>
								<a href="{{ $payout->user ? route('admin.commission-users.show', $payout->user->id) : '#' }}" class="fw-medium text-primary-600 hover-text-primary">{{ $payout->user->name ?? 'N/A' }}</a>
								<small class="d-block text-secondary-light">{{ $payout->user->referral_code ?? '' }}</small>
							</div>
						</td>
						<td>
							@if($payout->user && $payout->user->commission_type)
								<span class="badge bg-primary-50 text-primary-600">{{ $payout->user->commissionTypeLabel() }}</span>
							@else
								<span class="badge bg-neutral-200 text-neutral-600">Unassigned</span>
							@endif
						</td>
						<td><span class="fw-semibold text-success-600">৳{{ format_bd_number($payout->amount, 2) }}</span></td>
						<td>
							@if($payout->booking_id)
								<a href="{{ route('admin.bookings.show', $payout->booking_id) }}" class="text-primary-600 hover-text-primary">#{{ str_pad($payout->booking_id, 5, '0', STR_PAD_LEFT) }}</a>
							@else
								<span class="text-secondary-light">—</span>
							@endif
						</td>
						<td class="text-secondary-light">{{ $payout->created_at->format('d M, Y') }}</td>
						<td class="text-secondary-light">{{ Str::limit($payout->payment_note, 30) ?? '—' }}</td>
						<td class="text-center">
							<form action="{{ route('admin.commission-payouts.destroy', $payout->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Delete this payout? The amount will be added back to the user\'s balance.');">
								@csrf
								@method('DELETE')
								<button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0">
									<iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
								</button>
							</form>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="8" class="text-center py-4">
							<div class="text-secondary-light">
								<iconify-icon icon="mdi:cash-remove" class="text-4xl mb-2"></iconify-icon>
								<p class="mb-0">No commission payouts found</p>
							</div>
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		@if($payouts->hasPages())
		<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
			<span>Showing {{ $payouts->firstItem() }} to {{ $payouts->lastItem() }} of {{ $payouts->total() }} entries</span>
			<ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
				{{ $payouts->links() }}
			</ul>
		</div>
		@endif
	</div>
</div>
@endsection
