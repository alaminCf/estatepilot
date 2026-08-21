<!-- meta tags and other links -->
<!DOCTYPE html>
<html lang="en" data-theme="light" style="--primary-600: #09306c; --primary-700: #072551; --primary-800: #062047;">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>{{ site_name() }} - {{ ucfirst(Auth::user()->role) }} Dashboard</title>
	<link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}" sizes="16x16">
	<!-- remix icon font css  -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/remixicon.css') }}">
	<!-- BootStrap css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/bootstrap.min.css') }}">
	<!-- Apex Chart css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/apexcharts.css') }}">
	<!-- Data Table css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/dataTables.min.css') }}">
	<!-- Text Editor css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/editor-katex.min.css') }}">
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/editor.atom-one-dark.min.css') }}">
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/editor.quill.snow.css') }}">
	<!-- Date picker css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/flatpickr.min.css') }}">
	<!-- Calendar css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/full-calendar.css') }}">
	<!-- Vector Map css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/jquery-jvectormap-2.0.5.css') }}">
	<!-- Popup css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/magnific-popup.css') }}">
	<!-- Slick Slider css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/slick.css') }}">
	<!-- prism css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/prism.css') }}">
	<!-- file upload css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/file-upload.css') }}">

	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/lib/audioplayer.css') }}">
	<!-- main css -->
	<link rel="stylesheet" href="{{ asset('wowdash/assets/css/style.css') }}">

	<style>
		.btn-primary{
			background-color: var(--primary-600) !important;
			color: #fff !important;
		}
		iconify-icon {
			display: inline-block;
		}
	</style>

	@stack('styles')
</head>

<body>
	<aside class="sidebar">
		<button type="button" class="sidebar-close-btn">
			<iconify-icon icon="radix-icons:cross-2"></iconify-icon>
		</button>
		<div>
			<a href="{{ route(Auth::user()->role . '.dashboard') }}" class="sidebar-logo">
				<img src="{{ asset('assets/logo-w.png') }}" alt="{{ site_name() }}" class="light-logo" style="max-height: 80px;">
				<img src="{{ asset('assets/logo-w.png') }}" alt="{{ site_name() }}" class="dark-logo" style="max-height: 80px;">
				<img src="{{ asset('assets/logo.png') }}" alt="{{ site_name() }}" class="logo-icon" style="max-height: 40px;">
			</a>
		</div>
		<div class="sidebar-menu-area">
			<ul class="sidebar-menu" id="sidebar-menu">
				@include('Accounts.' . ucfirst(Auth::user()->role) . '.sidebar-menu')
			</ul>
		</div>
	</aside>

	<main class="dashboard-main">
		<div class="navbar-header">
			<div class="row align-items-center justify-content-between">
				<div class="col-auto">
					<div class="d-flex flex-wrap align-items-center gap-4">
						<button type="button" class="sidebar-toggle">
							<iconify-icon icon="heroicons:bars-3-solid" class="icon text-2xl non-active"></iconify-icon>
							<iconify-icon icon="iconoir:arrow-right" class="icon text-2xl active"></iconify-icon>
						</button>
						<button type="button" class="sidebar-mobile-toggle">
							<iconify-icon icon="heroicons:bars-3-solid" class="icon"></iconify-icon>
						</button>
						<div class="navbar-search" id="navbar-search-wrapper" style="position:relative;">
							<input type="text" id="navbar-search-input" placeholder="Search menu..." autocomplete="off">
							<iconify-icon icon="ion:search-outline" class="icon"></iconify-icon>
							<ul id="navbar-search-results" style="display:none;position:absolute;top:calc(100% + 6px);left:0;right:0;background:var(--bg-white, #fff);border:1px solid var(--neutral-200,#e5e7eb);border-radius:0.5rem;box-shadow:0 8px 24px rgba(0,0,0,.1);list-style:none;margin:0;padding:6px 0;z-index:9999;max-height:320px;overflow-y:auto;"></ul>
						</div>
					</div>
				</div>
				<div class="col-auto">
					<div class="d-flex flex-wrap align-items-center gap-3">
						
						<!-- Theme Toggle -->
						{{-- <button type="button" data-theme-toggle class="w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"></button> --}}
						
						

						

						<!-- Notification Dropdown - Commented for future use
						<div class="dropdown">
							<button
								class="has-indicator w-40-px h-40-px bg-neutral-200 rounded-circle d-flex justify-content-center align-items-center"
								type="button" data-bs-toggle="dropdown">
								<iconify-icon icon="iconoir:bell" class="text-primary-light text-xl"></iconify-icon>
							</button>
							<div class="dropdown-menu to-top dropdown-menu-lg p-0">
								<div
									class="m-16 py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
									<div>
										<h6 class="text-lg text-primary-light fw-semibold mb-0">Notifications</h6>
									</div>
									<span
										class="text-primary-600 fw-semibold text-lg w-40-px h-40-px rounded-circle bg-base d-flex justify-content-center align-items-center">05</span>
								</div>

								<div class="max-h-400-px overflow-y-auto scroll-sm pe-4">
									<a href="javascript:void(0)"
										class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
										<div
											class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
											<span
												class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
												<iconify-icon icon="bitcoin-icons:verify-outline"
													class="icon text-xxl"></iconify-icon>
											</span>
											<div>
												<h6 class="text-md fw-semibold mb-4">Congratulations</h6>
												<p class="mb-0 text-sm text-secondary-light text-w-200-px">Your profile
													has been Verified. Your
													profile has been Verified</p>
											</div>
										</div>
										<span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
									</a>

									<a href="javascript:void(0)"
										class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
										<div
											class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
											<span
												class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
												<img src="assets/images/notification/profile-1.png" alt="Image">
											</span>
											<div>
												<h6 class="text-md fw-semibold mb-4">Ronald Richards</h6>
												<p class="mb-0 text-sm text-secondary-light text-w-200-px">You can
													stitch between artboards</p>
											</div>
										</div>
										<span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
									</a>

									<a href="javascript:void(0)"
										class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
										<div
											class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
											<span
												class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
												AM
											</span>
											<div>
												<h6 class="text-md fw-semibold mb-4">Arlene McCoy</h6>
												<p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to
													prototyping</p>
											</div>
										</div>
										<span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
									</a>

									<a href="javascript:void(0)"
										class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between bg-neutral-50">
										<div
											class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
											<span
												class="w-44-px h-44-px bg-success-subtle text-success-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
												<img src="assets/images/notification/profile-2.png" alt="Image">
											</span>
											<div>
												<h6 class="text-md fw-semibold mb-4">Robiul Hasan</h6>
												<p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to
													prototyping</p>
											</div>
										</div>
										<span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
									</a>

									<a href="javascript:void(0)"
										class="px-24 py-12 d-flex align-items-start gap-3 mb-2 justify-content-between">
										<div
											class="text-black hover-bg-transparent hover-text-primary d-flex align-items-center gap-3">
											<span
												class="w-44-px h-44-px bg-info-subtle text-info-main rounded-circle d-flex justify-content-center align-items-center flex-shrink-0">
												DR
											</span>
											<div>
												<h6 class="text-md fw-semibold mb-4">Darlene Robertson</h6>
												<p class="mb-0 text-sm text-secondary-light text-w-200-px">Invite you to
													prototyping</p>
											</div>
										</div>
										<span class="text-sm text-secondary-light flex-shrink-0">23 Mins ago</span>
									</a>
								</div>

								<div class="text-center py-12 px-16">
									<a href="javascript:void(0)" class="text-primary-600 fw-semibold text-md">See All
										Notification</a>
								</div>

							</div>
						</div>
						-->
						<!-- Notification dropdown end -->

						<!-- View Website Button -->
						<a href="{{ route('home') }}" target="_blank" class="btn btn-sm btn-outline-primary-600 radius-8 d-flex align-items-center gap-2" title="View Website">
							<iconify-icon icon="solar:eye-outline" class="icon text-lg"></iconify-icon>
							<span class="d-none d-sm-inline">View Website</span>
						</a>

						<div class="dropdown">
							<button class="d-flex justify-content-center align-items-center rounded-circle"
								type="button" data-bs-toggle="dropdown">
						<img src="{{ Auth::user()->profile_image_url }}" alt="{{ Auth::user()->name }}"
									class="w-40-px h-40-px object-fit-cover rounded-circle">
							</button>
							<div class="dropdown-menu to-top dropdown-menu-sm">
								<div
									class="py-12 px-16 radius-8 bg-primary-50 mb-16 d-flex align-items-center justify-content-between gap-2">
									<div>
										<h6 class="text-lg text-primary-light fw-semibold mb-2">{{ Auth::user()->name }}</h6>
										<span class="text-secondary-light fw-medium text-sm">{{ ucfirst(Auth::user()->role) }}</span>
									</div>
									<button type="button" class="hover-text-danger">
										<iconify-icon icon="radix-icons:cross-1" class="icon text-xl"></iconify-icon>
									</button>
								</div>
								<ul class="to-top-list">
									<li>
										<a class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-primary d-flex align-items-center gap-3"
											href="{{ route(Auth::user()->role . '.profile.index') }}">
											<iconify-icon icon="solar:user-linear" class="icon text-xl"></iconify-icon>
											My Profile</a>
									</li>
									<li>
										<form action="{{ route('logout') }}" method="POST" class="d-inline">
											@csrf
											<button type="submit" class="dropdown-item text-black px-0 py-8 hover-bg-transparent hover-text-danger d-flex align-items-center gap-3 bg-transparent border-0 w-100 text-start">
												<iconify-icon icon="lucide:power" class="icon text-xl"></iconify-icon> 
												Log Out
											</button>
										</form>
									</li>
								</ul>
							</div>
						</div><!-- Profile dropdown end -->
					</div>
				</div>
			</div>
		</div>

		<div class="dashboard-main-body">
			@yield('content')
		</div>

		
	</main>


	<!-- jQuery library js -->
	<script src="{{ asset('wowdash/assets/js/lib/jquery-3.7.1.min.js') }}"></script>
	<!-- Bootstrap js -->
	<script src="{{ asset('wowdash/assets/js/lib/bootstrap.bundle.min.js') }}"></script>
	<!-- Apex Chart js -->
	<script src="{{ asset('wowdash/assets/js/lib/apexcharts.min.js') }}"></script>
	<!-- Data Table js -->
	<script src="{{ asset('wowdash/assets/js/lib/dataTables.min.js') }}"></script>
	<!-- Iconify Font js -->
	<script src="{{ asset('wowdash/assets/js/lib/iconify-icon.min.js') }}"></script>
	<!-- jQuery UI js -->
	<script src="{{ asset('wowdash/assets/js/lib/jquery-ui.min.js') }}"></script>
	<!-- Vector Map js -->
	<script src="{{ asset('wowdash/assets/js/lib/jquery-jvectormap-2.0.5.min.js') }}"></script>
	<script src="{{ asset('wowdash/assets/js/lib/jquery-jvectormap-world-mill-en.js') }}"></script>
	<!-- Popup js -->
	<script src="{{ asset('wowdash/assets/js/lib/magnifc-popup.min.js') }}"></script>
	<!-- Slick Slider js -->
	<script src="{{ asset('wowdash/assets/js/lib/slick.min.js') }}"></script>
	<!-- prism js -->
	<script src="{{ asset('wowdash/assets/js/lib/prism.js') }}"></script>
	<!-- file upload js -->
	<script src="{{ asset('wowdash/assets/js/lib/file-upload.js') }}"></script>
	<!-- audioplayer -->
	<script src="{{ asset('wowdash/assets/js/lib/audioplayer.js') }}"></script>

	<!-- main js -->
	<script src="{{ asset('wowdash/assets/js/app.js') }}"></script>
	@stack('scripts')

	<script>
	(function () {
		const input   = document.getElementById('navbar-search-input');
		const results = document.getElementById('navbar-search-results');

		if (!input || !results) return;

		// Collect all sidebar menu links once the DOM is ready
		function getMenuItems() {
			const links = document.querySelectorAll('#sidebar-menu a[href]:not([href="javascript:void(0)"])');
			const items = [];
			links.forEach(function (a) {
				const label = a.textContent.trim().replace(/\s+/g, ' ');
				if (label && a.href) {
					items.push({ label: label, href: a.href });
				}
			});
			return items;
		}

		function showResults(items) {
			results.innerHTML = '';
			if (items.length === 0) {
				const li = document.createElement('li');
				li.style.cssText = 'padding:10px 16px;color:var(--text-secondary-light,#6b7280);font-size:.875rem;';
				li.textContent = 'No results found';
				results.appendChild(li);
			} else {
				items.forEach(function (item) {
					const li = document.createElement('li');
					const a  = document.createElement('a');
					a.href = item.href;
					a.textContent = item.label;
					a.style.cssText = 'display:block;padding:9px 16px;color:var(--text-primary-light,#111827);font-size:.875rem;text-decoration:none;transition:background .15s;';
					a.addEventListener('mouseenter', function () { this.style.background = 'var(--primary-50,#eff6ff)'; this.style.color = 'var(--primary-600,#09306c)'; });
					a.addEventListener('mouseleave', function () { this.style.background = ''; this.style.color = 'var(--text-primary-light,#111827)'; });
					li.appendChild(a);
					results.appendChild(li);
				});
			}
			results.style.display = 'block';
		}

		input.addEventListener('input', function () {
			const q = this.value.trim().toLowerCase();
			if (!q) { results.style.display = 'none'; return; }
			const matched = getMenuItems().filter(function (item) {
				return item.label.toLowerCase().includes(q);
			});
			showResults(matched);
		});

		document.addEventListener('click', function (e) {
			if (!document.getElementById('navbar-search-wrapper').contains(e.target)) {
				results.style.display = 'none';
			}
		});

		input.addEventListener('focus', function () {
			if (this.value.trim()) input.dispatchEvent(new Event('input'));
		});
	})();
	</script>


</body>

</html>