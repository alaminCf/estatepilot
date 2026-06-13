<!-- Admin Sidebar Menu -->
<li>
	<a href="{{ route('admin.dashboard') }}">
		<iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
		<span>Dashboard</span>
	</a>
</li>

@if(Auth::user()->hasPermission('manage_plots'))
<li class="sidebar-menu-group-title">Plot Management</li>

<li class="dropdown">
	<a href="javascript:void(0)">
		<iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
		<span>Plots</span>
	</a>
	<ul class="sidebar-submenu">
		<li>
			<a href="{{ route('admin.plots.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Plots</a>
		</li>
		<li>
			<a href="{{ route('admin.plots.index', ['status' => 'available']) }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Available Plots</a>
		</li>
		<li>
			<a href="{{ route('admin.plots.index', ['status' => 'pending']) }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Pending Plots</a>
		</li>
		<li>
			<a href="{{ route('admin.plots.index', ['status' => 'booked']) }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Booked Plots</a>
		</li>
	</ul>
</li>

<li>
	<a href="{{ route('admin.plots.create') }}">
		<iconify-icon icon="material-symbols:add-circle-outline" class="menu-icon"></iconify-icon>
		<span>Add New Plot</span>
	</a>
</li>
@endif

@if(Auth::user()->hasPermission('manage_bookings'))
<li class="sidebar-menu-group-title">Booking Management</li>
<li class="dropdown">
	<a href="javascript:void(0)">
		<iconify-icon icon="hugeicons:invoice-03" class="menu-icon"></iconify-icon>
		<span>Bookings</span>
	</a>
	<ul class="sidebar-submenu">
		<li>
			<a href="{{ route('admin.bookings.index') }}"><i class="ri-circle-fill circle-icon text-info-600 w-auto"></i> All Bookings</a>
		</li>
		<li>
			<a href="{{ route('admin.bookings.index', ['status' => 'pending']) }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Pending</a>
		</li>
		<li>
			<a href="{{ route('admin.bookings.index', ['status' => 'pre-booked']) }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Pre-Booked</a>
		</li>
		<li>
			<a href="{{ route('admin.bookings.index', ['status' => 'approved']) }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Approved</a>
		</li>
		<li>
			<a href="{{ route('admin.bookings.index', ['status' => 'cancelled']) }}"><i class="ri-circle-fill circle-icon text-danger-main w-auto"></i> Cancelled</a>
		</li>
	</ul>
</li>
<li>
	<a href="{{ route('admin.bookings.create') }}">
		<iconify-icon icon="material-symbols:add-circle-outline" class="menu-icon"></iconify-icon>
		<span>Add Booking</span>
	</a>
</li>
@endif

@if(Auth::user()->hasPermission('manage_payments'))
<li class="sidebar-menu-group-title">Payment Management</li>
<li class="dropdown">
	<a href="javascript:void(0)">
		<iconify-icon icon="solar:wallet-money-outline" class="menu-icon"></iconify-icon>
		<span>Payments</span>
	</a>
	<ul class="sidebar-submenu">
		<li>
			<a href="{{ route('admin.payments.index') }}"><i class="ri-circle-fill circle-icon text-primary-600 w-auto"></i> All Payments</a>
		</li>
		<li>
			<a href="{{ route('admin.payments.index', ['payment_type' => 'Booking Payment']) }}"><i class="ri-circle-fill circle-icon text-info-main w-auto"></i> Booking Payments</a>
		</li>
		<li>
			<a href="{{ route('admin.payments.index', ['payment_type' => 'Down Payment']) }}"><i class="ri-circle-fill circle-icon text-success-main w-auto"></i> Down Payments</a>
		</li>
		<li>
			<a href="{{ route('admin.payments.index', ['payment_type' => 'Installment Payment']) }}"><i class="ri-circle-fill circle-icon text-warning-main w-auto"></i> Installment Payments</a>
		</li>
	</ul>
</li>
<li>
	<a href="{{ route('admin.payments.create') }}">
		<iconify-icon icon="material-symbols:add-circle-outline" class="menu-icon"></iconify-icon>
		<span>Add Payment</span>
	</a>
</li>
@endif

@if(Auth::user()->hasPermission('manage_commission_users'))
<li class="sidebar-menu-group-title">Commission Team</li>
<li>
	<a href="{{ route('admin.commission-users.index') }}">
		<iconify-icon icon="solar:user-hands-outline" class="menu-icon"></iconify-icon>
		<span>All Commission Users</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.commission-users.create') }}">
		<iconify-icon icon="solar:user-plus-outline" class="menu-icon"></iconify-icon>
		<span>Add Commission User</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.commission-payouts.index') }}">
		<iconify-icon icon="solar:wallet-money-outline" class="menu-icon"></iconify-icon>
		<span>Commission Payouts</span>
	</a>
</li>
@endif

@if(Auth::user()->hasPermission('manage_customers'))
<li class="sidebar-menu-group-title">Manage Customers</li>
<li>
	<a href="{{ route('admin.users.index') }}">
		<iconify-icon icon="solar:users-group-two-rounded-outline" class="menu-icon"></iconify-icon>
		<span>All Customers</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.users.create') }}">
		<iconify-icon icon="solar:user-plus-outline" class="menu-icon"></iconify-icon>
		<span>Add New Customer</span>
	</a>
</li>
@endif

@if(Auth::user()->hasPermission('manage_reports'))
<li class="sidebar-menu-group-title">Reports</li>
<li>
	<a href="{{ route('admin.reports.plots') }}">
		<iconify-icon icon="material-symbols:map-outline" class="menu-icon"></iconify-icon>
		<span>Plots Report</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.reports.bookings') }}">
		<iconify-icon icon="material-symbols:book-outline" class="menu-icon"></iconify-icon>
		<span>Booking Report</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.reports.payments') }}">
		<iconify-icon icon="material-symbols:payments-outline" class="menu-icon"></iconify-icon>
		<span>Payment Report</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.reports.agents') }}">
		<iconify-icon icon="material-symbols:support-agent" class="menu-icon"></iconify-icon>
		<span>Commission Users Report</span>
	</a>
</li>
@endif



<li class="sidebar-menu-group-title">Settings</li>
@if(Auth::user()->hasPermission('manage_settings'))
<li>
	<a href="{{ route('admin.settings.index') }}">
		<iconify-icon icon="icon-park-outline:setting-two" class="menu-icon"></iconify-icon>
		<span>Platform Settings</span>
	</a>
</li>
<li>
	<a href="{{ route('admin.platform-users.index') }}">
		<iconify-icon icon="solar:shield-user-outline" class="menu-icon"></iconify-icon>
		<span>Platform User Roles</span>
	</a>
</li>
@endif
<li>
	<a href="{{ route('admin.profile.index') }}">
		<iconify-icon icon="solar:user-circle-outline" class="menu-icon"></iconify-icon>
		<span>Profile Settings</span>
	</a>
</li>