@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">All Commission Users</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
		<li>-</li>
		<li class="fw-medium">Commission Users</li>
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

<div class="card h-100 p-0 radius-12">
	<div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
		<form method="GET" action="{{ route('admin.commission-users.index') }}" class="d-flex align-items-center flex-wrap gap-3 flex-grow-1">
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
			<select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="commission_type">
				<option value="">All Types</option>
				@foreach(config('commission.types') as $typeKey => $type)
					<option value="{{ $typeKey }}" {{ request('commission_type') == $typeKey ? 'selected' : '' }}>{{ $type['label'] }}</option>
				@endforeach
				<option value="unassigned" {{ request('commission_type') == 'unassigned' ? 'selected' : '' }}>Unassigned</option>
			</select>
			<select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="status">
				<option value="">All Status</option>
				<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
				<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
			</select>
			<button type="submit" class="btn btn-sm btn-success px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt" class="icon"></iconify-icon>
				Filter
			</button>
			@if(request()->hasAny(['search', 'status', 'commission_type', 'per_page']))
			<a href="{{ route('admin.commission-users.index') }}" class="btn btn-sm btn-outline-danger px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt-off" class="icon"></iconify-icon>
				Clear
			</a>
			@endif
		</form>
		<a href="{{ route('admin.commission-users.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
			<iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
			Add Commission User
		</a>
	</div>
	<div class="card-body p-24">
		<div class="table-responsive scroll-sm">
			<table class="table bordered-table sm-table mb-0">
				<thead>
					<tr>
						<th scope="col">Name</th>
						<th scope="col">Type</th>
						<th scope="col">Referral Code</th>
						<th scope="col">Upline</th>
						<th scope="col" class="text-center">Booking %</th>
						<th scope="col" class="text-center">Down %</th>
						<th scope="col" class="text-center">Instalment %</th>
						<th scope="col" class="text-center">Status</th>
						<th scope="col" class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($commissionUsers ?? [] as $user)
					<tr>
						<td>
							<div class="d-flex align-items-center">
								@if($user->photo)
								<img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden object-fit-cover">
								@else
									<span class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 bg-warning-100 d-flex justify-content-center align-items-center text-warning-600 fw-semibold">
										{{ strtoupper(substr($user->name, 0, 2)) }}
									</span>
								@endif
								<div class="flex-grow-1">
									<span class="text-md mb-0 fw-medium d-block">{{ $user->name }}</span>
									<small class="text-secondary-light">{{ $user->phone ?? $user->email }}</small>
								</div>
							</div>
						</td>
						<td>
							@if($user->commission_type)
								<span class="bg-primary-50 text-primary-600 border border-primary-main px-12 py-4 radius-4 fw-medium text-sm">{{ $user->commissionTypeLabel() }}</span>
							@else
								<span class="bg-neutral-200 text-neutral-600 border border-neutral-400 px-12 py-4 radius-4 fw-medium text-sm">Unassigned</span>
							@endif
						</td>
						<td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->referral_code ?? 'N/A' }}</span></td>
						<td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->parent->name ?? '—' }}</span></td>
						<td class="text-center">{{ $user->booking_pct !== null ? rtrim(rtrim(number_format($user->booking_pct, 2), '0'), '.') . '%' : '—' }}</td>
						<td class="text-center">{{ $user->down_pct !== null ? rtrim(rtrim(number_format($user->down_pct, 2), '0'), '.') . '%' : '—' }}</td>
						<td class="text-center">{{ $user->instalment_pct !== null ? rtrim(rtrim(number_format($user->instalment_pct, 2), '0'), '.') . '%' : '—' }}</td>
						<td class="text-center">
							@if($user->status == 'active')
								<span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
							@else
								<span class="bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Inactive</span>
							@endif
						</td>
						<td class="text-center">
							<div class="d-flex align-items-center gap-10 justify-content-center">
								<a href="{{ route('admin.commission-users.show', $user->id) }}" class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Details">
									<iconify-icon icon="mdi:eye" class="menu-icon"></iconify-icon>
								</a>
								<a href="{{ route('admin.commission-users.edit', $user->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle">
									<iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
								</a>
								<form action="{{ route('admin.commission-users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this commission user?');">
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
						<td colspan="9" class="text-center py-4">
							<div class="text-secondary-light">
								<iconify-icon icon="solar:user-hands-outline" class="text-4xl mb-2"></iconify-icon>
								<p class="mb-0">No commission users found</p>
							</div>
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>

		@if(isset($commissionUsers) && $commissionUsers->hasPages())
		<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
			<span>Showing {{ $commissionUsers->firstItem() }} to {{ $commissionUsers->lastItem() }} of {{ $commissionUsers->total() }} entries</span>
			<ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
				{{ $commissionUsers->links() }}
			</ul>
		</div>
		@endif
	</div>
</div>
@endsection
