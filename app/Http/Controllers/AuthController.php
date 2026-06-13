<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\PhoneVerification;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Show the login form
     */
    public function showLoginForm(Request $request)
    {
        // Store redirect URL in session if provided
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        }
        return view('Website.auth.login');
    }

    /**
     * Show the registration form
     */
    public function showRegisterForm(Request $request)
    {
        // Store redirect URL in session if provided
        if ($request->has('redirect')) {
            session(['url.intended' => $request->redirect]);
        }
        return view('Website.auth.register');
    }

    /**
     * Handle user login
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            $user = Auth::user();

            // Redirect based on user role
            if ($user->isAdmin()) {
                return redirect()->intended(route('admin.dashboard'));
            } elseif ($user->isCommissionUser()) {
                return redirect()->intended(route('commission.dashboard'));
            } else {
                return redirect()->intended(route('account.dashboard'));
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Step 1: Validate registration data and send OTP
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => ['required', 'string', 'regex:/^01[0-9]{9}$/', 'unique:users'],
            'father_name' => 'required|string|max:255',
            'mother_name' => 'required|string|max:255',
            'spouse_name' => 'nullable|string|max:255',
            'nid' => 'required|string|max:50',
            'address' => 'required|string|max:500',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'required|accepted',
        ], [
            'phone.regex' => 'Phone number must start with 01 and be 11 digits.',
        ]);

        // Store registration data in session
        session(['registration_data' => $validated]);

        // Generate and send OTP
        $code = SmsService::generateOtpCode();
        
        // Delete old verification codes for this phone
        PhoneVerification::where('phone', $validated['phone'])
            ->where('type', 'registration')
            ->delete();

        // Create new verification record
        PhoneVerification::create([
            'phone' => $validated['phone'],
            'code' => $code,
            'type' => 'registration',
            'expires_at' => now()->addMinutes(5),
        ]);

        // Send OTP via SMS
        $this->smsService->sendOtp($validated['phone'], $code);

        return redirect()->route('verify.phone')->with('success', 'Verification code sent to your phone number.');
    }

    /**
     * Show phone verification form
     */
    public function showVerifyPhoneForm()
    {
        if (!session('registration_data')) {
            return redirect()->route('register')->with('error', 'Please complete registration first.');
        }

        $phone = session('registration_data')['phone'];

        return view('Website.auth.verify-phone', compact('phone'));
    }

    /**
     * Verify phone OTP and complete registration
     */
    public function verifyPhone(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:4',
        ]);

        $registrationData = session('registration_data');
        
        if (!$registrationData) {
            return redirect()->route('register')->with('error', 'Registration session expired. Please try again.');
        }

        $verification = PhoneVerification::where('phone', $registrationData['phone'])
            ->where('type', 'registration')
            ->active()
            ->latest()
            ->first();

        if (!$verification || !$verification->isValid($request->code)) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        // Mark as verified
        $verification->markAsVerified();

        // Create user
        $user = User::create([
            'name' => $registrationData['name'],
            'email' => $registrationData['email'],
            'phone' => $registrationData['phone'],
            'father_name' => $registrationData['father_name'],
            'mother_name' => $registrationData['mother_name'],
            'spouse_name' => $registrationData['spouse_name'] ?? null,
            'nid' => $registrationData['nid'],
            'address' => $registrationData['address'],
            'password' => Hash::make($registrationData['password']),
            'role' => 'user',
            'status' => 'active',
        ]);

        // Clear session
        session()->forget('registration_data');

        // Log the user in
        Auth::login($user);

        return redirect()->intended(route('account.dashboard'))->with('success', 'Your account has been created successfully!');
    }

    /**
     * Resend OTP for registration
     */
    public function resendOtp()
    {
        $registrationData = session('registration_data');
        
        if (!$registrationData) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please register again.'], 400);
        }

        // Check if last OTP was sent within 60 seconds
        $lastVerification = PhoneVerification::where('phone', $registrationData['phone'])
            ->where('type', 'registration')
            ->latest()
            ->first();

        if ($lastVerification && $lastVerification->created_at->diffInSeconds(now()) < 60) {
            return response()->json(['success' => false, 'message' => 'Please wait before requesting a new code.'], 429);
        }

        // Generate and send new OTP
        $code = SmsService::generateOtpCode();
        
        PhoneVerification::where('phone', $registrationData['phone'])
            ->where('type', 'registration')
            ->delete();

        PhoneVerification::create([
            'phone' => $registrationData['phone'],
            'code' => $code,
            'type' => 'registration',
            'expires_at' => now()->addMinutes(5),
        ]);

        $this->smsService->sendOtp($registrationData['phone'], $code);

        return response()->json(['success' => true, 'message' => 'Verification code sent successfully.']);
    }

    /**
     * Show forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('Website.auth.forgot-password');
    }

    /**
     * Send password reset OTP
     */
    public function sendPasswordResetOtp(Request $request)
    {
        $request->validate([
            'phone' => ['required', 'string', 'regex:/^01[0-9]{9}$/'],
        ], [
            'phone.regex' => 'Phone number must start with 01 and be 11 digits.',
        ]);

        $user = User::where('phone', $request->phone)->first();

        if (!$user) {
            return back()->withErrors(['phone' => 'No account found with this phone number.']);
        }

        // Generate and send OTP
        $code = SmsService::generateOtpCode();
        
        PhoneVerification::where('phone', $request->phone)
            ->where('type', 'password_reset')
            ->delete();

        PhoneVerification::create([
            'phone' => $request->phone,
            'code' => $code,
            'type' => 'password_reset',
            'expires_at' => now()->addMinutes(5),
        ]);

        $this->smsService->sendPasswordResetOtp($request->phone, $code);

        session(['password_reset_phone' => $request->phone]);

        return redirect()->route('password.verify')->with('success', 'Verification code sent to your phone number.');
    }

    /**
     * Show password reset verification form
     */
    public function showPasswordVerifyForm()
    {
        if (!session('password_reset_phone')) {
            return redirect()->route('password.request')->with('error', 'Please enter your phone number first.');
        }

        $phone = session('password_reset_phone');

        return view('Website.auth.verify-password-reset', compact('phone'));
    }

    /**
     * Verify password reset OTP
     */
    public function verifyPasswordReset(Request $request)
    {
        $request->validate([
            'code' => 'required|string|size:4',
        ]);

        $phone = session('password_reset_phone');
        
        if (!$phone) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        $verification = PhoneVerification::where('phone', $phone)
            ->where('type', 'password_reset')
            ->active()
            ->latest()
            ->first();

        if (!$verification || !$verification->isValid($request->code)) {
            return back()->withErrors(['code' => 'Invalid or expired verification code.']);
        }

        $verification->markAsVerified();

        session(['password_reset_verified' => true]);

        return redirect()->route('password.reset');
    }

    /**
     * Show reset password form
     */
    public function showResetPasswordForm()
    {
        if (!session('password_reset_phone') || !session('password_reset_verified')) {
            return redirect()->route('password.request')->with('error', 'Please verify your phone number first.');
        }

        return view('Website.auth.reset-password');
    }

    /**
     * Reset password
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $phone = session('password_reset_phone');
        
        if (!$phone || !session('password_reset_verified')) {
            return redirect()->route('password.request')->with('error', 'Session expired. Please try again.');
        }

        $user = User::where('phone', $phone)->first();
        
        if (!$user) {
            return redirect()->route('password.request')->with('error', 'User not found.');
        }

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Clear session
        session()->forget(['password_reset_phone', 'password_reset_verified']);

        return redirect()->route('login')->with('success', 'Password reset successfully. Please login with your new password.');
    }

    /**
     * Resend password reset OTP
     */
    public function resendPasswordResetOtp()
    {
        $phone = session('password_reset_phone');
        
        if (!$phone) {
            return response()->json(['success' => false, 'message' => 'Session expired. Please try again.'], 400);
        }

        // Check if last OTP was sent within 60 seconds
        $lastVerification = PhoneVerification::where('phone', $phone)
            ->where('type', 'password_reset')
            ->latest()
            ->first();

        if ($lastVerification && $lastVerification->created_at->diffInSeconds(now()) < 60) {
            return response()->json(['success' => false, 'message' => 'Please wait before requesting a new code.'], 429);
        }

        $code = SmsService::generateOtpCode();
        
        PhoneVerification::where('phone', $phone)
            ->where('type', 'password_reset')
            ->delete();

        PhoneVerification::create([
            'phone' => $phone,
            'code' => $code,
            'type' => 'password_reset',
            'expires_at' => now()->addMinutes(5),
        ]);

        $this->smsService->sendPasswordResetOtp($phone, $code);

        return response()->json(['success' => true, 'message' => 'Verification code sent successfully.']);
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'You have been logged out successfully!');
    }
}
