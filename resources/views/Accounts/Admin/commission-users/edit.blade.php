@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">{{ isset($commissionUser) ? 'Edit Commission User' : 'Add Commission User' }}</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
		<li>-</li>
		<li class="fw-medium">
			<a href="{{ route('admin.commission-users.index') }}" class="hover-text-primary">Commission Users</a>
		</li>
		<li>-</li>
		<li class="fw-medium">{{ isset($commissionUser) ? 'Edit' : 'Add New' }}</li>
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
									<input type='file' id="imageUpload" accept=".png, .jpg, .jpeg" hidden form="commissionUserForm" name="photo">
									<label for="imageUpload" class="w-32-px h-32-px d-flex justify-content-center align-items-center bg-primary-50 text-primary-600 border border-primary-600 bg-hover-primary-100 text-lg rounded-circle">
										<iconify-icon icon="solar:camera-outline" class="icon"></iconify-icon>
									</label>
								</div>
								<div class="avatar-preview">
									<div id="imagePreview"
										@if(isset($commissionUser) && $commissionUser->photo)
										style="background-image: url('{{ $commissionUser->profile_image_url }}');"
										@endif
									></div>
								</div>
							</div>
						</div>
						<!-- Upload Image End -->

						<form action="{{ isset($commissionUser) ? route('admin.commission-users.update', $commissionUser->id) : route('admin.commission-users.store') }}" method="POST" enctype="multipart/form-data" id="commissionUserForm">
							@csrf
							@if(isset($commissionUser))
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
								<input type="text" class="form-control radius-8 @error('name') is-invalid @enderror" id="name" name="name" placeholder="Enter Full Name" value="{{ old('name', $commissionUser->name ?? '') }}" required>
								@error('name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="email" class="form-label fw-semibold text-primary-light text-sm mb-8">Email <span class="text-danger-600">*</span></label>
								<input type="email" class="form-control radius-8 @error('email') is-invalid @enderror" id="email" name="email" placeholder="Enter email address" value="{{ old('email', $commissionUser->email ?? '') }}" required>
								@error('email')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="phone" class="form-label fw-semibold text-primary-light text-sm mb-8">Phone <span class="text-danger-600">*</span></label>
								<input type="text" class="form-control radius-8 @error('phone') is-invalid @enderror" id="phone" name="phone" placeholder="Enter phone number" value="{{ old('phone', $commissionUser->phone ?? '') }}" required>
								@error('phone')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="father_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Father's Name</label>
								<input type="text" class="form-control radius-8 @error('father_name') is-invalid @enderror" id="father_name" name="father_name" placeholder="Enter father's name" value="{{ old('father_name', $commissionUser->father_name ?? '') }}">
								@error('father_name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="mother_name" class="form-label fw-semibold text-primary-light text-sm mb-8">Mother's Name</label>
								<input type="text" class="form-control radius-8 @error('mother_name') is-invalid @enderror" id="mother_name" name="mother_name" placeholder="Enter mother's name" value="{{ old('mother_name', $commissionUser->mother_name ?? '') }}">
								@error('mother_name')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="nid" class="form-label fw-semibold text-primary-light text-sm mb-8">National ID (NID)</label>
								<input type="text" class="form-control radius-8 @error('nid') is-invalid @enderror" id="nid" name="nid" placeholder="Enter NID number" value="{{ old('nid', $commissionUser->nid ?? '') }}">
								@error('nid')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="address" class="form-label fw-semibold text-primary-light text-sm mb-8">Address</label>
								<textarea class="form-control radius-8 @error('address') is-invalid @enderror" id="address" name="address" placeholder="Enter address" rows="3">{{ old('address', $commissionUser->address ?? '') }}</textarea>
								@error('address')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							{{-- ===== Commission Hierarchy ===== --}}
							<div class="border radius-8 p-16 mb-20 bg-neutral-50">
								<h6 class="text-md text-primary-light mb-16 d-flex align-items-center gap-2">
									<iconify-icon icon="mdi:file-tree"></iconify-icon>
									Commission Hierarchy
								</h6>

								<div class="mb-20">
									<label for="commission_type" class="form-label fw-semibold text-primary-light text-sm mb-8">Commission Type <span class="text-danger-600">*</span></label>
									<select class="form-control radius-8 form-select @error('commission_type') is-invalid @enderror" id="commission_type" name="commission_type" required>
										<option value="">Select type...</option>
										@foreach(config('commission.types') as $typeKey => $type)
											<option value="{{ $typeKey }}" {{ old('commission_type', $commissionUser->commission_type ?? '') == $typeKey ? 'selected' : '' }}>{{ $type['label'] }}</option>
										@endforeach
									</select>
									@error('commission_type')
										<div class="invalid-feedback">{{ $message }}</div>
									@enderror
								</div>

								{{-- Cascading upline selects: one per upline level, shown per chosen type --}}
								@foreach(['ed', 'gm', 'agm', 'manager'] as $uplineType)
								<div class="mb-20 upline-select-wrapper" data-type="{{ $uplineType }}" style="display:none;">
									<label class="form-label fw-semibold text-primary-light text-sm mb-8">{{ config("commission.types.{$uplineType}.label") }} <span class="text-danger-600">*</span></label>
									<select class="form-control radius-8 form-select upline-select" data-type="{{ $uplineType }}">
										<option value="">Select {{ config("commission.types.{$uplineType}.label") }}...</option>
									</select>
								</div>
								@endforeach
								<input type="hidden" name="parent_id" id="parent_id" value="{{ old('parent_id', $commissionUser->parent_id ?? '') }}">
								@error('parent_id')
									<div class="text-danger-600 text-sm mb-20">{{ $message }}</div>
								@enderror

								<div class="alert alert-warning py-8 px-12 text-sm mb-20" id="poolWarning" style="display:none;">
									<iconify-icon icon="mdi:alert" class="me-1"></iconify-icon>
									<span id="poolWarningText"></span>
								</div>

								<h6 class="text-sm text-primary-light mb-12">Commission Percentages <small class="text-secondary-light fw-normal">(defaults from the commission chart — adjust if needed)</small></h6>
								<div class="row g-3">
									<div class="col-md-4">
										<label for="booking_pct" class="form-label fw-semibold text-primary-light text-sm mb-8">Booking % <span class="text-danger-600">*</span></label>
										<input type="number" step="0.01" min="0" max="100" class="form-control radius-8 pct-input @error('booking_pct') is-invalid @enderror" id="booking_pct" name="booking_pct" value="{{ old('booking_pct', $commissionUser->booking_pct ?? '') }}" required>
										@error('booking_pct')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="col-md-4">
										<label for="down_pct" class="form-label fw-semibold text-primary-light text-sm mb-8">Down % <span class="text-danger-600">*</span></label>
										<input type="number" step="0.01" min="0" max="100" class="form-control radius-8 pct-input @error('down_pct') is-invalid @enderror" id="down_pct" name="down_pct" value="{{ old('down_pct', $commissionUser->down_pct ?? '') }}" required>
										@error('down_pct')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
									<div class="col-md-4">
										<label for="instalment_pct" class="form-label fw-semibold text-primary-light text-sm mb-8">Instalment % <span class="text-danger-600">*</span></label>
										<input type="number" step="0.01" min="0" max="100" class="form-control radius-8 pct-input @error('instalment_pct') is-invalid @enderror" id="instalment_pct" name="instalment_pct" value="{{ old('instalment_pct', $commissionUser->instalment_pct ?? '') }}" required>
										@error('instalment_pct')
											<div class="invalid-feedback">{{ $message }}</div>
										@enderror
									</div>
								</div>
							</div>
							{{-- ===== /Commission Hierarchy ===== --}}

							<div class="mb-20">
								<label for="referral_code" class="form-label fw-semibold text-primary-light text-sm mb-8">Referral Code @if(isset($commissionUser))<span class="text-danger-600">*</span>@endif</label>
								<input type="text" class="form-control radius-8 @error('referral_code') is-invalid @enderror" id="referral_code" name="referral_code" placeholder="Leave blank to auto-generate" value="{{ old('referral_code', $commissionUser->referral_code ?? '') }}" {{ isset($commissionUser) ? 'required' : '' }}>
								@error('referral_code')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
								@if(!isset($commissionUser))
									<small class="text-secondary-light">If left blank, a unique code will be auto-generated</small>
								@endif
							</div>

							<div class="mb-20">
								<label for="password" class="form-label fw-semibold text-primary-light text-sm mb-8">
									Password
									@if(!isset($commissionUser))
										<span class="text-danger-600">*</span>
									@else
										<small class="text-secondary-light">(Leave blank to keep current)</small>
									@endif
								</label>
								<input type="password" class="form-control radius-8 @error('password') is-invalid @enderror" id="password" name="password" placeholder="Enter password" {{ !isset($commissionUser) ? 'required' : '' }}>
								@error('password')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="mb-20">
								<label for="password_confirmation" class="form-label fw-semibold text-primary-light text-sm mb-8">
									Confirm Password
									@if(!isset($commissionUser))
										<span class="text-danger-600">*</span>
									@endif
								</label>
								<input type="password" class="form-control radius-8" id="password_confirmation" name="password_confirmation" placeholder="Confirm password" {{ !isset($commissionUser) ? 'required' : '' }}>
							</div>

							<div class="mb-20">
								<label for="status" class="form-label fw-semibold text-primary-light text-sm mb-8">Status <span class="text-danger-600">*</span></label>
								<select class="form-control radius-8 form-select @error('status') is-invalid @enderror" id="status" name="status" required>
									<option value="active" {{ old('status', $commissionUser->status ?? 'active') == 'active' ? 'selected' : '' }}>Active</option>
									<option value="inactive" {{ old('status', $commissionUser->status ?? '') == 'inactive' ? 'selected' : '' }}>Inactive</option>
								</select>
								@error('status')
									<div class="invalid-feedback">{{ $message }}</div>
								@enderror
							</div>

							<div class="d-flex align-items-center justify-content-center gap-3">
								<a href="{{ route('admin.commission-users.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
									Cancel
								</a>
								<button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
									{{ isset($commissionUser) ? 'Update' : 'Save' }}
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

	// ===== Commission hierarchy cascading selects =====
	var HIERARCHY = @json($hierarchy);
	var TYPES = @json(config('commission.types'));
	var POOLS = @json(config('commission.pools'));
	var UPLINE_ORDER = ['ed', 'gm', 'agm', 'manager'];
	var INITIAL_PARENT_ID = $('#parent_id').val() ? parseInt($('#parent_id').val(), 10) : null;

	var byId = {};
	HIERARCHY.forEach(function(u) { byId[u.id] = u; });

	// Pre-computed ancestor path for edit / validation-redisplay: { ed: id, gm: id, ... }
	var initialPath = {};
	(function() {
		var current = INITIAL_PARENT_ID ? byId[INITIAL_PARENT_ID] : null;
		while (current) {
			initialPath[current.commission_type] = current.id;
			current = current.parent_id ? byId[current.parent_id] : null;
		}
	})();

	// Upline types required for a given commission type, top → bottom
	function uplineTypesFor(type) {
		var chain = [];
		var parentType = TYPES[type] ? TYPES[type].parent : null;
		while (parentType) {
			chain.unshift(parentType);
			parentType = TYPES[parentType].parent;
		}
		return chain;
	}

	function populateSelect(type, parentId, selectedId) {
		var $select = $('.upline-select[data-type="' + type + '"]');
		var label = TYPES[type].label;
		$select.empty().append('<option value="">Select ' + label + '...</option>');

		HIERARCHY.filter(function(u) {
			if (u.commission_type !== type) return false;
			// Top level lists everyone of that type; deeper levels filter by the chosen upline
			return parentId === null || u.parent_id === parentId;
		}).forEach(function(u) {
			var sel = (selectedId && u.id === selectedId) ? ' selected' : '';
			$select.append('<option value="' + u.id + '"' + sel + '>' + $('<div>').text(u.name).html() + ' (' + (u.referral_code || '') + ')</option>');
		});
	}

	function syncParentId() {
		var type = $('#commission_type').val();
		var chain = type ? uplineTypesFor(type) : [];
		if (!chain.length) {
			$('#parent_id').val('');
			return;
		}
		var deepest = chain[chain.length - 1];
		$('#parent_id').val($('.upline-select[data-type="' + deepest + '"]').val() || '');
	}

	function updatePoolWarning() {
		// Sum the selected chain's overrides per pool and warn when they exceed the pool
		var warnings = [];
		var type = $('#commission_type').val();
		if (type) {
			var chainIds = uplineTypesFor(type).map(function(t) {
				return parseInt($('.upline-select[data-type="' + t + '"]').val() || 0, 10);
			}).filter(Boolean);

			['booking', 'down', 'instalment'].forEach(function(pool) {
				var pctColumn = pool + '_pct';
				var total = 0;
				chainIds.forEach(function(id) {
					var u = byId[id];
					if (!u) return;
					var pct = u[pctColumn] !== null ? parseFloat(u[pctColumn]) : parseFloat(TYPES[u.commission_type].defaults[pool]);
					total += pct;
				});
				if (total > POOLS[pool]) {
					warnings.push(pool + ' pool: upline overrides total ' + total + '% but the pool is only ' + POOLS[pool] + '%');
				}
			});
		}
		if (warnings.length) {
			$('#poolWarningText').text('This chain over-allocates: ' + warnings.join('; ') + '. The seller share will be clamped to 0%.');
			$('#poolWarning').show();
		} else {
			$('#poolWarning').hide();
		}
	}

	function rebuildCascade(useInitialPath) {
		var type = $('#commission_type').val();
		var chain = type ? uplineTypesFor(type) : [];

		$('.upline-select-wrapper').hide();

		var parentId = null;
		chain.forEach(function(uplineType) {
			$('.upline-select-wrapper[data-type="' + uplineType + '"]').show();
			var selectedId = useInitialPath ? (initialPath[uplineType] || null) : null;
			populateSelect(uplineType, parentId, selectedId);
			parentId = parseInt($('.upline-select[data-type="' + uplineType + '"]').val() || 0, 10) || null;
		});

		syncParentId();
		updatePoolWarning();
	}

	$('#commission_type').on('change', function() {
		rebuildCascade(false);

		// Pre-fill chart defaults for the chosen type (admin may adjust)
		var type = $(this).val();
		if (type && TYPES[type]) {
			$('#booking_pct').val(TYPES[type].defaults.booking);
			$('#down_pct').val(TYPES[type].defaults.down);
			$('#instalment_pct').val(TYPES[type].defaults.instalment);
		}
	});

	$(document).on('change', '.upline-select', function() {
		var changedType = $(this).data('type');
		var type = $('#commission_type').val();
		var chain = uplineTypesFor(type);
		var idx = chain.indexOf(changedType);

		// Re-filter every select below the one that changed
		var parentId = parseInt($(this).val() || 0, 10) || null;
		for (var i = idx + 1; i < chain.length; i++) {
			populateSelect(chain[i], parentId, null);
			parentId = null; // descendants reset, nothing selected below
		}

		syncParentId();
		updatePoolWarning();
	});

	// Initial render (edit form or validation redisplay restores the saved chain)
	rebuildCascade(true);
</script>
@endpush
