@extends('Website.commission.layouts.account')

@section('title', 'My Profile - Commission User Panel')

@section('commission_content')
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-2">My Profile</h1>
        <p class="text-gray-600">Manage your account information and settings</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4 flex items-center gap-3">
            <i class="fas fa-check-circle text-green-600 text-xl"></i>
            <p class="text-green-800 font-medium">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Error Messages -->
    @if($errors->any())
        <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
            <div class="flex items-center gap-3 mb-2">
                <i class="fas fa-exclamation-circle text-red-600 text-xl"></i>
                <p class="text-red-800 font-semibold">Please fix the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-red-700 space-y-1 ml-8">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <div class="text-center">
                    <div class="w-24 h-24 rounded-full overflow-hidden mx-auto mb-4 border-4 border-white shadow-lg">
                        <img src="{{ auth()->user()->profile_image_url }}" alt="{{ auth()->user()->name }}" class="w-full h-full object-cover">
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-1">{{ auth()->user()->name }}</h3>
                    <p class="text-sm text-gray-600 mb-4">{{ auth()->user()->email }}</p>
                    <div class="inline-flex items-center px-3 py-1 bg-purple-100 text-purple-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-user-tie mr-1"></i>
                        Agent Account
                    </div>
                </div>

                <hr class="my-6">

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Member Since:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Referral Code:</span>
                        <span class="font-bold text-purple-600">{{ auth()->user()->referral_code }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Commission Rate:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->commission_rate ?? 0 }}%</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Status:</span>
                        @if(auth()->user()->status == 'active')
                            <span class="inline-flex items-center px-2 py-1 bg-green-100 text-green-700 rounded text-xs font-semibold">
                                <i class="fas fa-check-circle mr-1"></i> Active
                            </span>
                        @else
                            <span class="inline-flex items-center px-2 py-1 bg-red-100 text-red-700 rounded text-xs font-semibold">
                                <i class="fas fa-times-circle mr-1"></i> Inactive
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Referral Code Box -->
            <div class="bg-gradient-to-br from-purple-600 to-purple-800 rounded-xl shadow-sm p-6 mt-6 text-white">
                <h3 class="font-bold mb-2">Your Referral Code</h3>
                <p class="text-purple-100 text-sm mb-4">Share this code with customers</p>
                <div class="bg-white/20 rounded-lg px-4 py-3 text-center">
                    <span class="text-2xl font-bold tracking-widest">{{ auth()->user()->referral_code }}</span>
                </div>
                <button onclick="copyCode()" class="w-full mt-4 bg-white text-purple-600 rounded-lg py-2 font-semibold hover:bg-purple-50 transition">
                    <i class="fas fa-copy mr-2"></i> Copy Code
                </button>
            </div>
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>

                <form action="{{ route('commission.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Profile Photo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Profile Photo
                        </label>
                        <div class="flex items-center space-x-4">
                            <div class="w-20 h-20 rounded-full overflow-hidden border-2 border-gray-300">
                                <img id="photo-preview" src="{{ auth()->user()->profile_image_url }}" alt="Profile" class="w-full h-full object-cover">
                            </div>
                            <div class="flex-1">
                                <input type="file" 
                                       id="photo" 
                                       name="photo" 
                                       accept="image/jpeg,image/jpg,image/png"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-600 file:text-white hover:file:bg-purple-700 @error('photo') border-red-500 @enderror"
                                       onchange="previewPhoto(event)">
                                <p class="mt-1 text-xs text-gray-500">JPG, JPEG or PNG. Max 2MB.</p>
                                @error('photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Name -->
                    <div>
                        <label for="name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Full Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" 
                               id="name" 
                               name="name" 
                               value="{{ old('name', auth()->user()->name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('name') border-red-500 @enderror" 
                               required>
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-semibold text-gray-700 mb-2">
                            Email Address <span class="text-red-500">*</span>
                        </label>
                        <input type="email" 
                               id="email" 
                               name="email" 
                               value="{{ old('email', auth()->user()->email) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('email') border-red-500 @enderror" 
                               required>
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Phone -->
                    <div>
                        <label for="phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Phone Number
                        </label>
                        <input type="text" 
                               id="phone" 
                               name="phone" 
                               value="{{ old('phone', auth()->user()->phone) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('phone') border-red-500 @enderror" 
                               placeholder="+880 1XXX-XXXXXX">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Father's Name -->
                    <div>
                        <label for="father_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Father's Name
                        </label>
                        <input type="text" 
                               id="father_name" 
                               name="father_name" 
                               value="{{ old('father_name', auth()->user()->father_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('father_name') border-red-500 @enderror" 
                               placeholder="Enter father's name">
                        @error('father_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Mother's Name -->
                    <div>
                        <label for="mother_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Mother's Name
                        </label>
                        <input type="text" 
                               id="mother_name" 
                               name="mother_name" 
                               value="{{ old('mother_name', auth()->user()->mother_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('mother_name') border-red-500 @enderror" 
                               placeholder="Enter mother's name">
                        @error('mother_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- NID -->
                    <div>
                        <label for="nid" class="block text-sm font-semibold text-gray-700 mb-2">
                            National ID (NID)
                        </label>
                        <input type="text" 
                               id="nid" 
                               name="nid" 
                               value="{{ old('nid', auth()->user()->nid) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('nid') border-red-500 @enderror" 
                               placeholder="Enter NID number">
                        @error('nid')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-200">

                    <h3 class="text-lg font-semibold text-gray-900">Change Password</h3>
                    <p class="text-sm text-gray-500 -mt-4">Leave blank if you don't want to change your password</p>

                    <!-- Current Password -->
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('current_password') border-red-500 @enderror" 
                               placeholder="Enter current password to change">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- New Password -->
                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                            </label>
                            <input type="password" 
                                   id="password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent @error('password') border-red-500 @enderror" 
                                   placeholder="New password">
                            @error('password')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Confirm New Password
                            </label>
                            <input type="password" 
                                   id="password_confirmation" 
                                   name="password_confirmation" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent" 
                                   placeholder="Confirm new password">
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="pt-4">
                        <button type="submit" 
                                class="w-full md:w-auto px-8 py-3 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold transition-colors duration-300">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function copyCode() {
            const code = '{{ auth()->user()->referral_code }}';
            navigator.clipboard.writeText(code).then(() => {
                alert('Referral code copied to clipboard!');
            });
        }

        function previewPhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById('photo-preview').src = e.target.result;
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
