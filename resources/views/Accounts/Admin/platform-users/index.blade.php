@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">Platform User</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
		<li>-</li>
		<li class="fw-medium">Platform User</li>
	</ul>
</div>

<div class="card h-100 p-0 radius-12">
	<div class="card-header border-bottom bg-base py-16 px-24 d-flex align-items-center flex-wrap gap-3 justify-content-between">
		<form method="GET" action="{{ route('admin.platform-users.index') }}" class="d-flex align-items-center flex-wrap gap-3 flex-grow-1">
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
			<select class="form-select form-select-sm w-auto ps-12 py-6 radius-12 h-40-px" name="status">
				<option value="">All Status</option>
				<option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
				<option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
			</select>
			<button type="submit" class="btn btn-sm btn-success px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt" class="icon"></iconify-icon>
				Filter
			</button>
			@if(request()->hasAny(['search', 'status', 'per_page']))
			<a href="{{ route('admin.platform-users.index') }}" class="btn btn-sm btn-outline-danger px-12 py-6 radius-8">
				<iconify-icon icon="material-symbols:filter-alt-off" class="icon"></iconify-icon>
				Clear
			</a>
			@endif
		</form>
		<a href="{{ route('admin.platform-users.create') }}" class="btn btn-primary text-sm btn-sm px-12 py-12 radius-8 d-flex align-items-center gap-2">
			<iconify-icon icon="ic:baseline-plus" class="icon text-xl line-height-1"></iconify-icon>
			Add Platform User
		</a>
	</div>
	<div class="card-body p-24">
		<div class="table-responsive scroll-sm">
			<table class="table bordered-table sm-table mb-0">
				<thead>
					<tr>
						<th scope="col">S.L</th>
						<th scope="col">Name</th>
						<th scope="col">Email</th>
						<th scope="col">Phone</th>
						<th scope="col">Permissions</th>
						<th scope="col" class="text-center">Status</th>
						<th scope="col">Join Date</th>
						<th scope="col" class="text-center">Action</th>
					</tr>
				</thead>
				<tbody>
					@forelse($users ?? [] as $index => $user)
					<tr>
						<td>{{ $users->firstItem() + $index }}</td>
						<td>
							<div class="d-flex align-items-center">
								@if($user->photo)
								<img src="{{ $user->profile_image_url }}" alt="{{ $user->name }}" class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 overflow-hidden object-fit-cover">
								@else
									<span class="w-40-px h-40-px rounded-circle flex-shrink-0 me-12 bg-primary-100 d-flex justify-content-center align-items-center text-primary-600 fw-semibold">
										{{ strtoupper(substr($user->name, 0, 2)) }}
									</span>
								@endif
								<div class="flex-grow-1">
									<span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->name }}</span>
								</div>
							</div>
						</td>
						<td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->email }}</span></td>
						<td><span class="text-md mb-0 fw-normal text-secondary-light">{{ $user->phone ?? 'N/A' }}</span></td>
						<td>
							<div class="d-flex flex-column gap-1">
																@forelse($user->groupedPermissions() as $moduleLabel => $actionLabels)
									<span class="bg-primary-50 text-primary-600 border border-primary-200 px-8 py-2 radius-4 fw-medium text-xs">{{ $moduleLabel }}@if(!empty($actionLabels)): {{ implode(', ', $actionLabels) }}@endif</span>
								@empty
									<span class="text-secondary-light text-sm">No permissions</span>
								@endforelse
							</div>
						</td>
						<td class="text-center">
							@if($user->status == 'active')
								<span class="bg-success-focus text-success-600 border border-success-main px-24 py-4 radius-4 fw-medium text-sm">Active</span>
							@else
								<span class="bg-neutral-200 text-neutral-600 border border-neutral-400 px-24 py-4 radius-4 fw-medium text-sm">Inactive</span>
							@endif
						</td>
						<td>{{ $user->created_at->format('d M Y') }}</td>
						<td class="text-center">
							<div class="d-flex align-items-center gap-10 justify-content-center">
								<a href="{{ route('admin.platform-users.edit', $user->id) }}" class="bg-success-focus text-success-600 bg-hover-success-200 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle" title="Edit">
									<iconify-icon icon="lucide:edit" class="menu-icon"></iconify-icon>
								</a>
								<form action="{{ route('admin.platform-users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this platform user?');">
									@csrf
									@method('DELETE')
									<button type="submit" class="remove-item-btn bg-danger-focus bg-hover-danger-200 text-danger-600 fw-medium w-40-px h-40-px d-flex justify-content-center align-items-center rounded-circle border-0" title="Delete">
										<iconify-icon icon="fluent:delete-24-regular" class="menu-icon"></iconify-icon>
									</button>
								</form>
							</div>
						</td>
					</tr>
					@empty
					<tr>
						<td colspan="8" class="text-center py-4">
							<div class="text-secondary-light">
								<iconify-icon icon="solar:users-group-two-rounded-outline" class="text-4xl mb-2"></iconify-icon>
								<p class="mb-0">No Platform User found</p>
							</div>
						</td>
					</tr>
					@endforelse
				</tbody>
			</table>
		</div>
		
		@if(isset($users) && $users->hasPages())
		<div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mt-24">
			<span>Showing {{ $users->firstItem() }} to {{ $users->lastItem() }} of {{ $users->total() }} entries</span>
			<ul class="pagination d-flex flex-wrap align-items-center gap-2 justify-content-center">
				{{ $users->links() }}
			</ul>
		</div>
		@endif
	</div>
</div>
@endsection
