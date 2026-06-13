@extends('Website.layouts.app')

@section('title', 'Sign In - London Abason')

@section('content')
    <!-- Sign In Section -->
    <section class="relative pt-20 min-h-screen flex items-center bg-gradient-to-br from-gray-50 to-gray-100">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%232A8441\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Left Side - Branding -->
                <div class="hidden md:block">
                    <div class="space-y-8">
                        <!-- Logo & Heading -->
                        <div class="space-y-6">
                            <div class="inline-block">
                                <img src="{{ asset('assets/logo.png') }}" alt="London Abason" class="h-20">
                            </div>
                            
                            <div class="space-y-3">
                                <h2 class="text-5xl font-bold text-gray-900 leading-tight">
                                    Welcome <span class="text-primary">Back!</span>
                                </h2>
                                <div class="w-20 h-1 bg-primary rounded-full"></div>
                            </div>
                            
                            <p class="text-gray-600 text-lg leading-relaxed max-w-md">
                                Sign in to access your account and manage your real estate investments with ease.
                            </p>
                        </div>

                        <!-- Features Cards -->
                        <div class="space-y-4 pt-4">
                            <div class="bg-gradient-to-br from-green-50 to-white p-5 rounded-xl border border-green-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-home text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">Browse Plots</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">Access exclusive property listings in prime locations</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-bookmark text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">Track Bookings</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">Monitor your property investments in real-time</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-white p-5 rounded-xl border border-purple-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-credit-card text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">Easy Payments</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">Flexible installment plans tailored to your budget</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trust Badge -->
                        <div class="pt-6">
                            <div class="inline-flex items-center space-x-3 bg-gradient-to-r from-primary/10 to-green-50 px-6 py-3 rounded-full border border-primary/20">
                                <i class="fas fa-shield-check text-primary text-xl"></i>
                                <div class="text-sm">
                                    <span class="font-bold text-gray-900">100% Secure</span>
                                    <span class="text-gray-600"> • Trusted by 1000+ families</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Login Form -->
                <div class="w-full">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Sign In</h1>
                            <p class="text-gray-600">Enter your credentials to access your account</p>
                        </div>

                        <!-- Error Messages -->
                        @if ($errors->any())
                            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                                    <div class="text-sm text-red-600">
                                        @foreach ($errors->all() as $error)
                                            <p>{{ $error }}</p>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endif

                        <!-- Success Message -->
                        @if (session('success'))
                            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex items-center">
                                    <i class="fas fa-check-circle text-green-500 mr-3"></i>
                                    <p class="text-sm text-green-600">{{ session('success') }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- Login Form -->
                        <form action="{{ route('login.submit') }}" method="POST" class="space-y-6">
                            @csrf

                            <!-- Email -->
                            <div>
                                <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Email Address
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="email" 
                                        id="email" 
                                        name="email" 
                                        value="{{ old('email') }}"
                                        required
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('email') border-red-500 @enderror"
                                        placeholder="your@email.com">
                                </div>
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="password" 
                                        id="password" 
                                        name="password" 
                                        required
                                        class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('password') border-red-500 @enderror"
                                        placeholder="Enter your password">
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="password-eye"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Remember & Forgot -->
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    <input 
                                        type="checkbox" 
                                        id="remember" 
                                        name="remember" 
                                        class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary">
                                    <label for="remember" class="ml-2 text-sm text-gray-700">
                                        Remember me
                                    </label>
                                </div>
                                <a href="{{ route('password.request') }}" class="text-sm font-semibold text-primary hover:text-primary-dark transition">
                                    Forgot Password?
                                </a>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                class="w-full bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-4 rounded-lg font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary/30">
                                <i class="fas fa-sign-in-alt mr-2"></i>
                                Sign In
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="relative my-8">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">or</span>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="text-center">
                            <p class="text-gray-600">
                                Don't have an account? 
                                <a href="{{ route('register') }}" class="font-bold text-primary hover:text-primary-dark transition">
                                    Create Account
                                </a>
                            </p>
                        </div>

                        <!-- Back to Home -->
                        <div class="text-center mt-6">
                            <a href="{{ route('home') }}" class="text-sm text-gray-500 hover:text-gray-700 transition inline-flex items-center">
                                <i class="fas fa-arrow-left mr-2"></i>
                                Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const eye = document.getElementById(inputId + '-eye');
        
        if (input.type === 'password') {
            input.type = 'text';
            eye.classList.remove('fa-eye');
            eye.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            eye.classList.remove('fa-eye-slash');
            eye.classList.add('fa-eye');
        }
    }
</script>
@endpush
