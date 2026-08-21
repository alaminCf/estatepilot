@extends('Website.layouts.app')

@section('title', 'Verify Phone - ' . site_name())

@section('content')
    <!-- Verify Phone Section -->
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
                        <i class="fas fa-mobile-alt text-white text-3xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Verify Your Phone</h1>
                    <p class="text-gray-600">We've sent a 4-digit code to</p>
                    <p class="text-primary font-semibold text-lg mt-1">+88{{ $phone }}</p>
                </div>

                <!-- Success Message -->
                @if(session('success'))
                    <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                        <div class="flex items-center">
                            <i class="fas fa-check-circle text-green-500 mr-3"></i>
                            <span class="text-sm text-green-600">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <i class="fas fa-exclamation-circle text-red-500 mr-3 mt-0.5"></i>
                            <div class="text-sm text-red-600">
                                @foreach ($errors->all() as $error)
                                    {{ $error }}<br>
                                @endforeach
                            </div>
                        </div>
                    </div>
                @endif

                <!-- OTP Form -->
                <form action="{{ route('verify.phone.submit') }}" method="POST" id="otpForm">
                    @csrf

                    <!-- OTP Input -->
                    <div class="mb-6">
                        <label class="block text-sm font-semibold text-gray-700 mb-3 text-center">
                            Enter Verification Code
                        </label>
                        
                        <!-- Success/Error Message -->
                        <div id="resendMessage" class="hidden mb-4 p-3 rounded-lg text-center text-sm font-medium"></div>
                        
                        <div class="flex justify-center gap-3" id="otpInputs">
                            @for($i = 0; $i < 4; $i++)
                                <input 
                                    type="text" 
                                    maxlength="1" 
                                    class="otp-input w-14 h-16 text-center text-3xl font-bold border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-primary transition"
                                    data-index="{{ $i }}"
                                    inputmode="numeric"
                                    pattern="[0-9]"
                                    autocomplete="off">
                            @endfor
                        </div>
                        <input type="hidden" name="code" id="otpCode">
                    </div>

                    <!-- Submit Button -->
                    <button 
                        type="submit"
                        id="submitBtn"
                        class="w-full bg-gradient-to-r from-primary to-primary-dark text-white px-6 py-4 rounded-lg font-bold text-lg hover:shadow-xl transition-all duration-300 transform hover:scale-105 shadow-lg shadow-primary/30">
                        <i class="fas fa-check-circle mr-2"></i>
                        Verify Phone
                    </button>
                </form>

                <!-- Resend Code -->
                <div class="text-center mt-6">
                    <p class="text-gray-600 text-sm mb-2">Didn't receive the code?</p>
                    <button 
                        type="button" 
                        id="resendBtn"
                        onclick="resendOtp()"
                        class="text-primary hover:text-primary-dark font-semibold transition disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-redo mr-1"></i>
                        Resend Code
                    </button>
                    <p id="resendTimer" class="text-gray-500 text-xs mt-1 hidden">
                        Wait <span id="resendSeconds">60</span> seconds to resend
                    </p>
                </div>

                <!-- Back Link -->
                <div class="text-center mt-6">
                    <a href="{{ route('register') }}" class="text-sm text-gray-500 hover:text-gray-700 transition inline-flex items-center">
                        <i class="fas fa-arrow-left mr-2"></i>
                        Back to Registration
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // OTP Input handling
    const inputs = document.querySelectorAll('.otp-input');
    const otpCode = document.getElementById('otpCode');
    
    inputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            const value = e.target.value;
            
            // Only allow numbers
            if (!/^\d*$/.test(value)) {
                e.target.value = '';
                return;
            }
            
            // Move to next input
            if (value && index < inputs.length - 1) {
                inputs[index + 1].focus();
            }
            
            updateHiddenInput();
        });
        
        input.addEventListener('keydown', (e) => {
            // Handle backspace
            if (e.key === 'Backspace' && !e.target.value && index > 0) {
                inputs[index - 1].focus();
            }
        });
        
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/\D/g, '').slice(0, 6);
            
            pastedData.split('').forEach((char, i) => {
                if (inputs[i]) {
                    inputs[i].value = char;
                }
            });
            
            updateHiddenInput();
            
            if (pastedData.length >= 4) {
                inputs[3].focus();
            }
        });
    });
    
    function updateHiddenInput() {
        let code = '';
        inputs.forEach(input => {
            code += input.value;
        });
        otpCode.value = code;
    }
    
    // Resend OTP functionality
    let resendCooldown = 60; // Start with 60 seconds on page load
    const resendBtn = document.getElementById('resendBtn');
    const resendTimer = document.getElementById('resendTimer');
    const resendSeconds = document.getElementById('resendSeconds');
    
    // Start initial countdown on page load
    resendBtn.style.display = 'none';
    resendTimer.classList.remove('hidden');
    
    const initialCooldown = setInterval(() => {
        resendCooldown--;
        resendSeconds.textContent = resendCooldown;
        
        if (resendCooldown <= 0) {
            clearInterval(initialCooldown);
            resendTimer.classList.add('hidden');
            resendBtn.style.display = 'inline-block';
        }
    }, 1000);
    
    function resendOtp() {
        if (resendCooldown > 0) return;
        
        const resendMessage = document.getElementById('resendMessage');
        
        // Hide resend button immediately
        resendBtn.style.display = 'none';
        
        fetch('{{ route("verify.phone.resend") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Start resend cooldown
                resendCooldown = 60;
                resendTimer.classList.remove('hidden');
                
                const cooldownInterval = setInterval(() => {
                    resendCooldown--;
                    resendSeconds.textContent = resendCooldown;
                    
                    if (resendCooldown <= 0) {
                        clearInterval(cooldownInterval);
                        resendTimer.classList.add('hidden');
                        resendBtn.style.display = 'inline-block';
                    }
                }, 1000);
                
                // Show success message
                resendMessage.textContent = 'Verification code sent successfully!';
                resendMessage.className = 'mb-4 p-3 rounded-lg text-center text-sm font-medium bg-green-100 text-green-700 border border-green-300';
                resendMessage.classList.remove('hidden');
                
                // Hide message after 5 seconds
                setTimeout(() => {
                    resendMessage.classList.add('hidden');
                }, 5000);
            } else {
                // Show error message
                resendMessage.textContent = data.message || 'Failed to send code. Please try again.';
                resendMessage.className = 'mb-4 p-3 rounded-lg text-center text-sm font-medium bg-red-100 text-red-700 border border-red-300';
                resendMessage.classList.remove('hidden');
                
                resendBtn.style.display = 'inline-block';
                
                setTimeout(() => {
                    resendMessage.classList.add('hidden');
                }, 5000);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            resendMessage.textContent = 'An error occurred. Please try again.';
            resendMessage.className = 'mb-4 p-3 rounded-lg text-center text-sm font-medium bg-red-100 text-red-700 border border-red-300';
            resendMessage.classList.remove('hidden');
            
            resendBtn.style.display = 'inline-block';
            
            setTimeout(() => {
                resendMessage.classList.add('hidden');
            }, 5000);
        });
    }
    
    // Form submission
    document.getElementById('otpForm').addEventListener('submit', function(e) {
        if (otpCode.value.length !== 4) {
            e.preventDefault();
            alert('Please enter the complete 4-digit code.');
        }
    });
</script>
@endpush
