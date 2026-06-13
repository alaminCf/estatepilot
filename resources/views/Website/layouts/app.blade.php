<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'London Abason - Premium Real Estate Plots')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2A8441',
                        'primary-dark': '#1f6330',
                        'primary-light': '#3fa755',
                    }
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap');
        body {
            font-family: 'Inter', sans-serif;
        }
        .gradient-overlay {
            background: linear-gradient(135deg, rgba(42, 132, 65, 0.95) 0%, rgba(31, 99, 48, 0.9) 100%);
        }
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .animate-fadeIn {
            animation: fadeIn 0.8s ease-out forwards;
        }
        @keyframes bounce-slow {
            0%, 100% {
                transform: translateY(0);
            }
            50% {
                transform: translateY(-20px);
            }
        }
        .animate-bounce-slow {
            animation: bounce-slow 3s ease-in-out infinite;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50">
    
    <!-- Navigation -->
    <nav class="bg-white shadow-md fixed w-full top-0 z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2">
                        <img src="{{ asset('assets/logo-w.png') }}" alt="London Abason" style="height: 4.5rem;">
                    </a>
                </div>
                
                <!-- Desktop Menu (Center) -->
                <div class="hidden md:flex items-center space-x-10">
                    <a href="{{ route('home') }}" class="{{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-gray-700 font-medium' }} hover:text-primary-dark transition">Home</a>
                    <a href="{{ route('plots.index') }}" class="{{ request()->routeIs('plots.*') ? 'text-primary font-semibold' : 'text-gray-700 font-medium' }} hover:text-primary transition">Our Plots</a>
                    <a href="{{ route('about') }}" class="{{ request()->routeIs('about') ? 'text-primary font-semibold' : 'text-gray-700 font-medium' }} hover:text-primary transition">About Us</a>
                    <a href="{{ route('faq') }}" class="{{ request()->routeIs('faq') ? 'text-primary font-semibold' : 'text-gray-700 font-medium' }} hover:text-primary transition">FAQ</a>
                    <a href="{{ route('contact') }}" class="{{ request()->routeIs('contact') ? 'text-primary font-semibold' : 'text-gray-700 font-medium' }} hover:text-primary transition">Contact</a>
                </div>

                <!-- CTA Buttons (Right) -->
                <div class="hidden md:flex items-center space-x-3">
                    @auth
                        <a href="{{ route('account.dashboard') }}" class="bg-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg shadow-primary/30">
                            <i class="fas fa-user mr-2"></i>
                            <span>My Account</span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="border-2 border-primary text-primary px-6 py-2.5 rounded-lg font-semibold hover:bg-primary hover:text-white transition">
                            Sign In
                        </a>
                        <a href="{{ route('register') }}" class="bg-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg shadow-primary/30">
                            Register
                        </a>
                    @endauth
                </div>

                <!-- Mobile Menu Button -->
                <div class="md:hidden">
                    <button id="mobileMenuBtn" class="text-gray-700 hover:text-primary">
                        <i class="fas fa-bars text-2xl"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Menu -->
        <div id="mobileMenu" class="hidden md:hidden bg-white border-t">
            <div class="px-4 py-4 space-y-3">
                <a href="{{ route('home') }}" class="block {{ request()->routeIs('home') ? 'text-primary font-semibold' : 'text-gray-700' }} py-2">Home</a>
                <a href="{{ route('plots.index') }}" class="block {{ request()->routeIs('plots.*') ? 'text-primary font-semibold' : 'text-gray-700' }} hover:text-primary py-2">Our Plots</a>
                <a href="{{ route('about') }}" class="block {{ request()->routeIs('about') ? 'text-primary font-semibold' : 'text-gray-700' }} hover:text-primary py-2">About Us</a>
                <a href="{{ route('faq') }}" class="block {{ request()->routeIs('faq') ? 'text-primary font-semibold' : 'text-gray-700' }} hover:text-primary py-2">FAQ</a>
                <a href="{{ route('contact') }}" class="block {{ request()->routeIs('contact') ? 'text-primary font-semibold' : 'text-gray-700' }} hover:text-primary py-2">Contact</a>
                
                @auth
                    <a href="{{ route('account.dashboard') }}" class="block w-full bg-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-primary-dark transition mt-2 text-center">
                        <i class="fas fa-user mr-2"></i>My Account
                    </a>
                @else
                    <a href="{{ route('login') }}" class="block w-full border-2 border-primary text-primary px-6 py-2.5 rounded-lg font-semibold hover:bg-primary hover:text-white transition mt-2 text-center">
                        Sign In
                    </a>
                    <a href="{{ route('register') }}" class="block w-full bg-primary text-white px-6 py-2.5 rounded-lg font-semibold hover:bg-primary-dark transition mt-2 text-center">
                        Register
                    </a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    @yield('content')

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-300 pt-16 pb-8">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-4 gap-8 mb-8">
                <!-- Company Info -->
                <div class="md:col-span-1">
                    <div class="mb-4">
                        <img src="{{ asset('assets/logo-w.png') }}" alt="London Abason" style="height: 5rem;" class="mb-4">
                    </div>
                    <p class="text-gray-400 mb-4">
                        Building dreams with premium residential and commercial plots in prime locations.
                    </p>
                    <div class="flex space-x-3">
                        <a href="https://www.facebook.com/londonabasonbd" target="_blank" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 hover:bg-primary rounded-lg flex items-center justify-center transition">
                            <i class="fab fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('home') }}" class="hover:text-primary transition">Home</a></li>
                        <li><a href="{{ route('plots.index') }}" class="hover:text-primary transition">Our Plots</a></li>
                        <li><a href="{{ route('home') }}#about" class="hover:text-primary transition">About Us</a></li>
                        <li><a href="{{ route('home') }}#contact" class="hover:text-primary transition">Contact Us</a></li>
                        <li><a href="{{ route('home') }}#faq" class="hover:text-primary transition">FAQ</a></li>
                    </ul>
                </div>

                <!-- Recent Plots -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Recent Plots</h4>
                    <ul class="space-y-2">
                        @php
                            $recentPlots = \App\Models\Plot::where('status', 'available')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($recentPlots as $plot)
                            <li>
                                <a href="{{ route('plot.details', $plot->id) }}" class="hover:text-primary transition flex items-start">
                                    <i class="fas fa-map-marker-alt text-primary mt-1 mr-2 text-xs"></i>
                                    <span class="text-sm">{{ Str::limit($plot->title, 35) }}</span>
                                </a>
                            </li>
                        @empty
                            <li class="text-gray-500 text-sm">No plots available</li>
                        @endforelse
                    </ul>
                </div>

                <!-- Contact Info -->
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact Us</h4>
                    @php
                        $footerAddress = \App\Models\WebsiteSetting::get('office_address', '123 Business Street, Dhaka, Bangladesh');
                        $footerPhone = \App\Models\WebsiteSetting::get('phone_primary', '+880 1322-902986');
                        $footerEmail = \App\Models\WebsiteSetting::get('contact_email', 'info@londonabd.com');
                        $footerHours = \App\Models\WebsiteSetting::get('office_hours', 'Sat - Thu: 9AM - 6PM');
                        $googleMapsUrl = \App\Models\WebsiteSetting::get('google_maps_url', '');
                    @endphp
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <a href="{{ $googleMapsUrl }}" target="_blank"  class="flex items-start space-x-3 hover:underline">
                                <i class="fas fa-map-marker-alt text-primary mt-1"></i>
                                <div class="flex-1">
                                    <span class="block">{!! nl2br(e($footerAddress)) !!}</span>
                                </div>
                            </a>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-phone text-primary"></i>
                            <span>{{ $footerPhone }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-primary"></i>
                            <span>{{ $footerEmail }}</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-clock text-primary"></i>
                            <span>{{ $footerHours }}</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Bottom Bar -->
            <div class="border-t border-gray-800 pt-8 mt-8">
                <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                    <p class="text-gray-400 text-sm">
                        © 2026 London Abason Ltd. All rights reserved. | Developed by <a href="https://techboloy.com/" target="_blank" class="text-primary font-semibold hover:underline">Techboloy</a> <span class="text-red-500">❤️</span>
                    </p>
                    <div class="flex space-x-6 text-sm">
                        <a href="#" class="hover:text-primary transition">Privacy Policy</a>
                        <a href="#" class="hover:text-primary transition">Terms of Service</a>
                        <a href="#" class="hover:text-primary transition">Cookie Policy</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script>
        // Mobile Menu Toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const menu = document.getElementById('mobileMenu');
            menu.classList.toggle('hidden');
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                const href = this.getAttribute('href');
                if (href.includes('#')) {
                    const hashPart = href.split('#')[1];
                    const target = document.getElementById(hashPart);
                    if (target) {
                        e.preventDefault();
                        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
                        document.getElementById('mobileMenu').classList.add('hidden');
                    }
                }
            });
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.querySelector('nav');
            if (window.scrollY > 50) {
                nav.classList.add('shadow-xl');
            } else {
                nav.classList.remove('shadow-xl');
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
