@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">All Plots</h6>
	<a href="{{ route('admin.plots.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
		<iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
		Add New Plot
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
		<form method="GET" action="{{ route('admin.plots.index') }}" class="d-flex align-items-center flex-wrap gap-3" id="filterForm">
			<span class="text-md fw-medium text-secondary-light mb-0">Show</span>
			<select name="per_page" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
				<option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
				<option value="25" {{ (request('per_page') == 25 || !request()->has('per_page')) ? 'selected' : '' }}>25</option>
				<option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
				<option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
			</select>
			<input type="text" class="form-control form-control-sm w-auto ps-12 py-6 radius-12 h-40-px filter-id-input" name="plot_no" placeholder="Plot No" value="{{ request('plot_no') }}">
			<select name="status" class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px">
				<option value="">All plots</option>
				<option value="available" {{ request('status') == 'available' ? 'selected' : '' }}>Available plots</option>
				<option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending plots</option>
				<option value="booked" {{ request('status') == 'booked' ? 'selected' : '' }}>Booked plots</option>
				<option value="sold" {{ request('status') == 'sold' ? 'selected' : '' }}>Sold plots</option>
			</select>
			<button type="submit" class="btn btn-sm btn-outline-primary px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt" class="icon"></iconify-icon>
				Filter
			</button>
			@if(request()->hasAny(['status', 'per_page', 'plot_no']))
			<a href="{{ route('admin.plots.index') }}" class="btn btn-sm btn-outline-danger px-12 py-6 radius-8">
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
						<th scope="col">Plot Title</th>
						<th scope="col">Plot No</th>
						<th scope="col">Size (Katha)</th>
						<th scope="col">Block</th>
						<th scope="col">Road</th>
						<th scope="col">Price (৳)</th>
						<th scope="col" class="text-center">Status</th>
						<th scope="col" class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($plots as $index => $plot)
					<tr>
						<td>{{ $plots->firstItem() + $index }}</td>
						<td><span class="text-md fw-medium">{{ $plot->title }}</span></td>
						<td><span class="text-md fw-semibold text-primary-600">{{ $plot->plot_no }}</span></td>
						<td>{{ $plot->size_katha }}</td>
						<td>{{ $plot->block }}</td>
						<td>{{ $plot->road_no }}</td>
						<td><span class="fw-medium">৳{{ format_bd_number($plot->price, 2) }}</span></td>
						<td class="text-center">
							@if($plot->status == 'available')
								<span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Available</span>
							@elseif($plot->status == 'pending')
								<span class="bg-info-focus text-info-600 border border-info-main px-24 py-4 radius-4 fw-medium text-sm">Pending</span>
							@elseif($plot->status == 'booked')
								<span class="bg-warning-focus text-warning-600 border border-warning-main px-24 py-4 radius-4 fw-medium text-sm">Booked</span>
							@else
								<span class="bg-danger-focus text-danger-600 border border-danger-main px-24 py-4 radius-4 fw-medium text-sm">Sold</span>
							@endif
						</td>
						<td class="text-center">
							<div class="d-flex align-items-center gap-10 justify-content-center">
								<a href="{{ route('admin.plots.show', $plot->id) }}" class="bg-info-focus text-info-600 bg-hover-info-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="View Details">
									<iconify-icon icon="mdi:eye" class="menu-icon"></iconify-icon>
								</a>
								@if($plot->status === 'available')
								<a href="{{ route('admin.plots.edit', $plot->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="Edit">
									<iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
								</a>
								@else
								<span class="bg-neutral-100 text-neutral-400 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="Cannot edit: plot is {{ ucfirst($plot->status) }}. Remove bookings first.">
									<iconify-icon icon="mdi:lock" class="menu-icon"></iconify-icon>
								</span>
								@endif
								@if($plot->status === 'available')
								<form action="{{ route('admin.plots.destroy', $plot->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this plot?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Delete">
										<iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
									</button>
								</form>
								@else
								<span class="bg-neutral-100 text-neutral-400 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="Cannot delete: plot is {{ ucfirst($plot->status) }}. Remove bookings first.">
									<iconify-icon icon="mdi:lock" class="menu-icon"></iconify-icon>
								</span>
								@endif
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="9" class="text-center py-4">
							<div class="text-secondary-light">
								<iconify-icon icon="material-symbols:map-outline" class="text-4xl mb-2"></iconify-icon>
								<p class="mb-0">No plots found</p>
							</div>
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		
		@if($plots->hasPages())
		<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
			<span>Showing {{ $plots->firstItem() }} to {{ $plots->lastItem() }} of {{ $plots->total() }} entries</span>
			<ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
				{{ $plots->links() }}
			</ul>
		</div>
		@endif
	</div>
</div>
@endsection

@push('styles')
<style>
	.filter-id-input { width: 130px; }
	@media (max-width: 575.98px) {
		.filter-id-input { width: 100%; flex: 1 1 100%; }
	}
</style>
@endpush

@push('scripts')
@endpush
