@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">Commission User Details</h6>
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
		<li class="fw-medium">{{ $commissionUser->name }}</li>
	</ul>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show mb-24" role="alert">
	{{ session('success') }}
	<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row gy-4">
	{{-- Left: Profile --}}
	<div class="col-lg-4">
		<div class="card radius-12 overflow-hidden mb-24">
			<div class="card-body text-center p-24" style="background: linear-gradient(135deg, #22c55e 0%, #16a34a 100%);">
				@if($commissionUser->photo)
					<img src="{{ $commissionUser->profile_image_url }}" alt="{{ $commissionUser->name }}" class="w-80-px h-80-px rounded-circle object-fit-cover border border-white border-width-2-px mb-12">
				@else
					<span class="w-80-px h-80-px rounded-circle bg-white text-success-600 d-inline-flex justify-content-center align-items-center fw-bold text-2xl mb-12">
						{{ strtoupper(substr($commissionUser->name, 0, 2)) }}
					</span>
				@endif
				<h5 class="text-white mb-4">{{ $commissionUser->name }}</h5>
				<div class="d-flex justify-content-center gap-2 flex-wrap">
					@if($commissionUser->commission_type)
						<span class="badge bg-white text-success-600">{{ $commissionUser->commissionTypeLabel() }}</span>
					@else
						<span class="badge bg-white text-neutral-600">Unassigned</span>
					@endif
					<span class="badge {{ $commissionUser->status == 'active' ? 'bg-success-200 text-success-800' : 'bg-neutral-300 text-neutral-700' }}">{{ ucfirst($commissionUser->status) }}</span>
				</div>
			</div>
			<div class="card-body p-24">
				<div class="d-flex flex-column gap-12">
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Referral Code:</span>
						<span class="fw-bold text-primary-600">{{ $commissionUser->referral_code ?? 'N/A' }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Email:</span>
						<span class="fw-medium">{{ $commissionUser->email }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Phone:</span>
						<span class="fw-medium">{{ $commissionUser->phone ?? 'N/A' }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">NID:</span>
						<span class="fw-medium">{{ $commissionUser->nid ?? 'N/A' }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Joined:</span>
						<span class="fw-medium">{{ $commissionUser->created_at->format('d M, Y') }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Booking %:</span>
						<span class="fw-medium">{{ $commissionUser->booking_pct !== null ? rtrim(rtrim(number_format($commissionUser->booking_pct, 2), '0'), '.') . '%' : '—' }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Down %:</span>
						<span class="fw-medium">{{ $commissionUser->down_pct !== null ? rtrim(rtrim(number_format($commissionUser->down_pct, 2), '0'), '.') . '%' : '—' }}</span>
					</div>
					<div class="d-flex justify-content-between">
						<span class="text-secondary-light">Instalment %:</span>
						<span class="fw-medium">{{ $commissionUser->instalment_pct !== null ? rtrim(rtrim(number_format($commissionUser->instalment_pct, 2), '0'), '.') . '%' : '—' }}</span>
					</div>
				</div>
				<div class="mt-16 pt-16 border-top">
					<a href="{{ route('admin.commission-users.edit', $commissionUser->id) }}" class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center gap-2">
						<iconify-icon icon="lucide:edit"></iconify-icon>
						Edit Commission User
					</a>
				</div>
			</div>
		</div>

		{{-- Upline chain --}}
		<div class="card radius-12 mb-24">
			<div class="card-header py-16 px-24 bg-base">
				<h6 class="mb-0 d-flex align-items-center gap-2">
					<iconify-icon icon="mdi:file-tree" class="text-primary-600"></iconify-icon>
					Upline Chain
				</h6>
			</div>
			<div class="card-body p-24">
				@if(count($chain))
					<div class="d-flex flex-column gap-8">
						@foreach(array_reverse($chain) as $upline)
							<div class="d-flex align-items-center gap-8">
								<span class="badge bg-primary-50 text-primary-600">{{ $upline->commissionTypeLabel() ?? '—' }}</span>
								<a href="{{ route('admin.commission-users.show', $upline->id) }}" class="fw-medium hover-text-primary">{{ $upline->name }}</a>
							</div>
							<div class="text-secondary-light ps-8"><iconify-icon icon="mdi:arrow-down"></iconify-icon></div>
						@endforeach
						<div class="d-flex align-items-center gap-8">
							<span class="badge bg-success-focus text-success-600">{{ $commissionUser->commissionTypeLabel() ?? 'Unassigned' }}</span>
							<span class="fw-bold">{{ $commissionUser->name }}</span>
						</div>
					</div>
				@else
					<p class="text-secondary-light mb-0">{{ $commissionUser->commission_type === 'ed' ? 'Top of the hierarchy (E.D).' : 'No upline assigned.' }}</p>
				@endif
			</div>
		</div>

		{{-- Direct downline --}}
		<div class="card radius-12">
			<div class="card-header py-16 px-24 bg-base">
				<h6 class="mb-0 d-flex align-items-center gap-2">
					<iconify-icon icon="mdi:account-group" class="text-primary-600"></iconify-icon>
					Direct Downline ({{ $downline->count() }})
				</h6>
			</div>
			<div class="card-body p-0">
				@forelse($downline as $member)
					<div class="d-flex align-items-center justify-content-between px-24 py-12 border-bottom">
						<div>
							<a href="{{ route('admin.commission-users.show', $member->id) }}" class="fw-medium hover-text-primary d-block">{{ $member->name }}</a>
							<small class="text-secondary-light">{{ $member->commissionTypeLabel() }} | {{ $member->referral_code }}</small>
						</div>
						<span class="badge bg-info-focus text-info-600">{{ $member->referred_bookings_count }} sales</span>
					</div>
				@empty
					<p class="text-secondary-light text-center py-24 mb-0">No downline members</p>
				@endforelse
			</div>
		</div>
	</div>

	{{-- Right: Stats + tables --}}
	<div class="col-lg-8">
		{{-- Stat cards --}}
		<div class="row g-3 mb-24">
			<div class="col-sm-6 col-xl-3">
				<div class="card radius-12 h-100 p-16 text-center">
					<span class="text-secondary-light text-sm d-block mb-4">Own Sales</span>
					<span class="fw-bold text-xl text-primary-600">{{ $bookings->count() }}</span>
					<small class="text-secondary-light d-block">{{ $customers->count() }} customers</small>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="card radius-12 h-100 p-16 text-center">
					<span class="text-secondary-light text-sm d-block mb-4">Earned (Own Sales)</span>
					<span class="fw-bold text-xl text-success-600">৳{{ format_bd_number($earningsSummary['own'], 2) }}</span>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="card radius-12 h-100 p-16 text-center">
					<span class="text-secondary-light text-sm d-block mb-4">Earned (Overrides)</span>
					<span class="fw-bold text-xl text-info-600">৳{{ format_bd_number($earningsSummary['override'], 2) }}</span>
				</div>
			</div>
			<div class="col-sm-6 col-xl-3">
				<div class="card radius-12 h-100 p-16 text-center">
					<span class="text-secondary-light text-sm d-block mb-4">Balance Due</span>
					<span class="fw-bold text-xl text-danger-600">৳{{ format_bd_number($balance, 2) }}</span>
					<small class="text-secondary-light d-block">Paid: ৳{{ format_bd_number($totalPaid, 2) }}</small>
				</div>
			</div>
		</div>

		{{-- Earnings by pool --}}
		<div class="card radius-12 mb-24">
			<div class="card-header py-16 px-24 bg-base d-flex align-items-center justify-content-between">
				<h6 class="mb-0 d-flex align-items-center gap-2">
					<iconify-icon icon="mdi:chart-pie" class="text-primary-600"></iconify-icon>
					Earnings Breakdown
				</h6>
				@if($legacyCommission > 0)
					<span class="badge bg-warning-focus text-warning-600">Legacy commission: ৳{{ format_bd_number($legacyCommission, 2) }}</span>
				@endif
			</div>
			<div class="card-body p-0">
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="bg-neutral-50">
							<tr>
								<th class="px-24 py-12">Pool</th>
								<th class="px-24 py-12">From Own Sales</th>
								<th class="px-24 py-12">From Overrides</th>
								<th class="px-24 py-12">Total</th>
							</tr>
						</thead>
						<tbody>
							@foreach(['booking' => 'Booking Money', 'down' => 'Down Payment', 'instalment' => 'Instalment'] as $poolKey => $poolLabel)
							@php $pool = $earningsSummary['pools'][$poolKey] ?? ['own' => 0, 'override' => 0, 'total' => 0]; @endphp
							<tr>
								<td class="px-24 py-12 fw-medium">{{ $poolLabel }} <small class="text-secondary-light">({{ config('commission.pools.' . $poolKey) }}% pool)</small></td>
								<td class="px-24 py-12">৳{{ format_bd_number($pool['own'], 2) }}</td>
								<td class="px-24 py-12">৳{{ format_bd_number($pool['override'], 2) }}</td>
								<td class="px-24 py-12 fw-semibold text-success-600">৳{{ format_bd_number($pool['total'], 2) }}</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot class="bg-neutral-50">
							<tr>
								<td class="px-24 py-12 fw-semibold">Total {{ $legacyCommission > 0 ? '(incl. legacy)' : '' }}</td>
								<td class="px-24 py-12 fw-semibold">৳{{ format_bd_number($earningsSummary['own'], 2) }}</td>
								<td class="px-24 py-12 fw-semibold">৳{{ format_bd_number($earningsSummary['override'], 2) }}</td>
								<td class="px-24 py-12 fw-bold text-success-600">৳{{ format_bd_number($earningsSummary['total'] + $legacyCommission, 2) }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
			</div>
		</div>

		{{-- Recent earnings ledger --}}
		<div class="card radius-12 mb-24">
			<div class="card-header py-16 px-24 bg-base">
				<h6 class="mb-0 d-flex align-items-center gap-2">
					<iconify-icon icon="mdi:cash-multiple" class="text-primary-600"></iconify-icon>
					Recent Commission Earnings
				</h6>
			</div>
			<div class="card-body p-0">
				@if($recentEarnings->count())
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="bg-neutral-50">
							<tr>
								<th class="px-24 py-12">Date</th>
								<th class="px-24 py-12">Booking</th>
								<th class="px-24 py-12">Pool</th>
								<th class="px-24 py-12">Source</th>
								<th class="px-24 py-12">Share</th>
								<th class="px-24 py-12">Amount</th>
							</tr>
						</thead>
						<tbody>
							@foreach($recentEarnings as $earning)
							<tr>
								<td class="px-24 py-12 text-secondary-light">{{ $earning->created_at->format('d M, Y') }}</td>
								<td class="px-24 py-12">
									<a href="{{ route('admin.bookings.show', $earning->booking_id) }}" class="text-primary-600 hover-text-primary">
										#{{ str_pad($earning->booking_id, 5, '0', STR_PAD_LEFT) }}{{ $earning->booking && $earning->booking->plot ? ' - ' . $earning->booking->plot->plot_no : '' }}
									</a>
								</td>
								<td class="px-24 py-12"><span class="badge bg-info-focus text-info-600 text-capitalize">{{ $earning->pool_type }}</span></td>
								<td class="px-24 py-12">
									@if($earning->isOwnSale())
										<span class="badge bg-success-focus text-success-600">Own sale</span>
									@else
										<span class="badge bg-warning-focus text-warning-600">Override — {{ $earning->seller->name ?? 'N/A' }}</span>
									@endif
								</td>
								<td class="px-24 py-12">{{ rtrim(rtrim(number_format($earning->percentage, 2), '0'), '.') }}%</td>
								<td class="px-24 py-12 fw-semibold text-success-600">৳{{ format_bd_number($earning->amount, 2) }}</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@else
				<p class="text-secondary-light text-center py-24 mb-0">No commission earnings yet</p>
				@endif
			</div>
		</div>

		{{-- Bookings --}}
		<div class="card radius-12 mb-24">
			<div class="card-header py-16 px-24 bg-base">
				<h6 class="mb-0 d-flex align-items-center gap-2">
					<iconify-icon icon="mdi:book-open-variant" class="text-primary-600"></iconify-icon>
					Sales / Referred Bookings ({{ $bookings->count() }})
				</h6>
			</div>
			<div class="card-body p-0">
				@if($bookings->count())
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="bg-neutral-50">
							<tr>
								<th class="px-24 py-12">Booking</th>
								<th class="px-24 py-12">Customer</th>
								<th class="px-24 py-12">Scheme</th>
								<th class="px-24 py-12">Customer Paid</th>
								<th class="px-24 py-12">Status</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bookings as $booking)
							<tr>
								<td class="px-24 py-12">
									<a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-primary-600 hover-text-primary">
										#{{ str_pad($booking->id, 5, '0', STR_PAD_LEFT) }} - {{ $booking->plot->plot_no ?? 'N/A' }}
									</a>
								</td>
								<td class="px-24 py-12">{{ $booking->user->name ?? 'N/A' }}</td>
								<td class="px-24 py-12">
									@if($booking->isHierarchyScheme())
										<span class="badge bg-success-focus text-success-600">Hierarchy</span>
									@else
										<span class="badge bg-neutral-200 text-neutral-600">Legacy ({{ $booking->agent_commission !== null ? rtrim(rtrim(number_format($booking->agent_commission, 2), '0'), '.') . '%' : '—' }})</span>
									@endif
								</td>
								<td class="px-24 py-12">৳{{ format_bd_number($booking->payments->sum('amount'), 2) }}</td>
								<td class="px-24 py-12">
									<span class="badge {{ $booking->status == 'approved' ? 'bg-success-focus text-success-600' : ($booking->status == 'cancelled' ? 'bg-danger-focus text-danger-600' : 'bg-warning-focus text-warning-600') }} text-capitalize">{{ $booking->status }}</span>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
				</div>
				@else
				<p class="text-secondary-light text-center py-24 mb-0">No bookings yet</p>
				@endif
			</div>
		</div>

		{{-- Payouts --}}
		<div class="card radius-12">
			<div class="card-header py-16 px-24 bg-base d-flex align-items-center justify-content-between">
				<h6 class="mb-0 d-flex align-items-center gap-2">
					<iconify-icon icon="mdi:cash-fast" class="text-primary-600"></iconify-icon>
					Payouts ({{ $payouts->count() }})
				</h6>
				<a href="{{ route('admin.commission-payouts.create') }}?user_id={{ $commissionUser->id }}" class="btn btn-sm btn-primary d-inline-flex align-items-center gap-1">
					<iconify-icon icon="ic:baseline-plus"></iconify-icon> New Payout
				</a>
			</div>
			<div class="card-body p-0">
				@if($payouts->count())
				<div class="table-responsive">
					<table class="table mb-0">
						<thead class="bg-neutral-50">
							<tr>
								<th class="px-24 py-12">Date</th>
								<th class="px-24 py-12">Amount</th>
								<th class="px-24 py-12">Reference</th>
								<th class="px-24 py-12">Note</th>
							</tr>
						</thead>
						<tbody>
							@foreach($payouts as $payout)
							<tr>
								<td class="px-24 py-12 text-secondary-light">{{ $payout->created_at->format('d M, Y') }}</td>
								<td class="px-24 py-12 fw-semibold text-success-600">৳{{ format_bd_number($payout->amount, 2) }}</td>
								<td class="px-24 py-12">
									@if($payout->booking_id)
										<a href="{{ route('admin.bookings.show', $payout->booking_id) }}" class="text-primary-600 hover-text-primary">Booking #{{ str_pad($payout->booking_id, 5, '0', STR_PAD_LEFT) }}</a>
									@else
										—
									@endif
								</td>
								<td class="px-24 py-12 text-secondary-light">{{ $payout->payment_note ?? '—' }}</td>
							</tr>
							@endforeach
						</tbody>
						<tfoot class="bg-neutral-50">
							<tr>
								<td class="px-24 py-12 fw-semibold">Total Paid</td>
								<td class="px-24 py-12 fw-bold text-success-600" colspan="3">৳{{ format_bd_number($totalPaid, 2) }}</td>
							</tr>
						</tfoot>
					</table>
				</div>
				@else
				<p class="text-secondary-light text-center py-24 mb-0">No payouts yet</p>
				@endif
			</div>
		</div>
	</div>
</div>
@endsection
