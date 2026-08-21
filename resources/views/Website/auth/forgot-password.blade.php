@extends('Website.layouts.app')

@section('title', 'Forgot Password - ' . site_name())

@section('content')
    <!-- Forgot Password Section -->
    <section class="relative pt-20 min-h-screen flex items-center bg-gradient-to-br from-gray-50 to-gray-100 py-12">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2309306c\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative max-w-md mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
            <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                <!-- Header -->
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-gradient-to-br from-primary to-primary-dark rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-lock text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Forgot Password?</h1>
                    <p class="text-gray-600">Enter your phone number to reset your password</p>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                            <div class="text-sm text-red-600">
                                <ul class="list-disc list-inside">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                @if(session('error'))
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3"></i>
                            <span class="text-sm text-red-600">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Form -->
                <form action="{{ route('password.phone') }}" method="POST" class="space-y-5">
                    @csrf

                    <!-- Phone Number -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <i class="fas fa-phone text-gray-400"></i>
                                <span class="ml-2 text-gray-500">+88</span>
                            </div>
                            <input 
                                type="tel" 
                                id="phone" 
                                name="phone" 
                                value="{{ old('phone') }}"
                                required
                                pattern="^01[0-9]{9}$"
                                class="w-full pl-20 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                placeholder="01XXXXXXXXX"
                                title="Phone number must start with 01 and be 11 digits">
                        </div>
                        <p class="mt-1 text-xs text-gray-500">Enter the phone number associated with your account</p>
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        class="w-full bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-4 rounded-lg font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary/30">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Send Verification Code
                    </button>
                </form>

                <!-- Back to Login -->
                <div class="text-center mt-6">
                    <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-700 transition inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Login
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
