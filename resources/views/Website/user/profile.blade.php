@extends('Website.user.layouts.account')

@section('title', 'My Profile - London Abason')

@section('account_content')
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
                    <div class="inline-flex items-center px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-semibold">
                        <i class="fas fa-check-circle mr-1"></i>
                        Verified Account
                    </div>
                </div>

                <hr class="my-6">

                <div class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Client ID:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->formatted_client_id ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Emergency Contact:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->emergency_phone ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">NID:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->nid ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Father's Name:</span>
                        <span class="font-semibold text-gray-900 text-xs">{{ auth()->user()->father_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Mother's Name:</span>
                        <span class="font-semibold text-gray-900 text-xs">{{ auth()->user()->mother_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Spouse's Name:</span>
                        <span class="font-semibold text-gray-900 text-xs">{{ auth()->user()->spouse_name ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-start justify-between">
                        <span class="text-gray-600">Address:</span>
                        <span class="font-semibold text-gray-900 text-xs text-right max-w-[60%]">{{ auth()->user()->address ?? 'N/A' }}</span>
                    </div>
                    <div class="flex items-center justify-between pt-2 border-t">
                        <span class="text-gray-600">Member Since:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Role:</span>
                        <span class="font-semibold text-gray-900">{{ ucfirst(auth()->user()->role) }}</span>
                    </div>
                </div>
            </div>

            <!-- Nominee Info Card -->
            @if(auth()->user()->nominee_name)
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4"><i class="fas fa-user-shield text-primary mr-2"></i>Nominee Info</h3>
                <div class="space-y-3 text-sm">
                    @if(auth()->user()->nominee_photo)
                        <div class="flex justify-center mb-3">
                            <div class="w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-200">
                                <img src="{{ asset(auth()->user()->nominee_photo) }}" alt="Nominee" class="w-full h-full object-cover">
                            </div>
                        </div>
                    @endif
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Name:</span>
                        <span class="font-semibold text-gray-900 text-xs">{{ auth()->user()->nominee_name }}</span>
                    </div>
                    @if(auth()->user()->nominee_nid)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">NID:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->nominee_nid }}</span>
                    </div>
                    @endif
                    @if(auth()->user()->nominee_relation)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-600">Relation:</span>
                        <span class="font-semibold text-gray-900">{{ auth()->user()->nominee_relation }}</span>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Profile Form -->
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Personal Information</h2>

                <form action="{{ route('account.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
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
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark @error('photo') border-red-500 @enderror"
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('name') border-red-500 @enderror" 
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('email') border-red-500 @enderror" 
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('phone') border-red-500 @enderror" 
                               placeholder="+880 1XXX-XXXXXX">
                        @error('phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Emergency Contact Phone -->
                    <div>
                        <label for="emergency_phone" class="block text-sm font-semibold text-gray-700 mb-2">
                            Emergency Contact Phone <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <input type="text" 
                               id="emergency_phone" 
                               name="emergency_phone" 
                               value="{{ old('emergency_phone', auth()->user()->emergency_phone) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('emergency_phone') border-red-500 @enderror" 
                               placeholder="+880 1XXX-XXXXXX">
                        @error('emergency_phone')
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('father_name') border-red-500 @enderror" 
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('mother_name') border-red-500 @enderror" 
                               placeholder="Enter mother's name">
                        @error('mother_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Spouse's Name -->
                    <div>
                        <label for="spouse_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Spouse's Name <span class="text-gray-400 font-normal">(Optional)</span>
                        </label>
                        <input type="text" 
                               id="spouse_name" 
                               name="spouse_name" 
                               value="{{ old('spouse_name', auth()->user()->spouse_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('spouse_name') border-red-500 @enderror" 
                               placeholder="Enter spouse's name">
                        @error('spouse_name')
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
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nid') border-red-500 @enderror" 
                               placeholder="Enter NID number">
                        @error('nid')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Address -->
                    <div>
                        <label for="address" class="block text-sm font-semibold text-gray-700 mb-2">
                            Address
                        </label>
                        <textarea id="address" 
                               name="address" 
                               rows="3"
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('address') border-red-500 @enderror" 
                               placeholder="Enter your full address">{{ old('address', auth()->user()->address) }}</textarea>
                        @error('address')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <hr class="border-gray-200">

                    <!-- Nominee Information Section -->
                    <h2 class="text-xl font-bold text-gray-900">Nominee Information</h2>

                    <!-- Nominee Name -->
                    <div>
                        <label for="nominee_name" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nominee Name
                        </label>
                        <input type="text" 
                               id="nominee_name" 
                               name="nominee_name" 
                               value="{{ old('nominee_name', auth()->user()->nominee_name) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nominee_name') border-red-500 @enderror" 
                               placeholder="Enter nominee's full name">
                        @error('nominee_name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominee NID -->
                    <div>
                        <label for="nominee_nid" class="block text-sm font-semibold text-gray-700 mb-2">
                            Nominee NID
                        </label>
                        <input type="text" 
                               id="nominee_nid" 
                               name="nominee_nid" 
                               value="{{ old('nominee_nid', auth()->user()->nominee_nid) }}" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nominee_nid') border-red-500 @enderror" 
                               placeholder="Enter nominee's NID number">
                        @error('nominee_nid')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominee Relation -->
                    <div>
                        <label for="nominee_relation" class="block text-sm font-semibold text-gray-700 mb-2">
                            Relation with Nominee
                        </label>
                        <select id="nominee_relation" 
                                name="nominee_relation" 
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('nominee_relation') border-red-500 @enderror">
                            <option value="">Select Relation</option>
                            @foreach(['Spouse', 'Father', 'Mother', 'Son', 'Daughter', 'Brother', 'Sister', 'Other'] as $relation)
                                <option value="{{ $relation }}" {{ old('nominee_relation', auth()->user()->nominee_relation) == $relation ? 'selected' : '' }}>{{ $relation }}</option>
                            @endforeach
                        </select>
                        @error('nominee_relation')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Nominee Photo -->
                    <div>
                        <label class="block text-sm font-semibold text-gray-700 mb-2">
                            Nominee Photo
                        </label>
                        <div class="flex items-center space-x-4">
                            @if(auth()->user()->nominee_photo)
                                <div class="w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-300">
                                    <img id="nominee-photo-preview" src="{{ asset(auth()->user()->nominee_photo) }}" alt="Nominee Photo" class="w-full h-full object-cover">
                                </div>
                            @else
                                <div class="w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-300 flex items-center justify-center bg-gray-100">
                                    <img id="nominee-photo-preview" src="" alt="Nominee Photo" class="w-full h-full object-cover hidden">
                                    <i class="fas fa-user text-gray-400 text-2xl" id="nominee-photo-placeholder"></i>
                                </div>
                            @endif
                            <div class="flex-1">
                                <input type="file" 
                                       id="nominee_photo" 
                                       name="nominee_photo" 
                                       accept="image/jpeg,image/jpg,image/png"
                                       class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-primary file:text-white hover:file:bg-primary-dark @error('nominee_photo') border-red-500 @enderror"
                                       onchange="previewNomineePhoto(event)">
                                <p class="mt-1 text-xs text-gray-500">JPG, JPEG or PNG. Max 2MB.</p>
                                @error('nominee_photo')
                                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="flex items-center gap-4 pt-4">
                        <button type="submit" 
                                class="flex-1 bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                            <i class="fas fa-save mr-2"></i>
                            Save Changes
                        </button>
                        <a href="{{ route('account.dashboard') }}" 
                           class="px-8 py-3 border-2 border-gray-300 text-gray-700 rounded-lg font-semibold hover:bg-gray-50 transition">
                            Cancel
                        </a>
                    </div>
                </form>
            </div>

            <!-- Change Password Card -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mt-6">
                <h2 class="text-xl font-bold text-gray-900 mb-6"><i class="fas fa-lock text-primary mr-2"></i>Change Password</h2>
                <form action="{{ route('account.password.change') }}" method="POST" class="space-y-5">
                    @csrf
                    <div>
                        <label for="current_password" class="block text-sm font-semibold text-gray-700 mb-2">
                            Current Password
                        </label>
                        <input type="password" 
                               id="current_password" 
                               name="current_password" 
                               class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('current_password') border-red-500 @enderror" 
                               placeholder="Enter current password">
                        @error('current_password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-4">
                        <div>
                            <label for="new_password" class="block text-sm font-semibold text-gray-700 mb-2">
                                New Password
                            </label>
                            <input type="password" 
                                   id="new_password" 
                                   name="password" 
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent @error('password') border-red-500 @enderror" 
                                   placeholder="Min 8 characters">
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
                                   class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent" 
                                   placeholder="Repeat new password">
                        </div>
                    </div>

                    <div class="pt-2">
                        <button type="submit" 
                                class="bg-primary text-white px-8 py-3 rounded-lg font-semibold hover:bg-primary-dark transition shadow-lg">
                            <i class="fas fa-lock mr-2"></i>Update Password
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
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

        function previewNomineePhoto(event) {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('nominee-photo-preview');
                    const placeholder = document.getElementById('nominee-photo-placeholder');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                    if (placeholder) placeholder.classList.add('hidden');
                }
                reader.readAsDataURL(file);
            }
        }
    </script>
@endsection
