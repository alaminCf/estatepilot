@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
	<h6 class="fw-semibold mb-0">London Abason Dashboard</h6>
	<ul class="d-flex align-items-center gap-2">
		<li class="fw-medium">
			<a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
				<iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
				Dashboard
			</a>
		</li>
	</ul>
</div>

<div class="row gy-4">
	<!-- Stats Cards -->
	@if(Auth::user()->hasPermission('manage_plots') || Auth::user()->hasPermission('manage_payments'))
	<div class="col-12">
		<div class="card radius-12">
			<div class="card-body p-16">
				<div class="row gy-4">
					@if(Auth::user()->hasPermission('manage_plots'))
					<div class="col-xxl-3 col-xl-6 col-sm-6">
						<div class="px-24 py-20 shadow-none radius-8 h-100 bg-gradient-start-1 position-relative overflow-hidden">
							<div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
								<div>
									<span class="mb-8 fw-medium text-secondary-light text-md d-block">Total Plots</span>
									<h6 class="fw-semibold mb-1">{{ $totalPlots }}</h6>
								</div>
								<span class="w-56-px h-56-px radius-12 d-inline-flex justify-content-center align-items-center text-2xl bg-primary-600 text-white">
									<iconify-icon icon="solar:map-point-bold"></iconify-icon>
								</span>
							</div>
						</div>
					</div>
					<div class="col-xxl-3 col-xl-6 col-sm-6">
						<div class="px-24 py-20 shadow-none radius-8 h-100 bg-gradient-start-2 position-relative overflow-hidden">
							<div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
								<div>
									<span class="mb-8 fw-medium text-secondary-light text-md d-block">Booked Plots</span>
									<h6 class="fw-semibold mb-1">{{ $bookedPlots }}</h6>
								</div>
								<span class="w-56-px h-56-px radius-12 d-inline-flex justify-content-center align-items-center text-2xl bg-success-600 text-white">
									<iconify-icon icon="solar:check-circle-bold"></iconify-icon>
								</span>
							</div>
						</div>
					</div>
					@endif
					@if(Auth::user()->hasPermission('manage_payments'))
					<div class="col-xxl-3 col-xl-6 col-sm-6">
						<div class="px-24 py-20 shadow-none radius-8 h-100 bg-gradient-start-3 position-relative overflow-hidden">
							<div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
								<div>
									<span class="mb-8 fw-medium text-secondary-light text-md d-block">Total Collections</span>
								<h6 class="fw-semibold mb-1">৳{{ format_bd_number($totalCollections, 0) }}</h6>
								</div>
								<span class="w-56-px h-56-px radius-12 d-inline-flex justify-content-center align-items-center text-2xl bg-purple-600 text-white">
									<iconify-icon icon="solar:wallet-money-bold"></iconify-icon>
								</span>
							</div>
						</div>
					</div>
					<div class="col-xxl-3 col-xl-6 col-sm-6">
						<div class="px-24 py-20 shadow-none radius-8 h-100 bg-gradient-start-4 position-relative overflow-hidden">
							<div class="d-flex flex-wrap align-items-center justify-content-between gap-1">
								<div>
								<span class="mb-8 fw-medium text-secondary-light text-md d-block">Due Payment</span>
								<h6 class="fw-semibold mb-1">৳{{ format_bd_number($pendingAmount, 0) }}</h6>
								</div>
								<span class="w-56-px h-56-px radius-12 d-inline-flex justify-content-center align-items-center text-2xl bg-warning-600 text-white">
									<iconify-icon icon="solar:clock-circle-bold"></iconify-icon>
								</span>
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
	@endif

	<!-- Revenue Chart & Quick Stats -->
	@if(Auth::user()->hasPermission('manage_payments'))
	<div class="col-xxl-8">
		<div class="card h-100">
			<div class="card-body p-24 mb-8">
				<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
					<div>
						<h6 class="mb-2 fw-bold text-lg mb-0">Payment Overview</h6>
						<span class="text-sm fw-medium text-secondary-light">Collections & Payments Trend</span>
					</div>
					<div class="d-flex align-items-center gap-2">
						<span class="d-flex align-items-center gap-2">
							<span class="w-12-px h-12-px radius-2 bg-primary-600"></span>
							<span class="text-secondary-light text-sm fw-normal">Collections</span>
						</span>
						<span class="d-flex align-items-center gap-2">
							<span class="w-12-px h-12-px radius-2 bg-warning-600"></span>
							<span class="text-secondary-light text-sm fw-normal">Due</span>
						</span>
					</div>
				</div>
				<div id="revenueChart"></div>
			</div>
		</div>
	</div>
	@endif

	<div class="col-xxl-4 col-md-6">
		<div class="card h-100">
			<div class="card-header border-bottom">
				<h6 class="mb-0 text-lg">Quick Stats</h6>
			</div>
			<div class="card-body p-20">
				@if(Auth::user()->hasPermission('manage_bookings'))
				<div class="d-flex align-items-center gap-3 mb-20 pb-20 border-bottom">
					<span class="w-48-px h-48-px radius-8 d-inline-flex justify-content-center align-items-center bg-danger-100 text-danger-600">
						<iconify-icon icon="solar:document-text-bold" class="text-2xl"></iconify-icon>
					</span>
					<div class="flex-grow-1">
						<h6 class="text-md mb-0">Pending Booking</h6>
						<span class="text-secondary-light text-sm">Awaiting Confirmation</span>
					</div>
					<h6 class="mb-0">{{ $pendingDocs }}</h6>
				</div>
				@endif
				@if(Auth::user()->hasPermission('manage_plots'))
				<div class="d-flex align-items-center gap-3 mb-20 pb-20 border-bottom">
					<span class="w-48-px h-48-px radius-8 d-inline-flex justify-content-center align-items-center bg-primary-100 text-primary-600">
						<iconify-icon icon="solar:home-2-bold" class="text-2xl"></iconify-icon>
					</span>
					<div class="flex-grow-1">
						<h6 class="text-md mb-0">Available Plots</h6>
						<span class="text-secondary-light text-sm">{{ $availablePlots }} Ready to Book</span>
					</div>
					<h6 class="mb-0">{{ $availablePlots }}</h6>
				</div>
				@endif
				@if(Auth::user()->hasPermission('manage_customers'))
				<div class="d-flex align-items-center gap-3 mb-20 pb-20 border-bottom">
					<span class="w-48-px h-48-px radius-8 d-inline-flex justify-content-center align-items-center bg-success-100 text-success-600">
						<iconify-icon icon="solar:user-check-bold" class="text-2xl"></iconify-icon>
					</span>
					<div class="flex-grow-1">
						<h6 class="text-md mb-0">Total Customers</h6>
						<span class="text-secondary-light text-sm">Active Buyers</span>
					</div>
					<h6 class="mb-0">{{ $totalCustomers }}</h6>
				</div>
				@endif
				@if(Auth::user()->hasPermission('manage_commission_users'))
				<div class="d-flex align-items-center gap-3">
					<span class="w-48-px h-48-px radius-8 d-inline-flex justify-content-center align-items-center bg-warning-100 text-warning-600">
						<iconify-icon icon="solar:users-group-two-rounded-bold" class="text-2xl"></iconify-icon>
					</span>
					<div class="flex-grow-1">
						<h6 class="text-md mb-0">Commission Users</h6>
						<span class="text-secondary-light text-sm">Active Sales Team</span>
					</div>
					<h6 class="mb-0">{{ $totalAgents }}</h6>
				</div>
				@endif
			</div>
		</div>
	</div>

	<!-- Recent Bookings Table -->
	@if(Auth::user()->hasPermission('manage_bookings'))
	<div class="col-xxl-8">
		<div class="card h-100">
			<div class="card-header">
				<div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
					<h6 class="mb-0 text-lg">Recent Bookings</h6>
					<a href="{{ route('admin.bookings.index') ?? '#' }}" class="text-primary-600 text-sm fw-medium hover-text-decoration-underline">
						View All
					</a>
				</div>
			</div>
			<div class="card-body p-24">
				<div class="table-responsive">
					<table class="table bordered-table mb-0">
						<thead>
							<tr>
								<th>Plot No</th>
								<th>Customer</th>
								<th>Amount</th>
								<th>Date</th>
								<th>Status</th>
								<th>Action</th>
							</tr>
						</thead>
						<tbody>
							@forelse($recentBookings as $index => $booking)
							<tr>
								<td><span class="fw-medium text-secondary-light">{{ $booking->plot->plot_no ?? 'N/A' }}</span></td>
								<td>
									<div class="d-flex align-items-center gap-2">
										@php
											$colors = ['primary', 'success', 'purple', 'warning', 'info'];
											$color = $colors[$index % 5];
											$initials = strtoupper(substr($booking->user->name ?? 'NA', 0, 1) . substr(explode(' ', $booking->user->name ?? 'N A')[1] ?? 'A', 0, 1));
										@endphp
										<div class="w-32-px h-32-px radius-8 bg-{{ $color }}-100 text-{{ $color }}-600 d-inline-flex justify-content-center align-items-center">
											<span class="text-sm fw-bold">{{ $initials }}</span>
										</div>
										<span class="text-sm">{{ $booking->user->name ?? 'N/A' }}</span>
									</div>
								</td>
								<td>৳{{ format_bd_number($booking->price, 0) }}</td>
								<td>{{ $booking->created_at->format('d M Y') }}</td>
								<td>
								@if($booking->status == 'confirmed' || $booking->status == 'approved')
										<span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">{{ ucfirst($booking->status) }}</span>
									@elseif($booking->status == 'pending')
										<span class="badge text-sm fw-semibold text-warning-600 bg-warning-100 px-20 py-9 radius-4">Pending</span>
									@elseif($booking->status == 'pre-booked')
										<span class="badge text-sm fw-semibold text-info-600 bg-info-100 px-20 py-9 radius-4">Pre-Booked</span>
									@else
										<span class="badge text-sm fw-semibold text-danger-600 bg-danger-100 px-20 py-9 radius-4">{{ ucfirst($booking->status) }}</span>
									@endif
								</td>
								<td>
									<a href="{{ route('admin.bookings.show', $booking->id) }}" class="text-primary-600 hover-text-primary-800">
										<iconify-icon icon="solar:eye-bold" class="icon text-xl"></iconify-icon>
									</a>
								</td>
							</tr>
							@empty
							<tr>
								<td colspan="6" class="text-center text-secondary-light py-4">No recent bookings found</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endif

	<!-- Payment Status -->
	@if(Auth::user()->hasPermission('manage_payments'))
	<div class="col-xxl-4 col-md-6">
		<div class="card h-100">
			<div class="card-header">
				<h6 class="mb-0 text-lg">Payment Status</h6>
			</div>
			<div class="card-body p-24">
				<div id="paymentStatusChart"></div>
				<ul class="d-flex flex-column gap-3 mt-24">
					<li class="d-flex align-items-center justify-content-between gap-3">
						<div class="d-flex align-items-center gap-2">
							<span class="w-12-px h-12-px radius-2 bg-primary-600"></span>
							<span class="text-secondary-light text-sm fw-normal">Paid</span>
						</div>
						<span class="text-primary-light text-sm fw-semibold">৳{{ format_bd_number($paidAmount, 0) }}</span>
					</li>
					<li class="d-flex align-items-center justify-content-between gap-3">
						<div class="d-flex align-items-center gap-2">
							<span class="w-12-px h-12-px radius-2 bg-warning-600"></span>
							<span class="text-secondary-light text-sm fw-normal">Pending</span>
						</div>
						<span class="text-primary-light text-sm fw-semibold">৳{{ format_bd_number($pendingPayments, 0) }}</span>
					</li>
					<li class="d-flex align-items-center justify-content-between gap-3">
						<div class="d-flex align-items-center gap-2">
							<span class="w-12-px h-12-px radius-2 bg-danger-600"></span>
							<span class="text-secondary-light text-sm fw-normal">Overdue</span>
						</div>
						<span class="text-primary-light text-sm fw-semibold">৳{{ format_bd_number($overdueAmount, 0) }}</span>
					</li>
				</ul>
			</div>
		</div>
	</div>
	@endif

	<!-- Recent Payments Table -->
	@if(Auth::user()->hasPermission('manage_payments'))
	<div class="col-12">
		<div class="card">
			<div class="card-header">
				<div class="d-flex flex-wrap align-items-center justify-content-between gap-3">
					<h6 class="mb-0 text-lg">Recent Payments</h6>
					<a href="{{ route('admin.payments.index') ?? '#' }}" class="text-primary-600 text-sm fw-medium hover-text-decoration-underline">
						View All
					</a>
				</div>
			</div>
			<div class="card-body p-24">
				<div class="table-responsive">
					<table class="table bordered-table mb-0">
						<thead>
							<tr>
								<th>Transaction ID</th>
								<th>Plot No</th>
								<th>Customer</th>
								<th>Amount</th>
								<th>Payment Type</th>
								<th>Date</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
							@forelse($recentPayments as $payment)
							<tr>
								<td><span class="fw-medium text-secondary-light">#TXN-{{ str_pad($payment->id, 7, '0', STR_PAD_LEFT) }}</span></td>
								<td>{{ $payment->booking->plot->plot_no ?? 'N/A' }}</td>
								<td>{{ $payment->booking->user->name ?? 'N/A' }}</td>
								<td>৳{{ format_bd_number($payment->amount, 0) }}</td>
								<td>
									@if($payment->payment_type == 'booking')
										<span class="badge bg-success-100 text-success-600 text-sm fw-medium px-12 py-6">Booking Payment</span>
									@elseif($payment->payment_type == 'installment')
										<span class="badge bg-primary-100 text-primary-600 text-sm fw-medium px-12 py-6">Installment</span>
									@elseif($payment->payment_type == 'full')
										<span class="badge bg-purple-100 text-purple-600 text-sm fw-medium px-12 py-6">Full Payment</span>
									@else
										<span class="badge bg-info-100 text-info-600 text-sm fw-medium px-12 py-6">{{ ucfirst($payment->payment_type) }}</span>
									@endif
								</td>
								<td>{{ $payment->created_at->format('d M Y') }}</td>
								<td><span class="badge text-sm fw-semibold text-success-600 bg-success-100 px-20 py-9 radius-4">Completed</span></td>
							</tr>
							@empty
							<tr>
								<td colspan="7" class="text-center text-secondary-light py-4">No recent payments found</td>
							</tr>
							@endforelse
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	@endif
</div>

@push('scripts')
<script>
	@if(Auth::user()->hasPermission('manage_payments'))
	// Revenue Chart
	var revenueOptions = {
		series: [{
			name: 'Collections',
			data: {!! json_encode($monthlyCollections) !!}
		}, {
			name: 'Due',
			data: {!! json_encode($monthlyPending) !!}
		}],
		chart: {
			type: 'area',
			height: 320,
			toolbar: { show: false }
		},
		colors: ['#487FFF', '#FF9F29'],
		dataLabels: { enabled: false },
		stroke: {
			curve: 'smooth',
			width: 3
		},
		fill: {
			type: 'gradient',
			gradient: {
				shadeIntensity: 1,
				opacityFrom: 0.4,
				opacityTo: 0.1,
			}
		},
		xaxis: {
			categories: {!! json_encode($monthLabels) !!}
		},
		yaxis: {
			labels: {
				formatter: function(val) {
					if (val >= 10000000) return '৳' + (val / 10000000).toFixed(1) + 'Cr';
					if (val >= 100000) return '৳' + (val / 100000).toFixed(1) + 'L';
					return '৳' + val.toLocaleString('en-IN');
				}
			}
		},
		grid: {
			borderColor: '#e0e0e0',
			strokeDashArray: 4
		},
		tooltip: {
			y: {
				formatter: function(val) {
					return '৳' + val.toLocaleString('en-IN');
				}
			}
		}
	};
	var revenueChart = new ApexCharts(document.querySelector("#revenueChart"), revenueOptions);
	revenueChart.render();

	// Payment Status Donut Chart
	@php
		$total = $paidAmount + $pendingPayments + $overdueAmount;
		$paidPercent = $total > 0 ? round(($paidAmount / $total) * 100) : 0;
		$pendingPercent = $total > 0 ? round(($pendingPayments / $total) * 100) : 0;
		$overduePercent = $total > 0 ? round(($overdueAmount / $total) * 100) : 0;
	@endphp
	var paymentOptions = {
		series: [{{ $paidPercent }}, {{ $pendingPercent }}, {{ $overduePercent }}],
		chart: {
			type: 'donut',
			height: 240
		},
		colors: ['#487FFF', '#FF9F29', '#EF4444'],
		labels: ['Paid', 'Pending', 'Overdue'],
		legend: { show: false },
		dataLabels: { enabled: false },
		plotOptions: {
			pie: {
				donut: {
					size: '70%'
				}
			}
		}
	};
	var paymentChart = new ApexCharts(document.querySelector("#paymentStatusChart"), paymentOptions);
	paymentChart.render();
	@endif
</script>
@endpush
@endsection
