@extends('Website.layouts.app')

@section('title', 'Register - ' . site_name())

@section('content')
    <!-- Register Section -->
    <section class="relative pt-20 min-h-screen flex items-center bg-gradient-to-br from-gray-50 to-gray-100 py-12">
        <!-- Background Pattern -->
        <div class="absolute inset-0 overflow-hidden">
            <div class="absolute inset-0 opacity-5" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%2309306c\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20 w-full">
            <div class="grid md:grid-cols-2 gap-12">
                <!-- Left Side - Branding -->
                <div class="hidden md:block">
                    <div class="space-y-8">
                        <!-- Logo & Heading -->
                        <div class="space-y-6">
                            <div class="inline-block">
                                <img src="{{ asset('assets/logo.png') }}" alt="{{ site_name() }}" class="h-20">
                            </div>
                            
                            <div class="space-y-3">
                                <h2 class="text-5xl font-bold text-gray-900 leading-tight">
                                    Start Your <span class="text-primary">Journey!</span>
                                </h2>
                                <div class="w-20 h-1 bg-primary rounded-full"></div>
                            </div>
                            
                            <p class="text-gray-600 text-lg leading-relaxed max-w-md">
                                Create your account today and take the first step towards owning your dream plot.
                            </p>
                        </div>

                        <!-- Benefits Cards -->
                        <div class="space-y-4 pt-4">
                            <div class="bg-gradient-to-br from-green-50 to-white p-5 rounded-xl border border-green-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-primary to-primary-dark rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-shield-check text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">100% Secure</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">All plots are legally verified with clear documentation</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-blue-50 to-white p-5 rounded-xl border border-blue-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-percentage text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">Flexible Payment</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">Easy installment plans tailored to your budget</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="bg-gradient-to-br from-purple-50 to-white p-5 rounded-xl border border-purple-100 hover:shadow-md transition-all duration-300">
                                <div class="flex items-start space-x-4">
                                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                                        <i class="fas fa-headset text-white text-xl"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-gray-900 text-lg mb-1">24/7 Support</h4>
                                        <p class="text-sm text-gray-600 leading-relaxed">Always here to help you every step of the way</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Stats Banner -->
                        <div class="pt-6">
                            <div class="bg-gradient-to-r from-primary to-primary-dark p-6 rounded-2xl shadow-lg">
                                <div class="grid grid-cols-3 gap-4 text-white">
                                    <div>
                                        <div class="text-3xl font-bold mb-1">500+</div>
                                        <div class="text-xs text-green-100">Available Plots</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold mb-1">1000+</div>
                                        <div class="text-xs text-green-100">Happy Families</div>
                                    </div>
                                    <div>
                                        <div class="text-3xl font-bold mb-1">15+</div>
                                        <div class="text-xs text-green-100">Prime Locations</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Register Form -->
                <div class="w-full">
                    <div class="bg-white rounded-3xl shadow-2xl p-8 md:p-12">
                        <!-- Header -->
                        <div class="text-center mb-8">
                            <h1 class="text-3xl font-bold text-gray-900 mb-2">Create Account</h1>
                            <p class="text-gray-600">Fill in your details to get started</p>
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

                        <!-- Register Form -->
                        <form action="{{ route('register.submit') }}" method="POST" class="space-y-5">
                            @csrf

                            <!-- Full Name -->
                            <div>
                                <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Full Name
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="name" 
                                        name="name" 
                                        value="{{ old('name') }}"
                                        required
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('name') border-red-500 @enderror"
                                        placeholder="John Doe">
                                </div>
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

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

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Phone Number
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-gray-400"></i> +88
                                    </div>
                                    <input 
                                        type="tel" 
                                        id="phone" 
                                        name="phone" 
                                        value="{{ old('phone') }}"
                                        required
                                        pattern="^01[0-9]{9}$"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('phone') border-red-500 @enderror"
                                        placeholder="01XXXXXXXXX (11 digits)"
                                        style="padding-left: 4.5rem;"
                                        title="Phone number must start with 01 and be 11 digits">
                                </div>
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                                <p class="mt-1 text-xs text-gray-500">Must start with 01 and be 11 digits total</p>
                            </div>

                            <!-- Father's Name -->
                            <div>
                                <label for="father_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Father's Name 
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="father_name" 
                                        name="father_name" 
                                        value="{{ old('father_name') }}"
                                        required
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('father_name') border-red-500 @enderror"
                                        placeholder="Enter father's name">
                                </div>
                                @error('father_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Mother's Name -->
                            <div>
                                <label for="mother_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Mother's Name 
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="mother_name" 
                                        name="mother_name" 
                                        value="{{ old('mother_name') }}"
                                        required
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('mother_name') border-red-500 @enderror"
                                        placeholder="Enter mother's name">
                                </div>
                                @error('mother_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Spouse's Name -->
                            <div>
                                <label for="spouse_name" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Spouse's Name <span class="text-gray-400 font-normal">(Optional)</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="spouse_name" 
                                        name="spouse_name" 
                                        value="{{ old('spouse_name') }}"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('spouse_name') border-red-500 @enderror"
                                        placeholder="Enter spouse's name">
                                </div>
                                @error('spouse_name')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- NID -->
                            <div>
                                <label for="nid" class="block text-sm font-semibold text-gray-700 mb-2">
                                    National ID (NID) 
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-id-card text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="text" 
                                        id="nid" 
                                        name="nid" 
                                        value="{{ old('nid') }}"
                                        required
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('nid') border-red-500 @enderror"
                                        placeholder="Enter NID number">
                                </div>
                                @error('nid')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Address
                                </label>
                                <div class="relative">
                                    <div class="absolute top-3 left-0 pl-4 flex items-start pointer-events-none">
                                        <i class="fas fa-map-marker-alt text-gray-400"></i>
                                    </div>
                                    <textarea 
                                        id="address" 
                                        name="address" 
                                        required
                                        rows="3"
                                        class="w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition @error('address') border-red-500 @enderror"
                                        placeholder="Enter your full address">{{ old('address') }}</textarea>
                                </div>
                                @error('address')
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
                                        placeholder="Min. 8 characters">
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

                            <!-- Confirm Password -->
                            <div>
                                <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                    Confirm Password
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-gray-400"></i>
                                    </div>
                                    <input 
                                        type="password" 
                                        id="password_confirmation" 
                                        name="password_confirmation" 
                                        required
                                        class="w-full pl-12 pr-12 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent transition"
                                        placeholder="Re-enter password">
                                    <button 
                                        type="button" 
                                        onclick="togglePassword('password_confirmation')"
                                        class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-gray-600">
                                        <i class="fas fa-eye" id="password_confirmation-eye"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Terms -->
                            <div class="flex items-start">
                                <input 
                                    type="checkbox" 
                                    id="terms" 
                                    name="terms" 
                                    required
                                    class="w-4 h-4 text-primary border-gray-300 rounded focus:ring-primary mt-1">
                                <label for="terms" class="ml-2 text-sm text-gray-700">
                                    I agree to the 
                                    <a href="#" class="text-primary hover:text-primary-dark font-semibold">Terms & Conditions</a> 
                                    and 
                                    <a href="#" class="text-primary hover:text-primary-dark font-semibold">Privacy Policy</a>
                                </label>
                            </div>

                            <!-- Submit Button -->
                            <button 
                                type="submit"
                                class="w-full bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-4 rounded-lg font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary/30">
                                <i class="fas fa-user-plus mr-2"></i>
                                Create Account
                            </button>
                        </form>

                        <!-- Divider -->
                        <div class="relative my-6">
                            <div class="absolute inset-0 flex items-center">
                                <div class="w-full border-t border-gray-300"></div>
                            </div>
                            <div class="relative flex justify-center text-sm">
                                <span class="px-4 bg-white text-gray-500">or</span>
                            </div>
                        </div>

                        <!-- Login Link -->
                        <div class="text-center">
                            <p class="text-gray-600">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="font-bold text-primary hover:text-primary-dark transition">
                                    Sign In
                                </a>
                            </p>
                        </div>

                        <!-- Back to Home -->
                        <div class="text-center mt-4">
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
