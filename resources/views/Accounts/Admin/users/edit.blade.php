@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">{{ isset($user) ? 'Edit Customer' : 'Add New Customer' }}</h6>
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
									<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden form="userForm" name="photo">
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

						<form action="{{ isset($user) ? route('admin.users.update', $user->id) : route('admin.users.store') }}" method="POST" enctype="multipart/form-data" id="userForm">
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

							@if(isset($user))
							<div class="mb-20 p-16 bg-neutral-50 radius-8 border">
								<div class="d-flex align-items-center justify-content-between mb-8">
									<label class="form-label fw-semibold text-primary-light text-sm mb-0">
										Customer ID (CID)
									</label>
									<button type="button" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center" data-bs-toggle="modal" data-bs-target="#changeUserIdModal">
										<iconify-icon icon="mdi:pencil" class="me-1 d-flex"></iconify-icon> Change ID
									</button>
								</div>
								<span class="fw-bold text-primary-600 text-lg">CID-{{ str_pad($user->client_id, 5, '0', STR_PAD_LEFT) }}</span>
								<small class="d-block text-secondary-light mt-4">Current Client ID: <strong>{{ $user->client_id }}</strong></small>
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
								<label for="father_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Father's Name</label>
								<input type="text" class="form-control radius-8 @error('father_name') is-invalid @enderror" id="father_name" name="father_name" placeholder="Enter father's name" value="{{ old('father_name', $user->father_name ?? '') }}">
								@error('father_name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="mother_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Mother's Name</label>
								<input type="text" class="form-control radius-8 @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" placeholder="Enter mother's name" value="{{ old('mother_name', $user->mother_name ?? '') }}">
								@error('mother_name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="nid" class="form-label fw-semibold text-primary-light text-sm mb-8">National ID (NID)</label>
								<input type="text" class="form-control radius-8 @error('nid') is-invalid @enderror" id="nid" name="nid" placeholder="Enter NID number" value="{{ old('nid', $user->nid ?? '') }}">
								@error('nid')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">Address</label>
								<textarea class="form-control radius-8 @error('address') is-invalid @enderror" id="address" name="address" placeholder="Enter address" rows="3">{{ old('address', $user->address ?? '') }}</textarea>
								@error('address')
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
								<label for="created_at" class="form-label fw-semibold text-primary-light text-sm mb-8">Join Date</label>
								<input type="date" class="form-control radius-8 @error('created_at') is-invalid @enderror" id="created_at" name="created_at" value="{{ old('created_at', isset($user) && $user->created_at ? $user->created_at->format('Y-m-d') : date('Y-m-d')) }}">
								@error('created_at')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
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

							<div class="d-flex align-items-center justify-content-center gap-3">
								<a href="{{ route('admin.users.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
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

@if(isset($user))
<!-- Change Customer ID Modal -->
<div class="modal fade" id="changeUserIdModal" tabindex="-1" aria-labelledby="changeUserIdModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content radius-16 overflow-hidden">
            <div class="modal-header bg-danger-600 py-16">
                <h5 class="modal-title text-white" id="changeUserIdModalLabel">
                    <iconify-icon icon="mdi:identifier" class="me-2"></iconify-icon>
                    Change Customer ID
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.users.change-id', $user->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body p-24">
                    <div class="alert alert-danger-600 bg-danger-50 border-danger-200 mb-20">
                        <div class="d-flex align-items-start gap-8">
                            <iconify-icon icon="mdi:alert" class="text-danger-600 flex-shrink-0" style="font-size: 20px; margin-top: 2px;"></iconify-icon>
                            <div class="text-sm">
                                <strong>Warning:</strong> Changing the Customer ID will update all linked bookings and agent payments. This action cannot be undone easily. Make sure the new ID is not already in use.
                            </div>
                        </div>
                    </div>
                    <div class="mb-20">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">Current ID</label>
                        <input type="text" class="form-control radius-8 bg-neutral-100" value="CID-{{ str_pad($user->client_id, 5, '0', STR_PAD_LEFT) }} ({{ $user->client_id }})" readonly>
                    </div>
                    <div class="mb-0">
                        <label class="form-label fw-semibold text-primary-light text-sm mb-8">
                            New ID <span class="text-danger-600">*</span>
                        </label>
                        <input type="number" class="form-control radius-8" name="new_id"
                            placeholder="Enter new numeric ID (e.g. 150)"
                            min="1" max="999999" required>
                        <small class="text-secondary-light d-block mt-8">Must be a unique positive integer not already used by another customer.</small>
                    </div>
                </div>
                <div class="modal-footer gap-3">
                    <button type="button" class="btn btn-outline-secondary px-20 py-10 radius-8" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger px-20 py-10 radius-8 d-inline-flex align-items-center"
                        onclick="return confirm('Are you sure you want to change this customer\'s ID? This will update all related records.')">
                        <iconify-icon icon="mdi:check" class="me-1 d-flex"></iconify-icon> Change ID
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif
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
</script>
@endpush
