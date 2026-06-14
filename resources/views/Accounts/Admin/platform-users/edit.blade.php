@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">{{ isset($user) ? 'Edit Platform User' : 'Add New Platform User' }}</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
		<li>-</li>
		<li class="fw-medium">
			<a href="{{ route('admin.platform-users.index') }}" class="hover-text-primary">Platform Users</a>
		</li>
		<li>-</li>
		<li class="fw-medium">{{ isset($user) ? 'Edit' : 'Add New' }}</li>
	</ul>
</div>

<div class="card h-100 p-0 radius-12">
	<div class="card-body p-24">
		<div class="row justify-content-center">
			<div class="col-xxl-6 col-xl-8 col-lg-10">
				<div class="card border">
					<div class="card-body">
						<h6 class="text-md text-primary-light mb-16">Profile Image</h6>

						<!-- Upload Image Start -->
						<div class="mb-24 mt-16">
							<div class="avatar-upload">
								<div class="avatar-edit position-absolute bottom-0 end-0 me-24 mt-16 z-1 cursor-pointer">
									<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden form="platformUserForm" name="photo">
									<label for="imageUpload" class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
										<iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
									</label>
								</div>
								<div class="avatar-preview">
									<div id="imagePreview" 
										@if(isset($user) && $user->photo)
										style="background-image: url('{{ $user->profile_image_url }}');"
										@endif
									></div>
								</div>
							</div>
						</div>
						<!-- Upload Image End -->

						<form action="{{ isset($user) ? route('admin.platform-users.update', $user->id) : route('admin.platform-users.store') }}" method="POST" enctype="multipart/form-data" id="platformUserForm">
							@csrf
							@if(isset($user))
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

							<div class="mb-20">
								<label for="name" class="form-label fw-semibold text-primary-light text-sm mb-8">Full Name <span class="text-danger-600">*</span></label>
								<input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Full Name" value="{{ old('name', $user->name ?? '') }}" required>
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
								<input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email address" value="{{ old('email', $user->email ?? '') }}" required>
								@error('email')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone</label>
								<input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone', $user->phone ?? '') }}">
								@error('phone')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">
									Password 
									@if(!isset($user))
										<span class="text-danger-600">*</span>
									@else
										<small class="text-secondary-light">(Leave blank to keep current)</small>
									@endif
								</label>
								<input type="password" class="form-control radius-8 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password" {{ !isset($user) ? 'required' : '' }}>
								@error('password')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="password_confirmation" class="form-label fw-semibold text-primary-light text-sm mb-8">
									Confirm Password
									@if(!isset($user))
										<span class="text-danger-600">*</span>
									@endif
								</label>
								<input type="password" class="form-control radius-8" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" {{ !isset($user) ? 'required' : '' }}>
							</div>

							<div class="mb-20">
								<label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">Status <span class="text-danger-600">*</span></label>
								<select class="form-control radius-8 form-select @error('status') is-invalid @enderror" id="status" name="status" required>
									<option value="active" {{ old('status', $user->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
									<option value="inactive" {{ old('status', $user->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
								</select>
								@error('status')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<!-- Permissions -->
							<div class="mb-20">
								<label class="form-label fw-semibold text-primary-light text-sm mb-12">Role Permissions</label>
								@php $userPerms = old('permissions', isset($user) ? ($user->permissions ?? []) : []); @endphp
								<div class="border radius-8 overflow-hidden">
									<div class="table-responsive">
										<table class="table table-borderless permissions-table mb-0">
											<thead>
												<tr class="bg-base">
													<th class="text-sm fw-semibold text-primary-light ps-16">Module</th>
													@foreach($actions as $actionKey => $actionLabel)
													<th class="text-sm fw-semibold text-primary-light text-center">
														<div class="form-check d-flex flex-column align-items-center gap-1 m-0">
															<input class="form-check-input perm-col-all" type="checkbox" data-action="{{ $actionKey }}" id="col_{{ $actionKey }}">
															<label class="form-check-label text-xs" for="col_{{ $actionKey }}">{{ $actionLabel }}</label>
														</div>
													</th>
													@endforeach
												</tr>
											</thead>
											<tbody>
												@foreach($permissions as $moduleKey => $moduleLabel)
												<tr class="border-top">
													<td class="ps-16">
														<div class="form-check d-flex align-items-center gap-8 m-0">
															<input class="form-check-input perm-row-all flex-shrink-0" type="checkbox" data-module="{{ $moduleKey }}" id="row_{{ $moduleKey }}">
															<label class="form-check-label fw-medium text-secondary-light text-sm" for="row_{{ $moduleKey }}">
																{{ \Illuminate\Support\Str::after($moduleLabel, 'Manage ') }}
															</label>
														</div>
													</td>
													@foreach($actions as $actionKey => $actionLabel)
													@php $permValue = $moduleKey . '.' . $actionKey; @endphp
													<td class="text-center">
														<input class="form-check-input perm-check"
															type="checkbox"
															name="permissions[]"
															value="{{ $permValue }}"
															data-module="{{ $moduleKey }}"
															data-action="{{ $actionKey }}"
															aria-label="{{ $moduleLabel }} {{ $actionLabel }}"
															{{ in_array($permValue, $userPerms) || in_array($moduleKey, $userPerms) ? 'checked' : '' }}>
													</td>
													@endforeach
												</tr>
												@endforeach
											</tbody>
											<tfoot>
												<tr class="border-top bg-base">
													<td class="ps-16" colspan="{{ count($actions) + 1 }}">
														<div class="form-check d-flex align-items-center gap-8 m-0">
															<input class="form-check-input flex-shrink-0" type="checkbox" id="selectAll">
															<label class="form-check-label fw-semibold text-primary-600 text-sm" for="selectAll">
																Select All Permissions
															</label>
														</div>
													</td>
												</tr>
											</tfoot>
										</table>
									</div>
								</div>
							</div>

							<div class="d-flex align-items-center justify-content-center gap-3">
								<a href="{{ route('admin.platform-users.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
									Cancel
								</a>
								<button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
									{{ isset($user) ? 'Update' : 'Save' }}
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection

@push('styles')
<style>
	.avatar-upload {
		position: relative;
		max-width: 205px;
		margin: 0 auto;
	}
	.avatar-upload .avatar-preview {
		width: 192px;
		height: 192px;
		position: relative;
		border-radius: 100%;
		border: 6px solid #F8F8F8;
		box-shadow: 0px 2px 4px 0px rgba(0, 0, 0, 0.1);
	}
	.avatar-upload .avatar-preview > div {
		width: 100%;
		height: 100%;
		border-radius: 100%;
		background-size: cover;
		background-repeat: no-repeat;
		background-position: center;
		background-color: #f0f0f0;
		background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='80' height='80' viewBox='0 0 24 24'%3E%3Cpath fill='%23ccc' d='M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'/%3E%3C/svg%3E");
	}
	.permissions-table th,
	.permissions-table td {
		padding: 12px 8px;
		vertical-align: middle;
	}
	.permissions-table tbody tr:hover {
		background-color: var(--primary-50, #f4f6ff);
	}
	.permissions-table .form-check-input {
		cursor: pointer;
		margin: 0;
	}
	.permissions-table .perm-check {
		width: 18px;
		height: 18px;
	}
</style>
@endpush

@push('scripts')
<script>
	// Image Upload Preview
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#imagePreview').css('background-image', 'url(' + e.target.result + ')');
				$('#imagePreview').hide();
				$('#imagePreview').fadeIn(650);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}
	$("#imageUpload").change(function() {
		readURL(this);
	});

	// ===== Permissions matrix (View / Add / Edit / Delete) =====
	var $perm = $('.perm-check');

	function syncState() {
		// Per-row module state: checked while at least one action is selected,
		// unchecked only when every action of the module is cleared. The
		// indeterminate dash signals a partial selection.
		$('.perm-row-all').each(function() {
			var module = $(this).data('module');
			var $cells = $perm.filter('[data-module="' + module + '"]');
			var checked = $cells.filter(':checked').length;
			$(this).prop('checked', checked > 0);
			this.indeterminate = checked > 0 && checked < $cells.length;
		});
		// Per-column "all modules" state
		$('.perm-col-all').each(function() {
			var action = $(this).data('action');
			var $cells = $perm.filter('[data-action="' + action + '"]');
			$(this).prop('checked', $cells.length === $cells.filter(':checked').length);
		});
		// Master state
		$('#selectAll').prop('checked', $perm.length === $perm.filter(':checked').length);
	}

	// Toggle a whole row (module)
	$('.perm-row-all').change(function() {
		var module = $(this).data('module');
		$perm.filter('[data-module="' + module + '"]').prop('checked', this.checked);
		syncState();
	});

	// Toggle a whole column (action)
	$('.perm-col-all').change(function() {
		var action = $(this).data('action');
		$perm.filter('[data-action="' + action + '"]').prop('checked', this.checked);
		syncState();
	});

	// Master toggle
	$('#selectAll').change(function() {
		$perm.prop('checked', this.checked);
		syncState();
	});

	// Any individual checkbox
	$perm.change(syncState);

	// Init
	syncState();
</script>
@endpush
