<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CommissionUserController;
use App\Http\Controllers\Admin\CommissionPayoutController;
use App\Http\Controllers\Admin\PlotController;
use App\Http\Controllers\Admin\BookingController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\PlatformUserController;
use App\Http\Controllers\Website\PlotController as WebsitePlotController;
use App\Http\Controllers\Website\HomeController;
use App\Http\Controllers\Website\BookingController as WebsiteBookingController;
use App\Http\Controllers\Website\UserController as WebsiteUserController;
use App\Http\Controllers\Website\CommissionPanelController;

// ================================
// Authentication Routes
// ================================
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.submit');
    
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.submit');
    
    // Phone Verification
    Route::get('/verify-phone', [AuthController::class, 'showVerifyPhoneForm'])->name('verify.phone');
    Route::post('/verify-phone', [AuthController::class, 'verifyPhone'])->name('verify.phone.submit');
    Route::post('/verify-phone/resend', [AuthController::class, 'resendOtp'])->name('verify.phone.resend');
    
    // Forgot Password
    Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('password.request');
    Route::post('/forgot-password', [AuthController::class, 'sendPasswordResetOtp'])->name('password.phone');
    Route::get('/forgot-password/verify', [AuthController::class, 'showPasswordVerifyForm'])->name('password.verify');
    Route::post('/forgot-password/verify', [AuthController::class, 'verifyPasswordReset'])->name('password.verify.submit');
    Route::post('/forgot-password/resend', [AuthController::class, 'resendPasswordResetOtp'])->name('password.resend');
    Route::get('/reset-password', [AuthController::class, 'showResetPasswordForm'])->name('password.reset');
    Route::post('/reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// ================================
// Public Routes
// ================================
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/about', function () {
    return view('Website.about');
})->name('about');

Route::get('/faq', function () {
    return view('Website.faq');
})->name('faq');

Route::get('/contact', function () {
    return view('Website.contact');
})->name('contact');

Route::post('/contact', [App\Http\Controllers\Website\ContactController::class, 'submit'])->name('contact.submit');

Route::get('/plots', [WebsitePlotController::class, 'index'])->name('plots.index');
Route::get('/plots/{id}', [WebsitePlotController::class, 'show'])->name('plot.details');

// ================================
// User Account Area
// ================================
Route::prefix('my-account')->name('account.')->middleware(['auth', 'user'])->group(function () {
    Route::get('/', [WebsiteUserController::class, 'dashboard'])->name('dashboard');
    Route::get('/bookings', [WebsiteUserController::class, 'bookings'])->name('bookings');
    Route::get('/bookings/{booking}', [WebsiteUserController::class, 'bookingShow'])->name('bookings.show');
    Route::get('/payments', [WebsiteUserController::class, 'payments'])->name('payments');
    Route::get('/payments/{payment}/invoice', [WebsiteUserController::class, 'paymentInvoice'])->name('payments.invoice');
    Route::get('/profile', [WebsiteUserController::class, 'profile'])->name('profile');
    Route::put('/profile', [WebsiteUserController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [WebsiteUserController::class, 'changePassword'])->name('password.change');

    // Booking Edit (only pending bookings)
    Route::get('/bookings/{booking}/edit', [WebsiteBookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [WebsiteBookingController::class, 'update'])->name('bookings.update');
});

// Bookings
Route::post('/bookings', [WebsiteBookingController::class, 'store'])->middleware('auth')->name('bookings.store');



// ================================
// Admin Routes
// ================================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');

    // Plot Management
    Route::middleware('permission:manage_plots')->group(function () {
        Route::resource('plots', PlotController::class)
            ->middlewareFor(['index', 'show'], 'permission:manage_plots,view')
            ->middlewareFor(['create', 'store'], 'permission:manage_plots,add')
            ->middlewareFor(['edit', 'update'], 'permission:manage_plots,edit')
            ->middlewareFor('destroy', 'permission:manage_plots,delete');
        Route::patch('plots/{plot}/update-status', [PlotController::class, 'updateStatus'])
            ->middleware('permission:manage_plots,edit')->name('plots.update-status');
    });

    // Booking Management
    Route::middleware('permission:manage_bookings')->group(function () {
        Route::get('bookings/export', [BookingController::class, 'export'])
            ->middleware('permission:manage_bookings,view')->name('bookings.export');
        Route::patch('bookings/{booking}/update-quick', [BookingController::class, 'updateQuick'])
            ->middleware('permission:manage_bookings,edit')->name('bookings.update-quick');
        Route::patch('bookings/{booking}/update-booking-date', [BookingController::class, 'updateBookingDate'])
            ->middleware('permission:manage_bookings,edit')->name('bookings.update-booking-date');
        Route::patch('bookings/{booking}/change-agent', [BookingController::class, 'changeAgent'])
            ->middleware('permission:manage_bookings,edit')->name('bookings.change-agent');
        Route::patch('bookings/{booking}/update-owners', [BookingController::class, 'updateOwners'])
            ->middleware('permission:manage_bookings,edit')->name('bookings.update-owners');
        Route::patch('bookings/{booking}/update-id', [BookingController::class, 'updateBookingId'])
            ->middleware('permission:manage_bookings,edit')->name('bookings.update-id');
        Route::resource('bookings', BookingController::class)->except(['edit'])
            ->middlewareFor(['index', 'show'], 'permission:manage_bookings,view')
            ->middlewareFor(['create', 'store'], 'permission:manage_bookings,add')
            ->middlewareFor('update', 'permission:manage_bookings,edit')
            ->middlewareFor('destroy', 'permission:manage_bookings,delete');
    });

    // Users Management
    Route::middleware('permission:manage_customers')->group(function () {
        Route::resource('users', UserController::class)
            ->middlewareFor(['index', 'show'], 'permission:manage_customers,view')
            ->middlewareFor(['create', 'store'], 'permission:manage_customers,add')
            ->middlewareFor(['edit', 'update'], 'permission:manage_customers,edit')
            ->middlewareFor('destroy', 'permission:manage_customers,delete');
        Route::patch('users/{user}/change-id', [UserController::class, 'changeId'])
            ->middleware('permission:manage_customers,edit')->name('users.change-id');
    });

    // Commission Users Management
    Route::middleware('permission:manage_commission_users')->group(function () {
        Route::resource('commission-users', CommissionUserController::class)
            ->middlewareFor(['index', 'show'], 'permission:manage_commission_users,view')
            ->middlewareFor(['create', 'store'], 'permission:manage_commission_users,add')
            ->middlewareFor(['edit', 'update'], 'permission:manage_commission_users,edit')
            ->middlewareFor('destroy', 'permission:manage_commission_users,delete');

        // Commission Payouts Management
        Route::get('commission-payouts', [CommissionPayoutController::class, 'index'])
            ->middleware('permission:manage_commission_users,view')->name('commission-payouts.index');
        Route::get('commission-payouts/export', [CommissionPayoutController::class, 'export'])
            ->middleware('permission:manage_commission_users,view')->name('commission-payouts.export');
        Route::get('commission-payouts/create', [CommissionPayoutController::class, 'create'])
            ->middleware('permission:manage_commission_users,add')->name('commission-payouts.create');
        Route::post('commission-payouts', [CommissionPayoutController::class, 'store'])
            ->middleware('permission:manage_commission_users,add')->name('commission-payouts.store');
        Route::delete('commission-payouts/{commissionPayout}', [CommissionPayoutController::class, 'destroy'])
            ->middleware('permission:manage_commission_users,delete')->name('commission-payouts.destroy');
        Route::get('commission-payouts/balance/{user}', [CommissionPayoutController::class, 'balance'])
            ->middleware('permission:manage_commission_users,view')->name('commission-payouts.balance');
    });

    // Payments Management
    Route::middleware('permission:manage_payments')->group(function () {
        Route::get('payments/export', [PaymentController::class, 'export'])
            ->middleware('permission:manage_payments,view')->name('payments.export');
        Route::get('payments/search-bookings', [PaymentController::class, 'searchBookings'])
            ->middleware('permission:manage_payments,add')->name('payments.search-bookings');
        Route::get('payments/booking-details/{booking}', [PaymentController::class, 'getBookingDetails'])
            ->middleware('permission:manage_payments,add')->name('payments.booking-details');
        Route::get('payments/{payment}/invoice', [PaymentController::class, 'invoice'])
            ->middleware('permission:manage_payments,view')->name('payments.invoice');
        Route::patch('payments/{payment}/update-date', [PaymentController::class, 'updateDate'])
            ->middleware('permission:manage_payments,edit')->name('payments.update-date');
        Route::resource('payments', PaymentController::class)->except(['edit', 'update'])
            ->middlewareFor(['index', 'show'], 'permission:manage_payments,view')
            ->middlewareFor(['create', 'store'], 'permission:manage_payments,add')
            ->middlewareFor('destroy', 'permission:manage_payments,delete');
    });
    
    // Profile Settings (always accessible)
    Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile.index');
    Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
    Route::put('/profile/password', [AdminProfileController::class, 'updatePassword'])->name('profile.update-password');
    
    // Platform Settings
    Route::middleware('permission:manage_settings')->group(function () {
        Route::get('/settings', [App\Http\Controllers\Admin\SettingController::class, 'index'])
            ->middleware('permission:manage_settings,view')->name('settings.index');
        Route::put('/settings/email', [App\Http\Controllers\Admin\SettingController::class, 'updateEmail'])
            ->middleware('permission:manage_settings,edit')->name('settings.update-email');
        Route::post('/settings/email/test', [App\Http\Controllers\Admin\SettingController::class, 'testEmail'])
            ->middleware('permission:manage_settings,edit')->name('settings.test-email');
        Route::put('/settings/platform', [App\Http\Controllers\Admin\SettingController::class, 'updatePlatform'])
            ->middleware('permission:manage_settings,edit')->name('settings.update-platform');
        Route::put('/settings/contact', [App\Http\Controllers\Admin\SettingController::class, 'updateContact'])
            ->middleware('permission:manage_settings,edit')->name('settings.update-contact');

        // Platform User Management
        Route::resource('platform-users', PlatformUserController::class)->except(['show'])
            ->middlewareFor('index', 'permission:manage_settings,view')
            ->middlewareFor(['create', 'store'], 'permission:manage_settings,add')
            ->middlewareFor(['edit', 'update'], 'permission:manage_settings,edit')
            ->middlewareFor('destroy', 'permission:manage_settings,delete');
    });

    // Reports (read-only — gated by the view action)
    Route::middleware(['permission:manage_reports', 'permission:manage_reports,view'])->group(function () {
        Route::get('reports/plots', [App\Http\Controllers\Admin\ReportController::class, 'plotsFilter'])->name('reports.plots');
        Route::get('reports/plots/generate', [App\Http\Controllers\Admin\ReportController::class, 'plotsReport'])->name('reports.plots.generate');
        Route::get('reports/bookings', [App\Http\Controllers\Admin\ReportController::class, 'bookingsFilter'])->name('reports.bookings');
        Route::get('reports/bookings/generate', [App\Http\Controllers\Admin\ReportController::class, 'bookingsReport'])->name('reports.bookings.generate');
        Route::get('reports/payments', [App\Http\Controllers\Admin\ReportController::class, 'paymentsFilter'])->name('reports.payments');
        Route::get('reports/payments/generate', [App\Http\Controllers\Admin\ReportController::class, 'paymentsReport'])->name('reports.payments.generate');
        Route::get('reports/agents', [App\Http\Controllers\Admin\ReportController::class, 'agentsFilter'])->name('reports.agents');
        Route::get('reports/agents/generate', [App\Http\Controllers\Admin\ReportController::class, 'agentsReport'])->name('reports.agents.generate');
    });
});



// ================================
// Commission User Account Area
// ================================
Route::prefix('commission')->name('commission.')->middleware(['auth', 'commission'])->group(function () {
    Route::get('/dashboard', [CommissionPanelController::class, 'dashboard'])->name('dashboard');
    Route::get('/sales', [CommissionPanelController::class, 'sales'])->name('sales');
    Route::get('/sales/{booking}/payment-detail', [CommissionPanelController::class, 'salePaymentDetail'])->name('sales.payment-detail');
    Route::get('/earnings', [CommissionPanelController::class, 'earnings'])->name('earnings');
    Route::get('/team', [CommissionPanelController::class, 'team'])->name('team');
    Route::get('/payouts', [CommissionPanelController::class, 'payouts'])->name('payouts');
    Route::get('/payouts/{commissionPayout}/invoice', [CommissionPanelController::class, 'payoutInvoice'])->name('payouts.invoice');
    Route::get('/profile', [CommissionPanelController::class, 'profile'])->name('profile');
    Route::put('/profile', [CommissionPanelController::class, 'updateProfile'])->name('profile.update');
});

// Legacy agent panel bookmarks
Route::permanentRedirect('/agent/dashboard', '/commission/dashboard');


