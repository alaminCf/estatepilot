@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">New Commission Payout</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
		<li>-</li>
		<li class="fw-medium">
			<a href="{{ route('admin.commission-payouts.index') }}" class="hover-text-primary">Commission Payouts</a>
		</li>
		<li>-</li>
		<li class="fw-medium">New Payout</li>
	</ul>
</div>

<div class="row justify-content-center">
	<div class="col-xxl-7 col-xl-9 col-lg-11">
		<div class="card radius-12">
			<div class="card-body p-24">
				@if ($errors->any())
					<div class="alert alert-danger mb-20">
						<ul class="mb-0">
							@foreach ($errors->all() as $error)
								<li>{{ $error }}</li>
							@endforeach
						</ul>
					</div>
				@endif

				<form action="{{ route('admin.commission-payouts.store') }}" method="POST" id="payoutForm">
					@csrf

					<div class="mb-20">
						<label for="user_id" class="form-label fw-semibold text-primary-light text-sm mb-8">Commission User <span class="text-danger-600">*</span></label>
						<select class="form-control radius-8 form-select @error('user_id') is-invalid @enderror" id="user_id" name="user_id" required>
							<option value="">Select commission user...</option>
							@foreach($commissionUsers as $cu)
								<option value="{{ $cu->id }}" {{ old('user_id', $selectedUserId) == $cu->id ? 'selected' : '' }}>
									{{ $cu->name }}{{ $cu->commission_type ? ' — ' . $cu->commissionTypeLabel() : '' }} ({{ $cu->referral_code }})
								</option>
							@endforeach
						</select>
						@error('user_id')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
					</div>

					{{-- Balance breakdown (AJAX) --}}
					<div class="border radius-8 p-16 mb-20 bg-neutral-50" id="balanceCard" style="display:none;">
						<h6 class="text-sm text-primary-light mb-12 d-flex align-items-center gap-2">
							<iconify-icon icon="mdi:scale-balance"></iconify-icon>
							Balance Breakdown
						</h6>
						<div class="table-responsive">
							<table class="table table-sm mb-0">
								<tbody>
									<tr><td class="text-secondary-light">Earned from own sales</td><td class="text-end fw-medium" id="bOwn">—</td></tr>
									<tr><td class="text-secondary-light">Earned from downline overrides</td><td class="text-end fw-medium" id="bOverride">—</td></tr>
									<tr id="bLegacyRow" style="display:none;"><td class="text-secondary-light">Legacy commission (old bookings)</td><td class="text-end fw-medium" id="bLegacy">—</td></tr>
									<tr class="border-top"><td class="fw-semibold">Total earned</td><td class="text-end fw-semibold" id="bEarned">—</td></tr>
									<tr><td class="text-secondary-light">Already paid out</td><td class="text-end fw-medium text-danger-600" id="bPaid">—</td></tr>
									<tr class="border-top"><td class="fw-bold">Balance due</td><td class="text-end fw-bold text-success-600" id="bBalance">—</td></tr>
								</tbody>
							</table>
						</div>
					</div>

					<div class="mb-20">
						<label for="amount" class="form-label fw-semibold text-primary-light text-sm mb-8">Payout Amount (৳) <span class="text-danger-600">*</span></label>
						<input type="number" step="0.01" min="0.01" class="form-control radius-8 @error('amount') is-invalid @enderror" id="amount" name="amount" placeholder="Enter amount" value="{{ old('amount') }}" required>
						@error('amount')
							<div class="invalid-feedback">{{ $message }}</div>
						@enderror
						<small class="text-secondary-light mt-1 d-block" id="amountHint"></small>
					</div>

					<div class="mb-20">
						<label for="payment_note" class="form-label fw-semibold text-primary-light text-sm mb-8">Note</label>
						<textarea class="form-control radius-8" id="payment_note" name="payment_note" rows="3" placeholder="Optional note (e.g. bank transfer reference)">{{ old('payment_note') }}</textarea>
					</div>

					<div class="d-flex align-items-center justify-content-center gap-3">
						<a href="{{ route('admin.commission-payouts.index') }}" class="border border-danger-600 bg-hover-danger-200 text-danger-600 text-md px-56 py-11 radius-8">
							Cancel
						</a>
						<button type="submit" class="btn btn-primary border border-primary-600 text-md px-56 py-12 radius-8">
							Record Payout
						</button>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
@endsection

@push('scripts')
<script>
	function formatAmount(value) {
		return '৳' + parseFloat(value).toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
	}

	function loadBalance(userId) {
		if (!userId) {
			$('#balanceCard').hide();
			$('#amountHint').text('');
			return;
		}

		$.get('{{ url('admin/commission-payouts/balance') }}/' + userId, function(data) {
			$('#bOwn').text(formatAmount(data.earnings.own));
			$('#bOverride').text(formatAmount(data.earnings.override));
			if (data.legacy > 0) {
				$('#bLegacy').text(formatAmount(data.legacy));
				$('#bLegacyRow').show();
			} else {
				$('#bLegacyRow').hide();
			}
			$('#bEarned').text(formatAmount(data.total_earned));
			$('#bPaid').text(formatAmount(data.total_paid));
			$('#bBalance').text(formatAmount(data.balance));
			$('#balanceCard').show();
			$('#amount').attr('max', data.balance);
			$('#amountHint').text('Maximum payable: ' + formatAmount(data.balance));
		});
	}

	$('#user_id').on('change', function() {
		loadBalance($(this).val());
	});

	// Initial load when arriving with a preselected user
	if ($('#user_id').val()) {
		loadBalance($('#user_id').val());
	}
</script>
@endpush
