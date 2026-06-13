@extends('Accounts.app')

@section('content')
<div class="d-flex flex-wrap align-items-center justify-content-between gap-3 mb-24">
    <div class="d-flex align-items-center gap-3">
        <h6 class="fw-semibold mb-0">Platform Settings</h6>
        <a href="https://londonabd.com/doc.html" target="_blank" rel="noopener noreferrer" class="btn btn-outline-primary-600 btn-sm d-flex align-items-center gap-2 px-16 py-8 radius-8">
            <iconify-icon icon="solar:book-bookmark-outline" class="text-lg"></iconify-icon>
            User Manual
        </a>
    </div>
    <ul class="d-flex align-items-center gap-2">
        <li class="fw-medium">
            <a href="{{ route('admin.dashboard') }}" class="d-flex align-items-center gap-1 hover-text-primary">
                <iconify-icon icon="solar:home-smile-angle-outline" class="icon text-lg"></iconify-icon>
                Dashboard
            </a>
        </li>
        <li>-</li>
        <li class="fw-medium">Platform Settings</li>
    </ul>
</div>

{{-- Platform Time Banner --}}
<div class="alert alert-info alert-dismissible d-flex align-items-center gap-3 mb-24 py-12 px-20 radius-8 border border-info-600" role="alert">
    <iconify-icon icon="solar:clock-circle-outline" class="text-info-600 text-2xl flex-shrink-0"></iconify-icon>
    <div>
        <span class="fw-semibold text-primary-light">Platform Server Time:</span>
        <span class="text-primary-light ms-8">{{ now()->format('l, d F Y — h:i:s A') }}</span>
        <span class="badge bg-success-100 text-success-600 fw-semibold ms-8 px-8 py-4 radius-4">BDT (UTC+6)</span>
    </div>
</div>

@if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

@if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row gy-4">
    <!-- Email Settings Card -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="text-lg mb-0 d-flex align-items-center">
                    <iconify-icon icon="solar:letter-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
                    Email Settings
                </h6>
            </div>
            <div class="card-body p-24">
                <form action="{{ route('admin.settings.update-email') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- From Settings -->
                    <h6 class="text-md text-primary-light mb-16">
                        <iconify-icon icon="solar:user-outline" class="me-8"></iconify-icon>
                        Sender Information
                    </h6>
                    
                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="mail_from_name" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    From Name <span class="text-danger-600">*</span>
                                </label>
                                <input type="text" class="form-control radius-8 @error('mail_from_name') is-invalid @enderror" 
                                       id="mail_from_name" name="mail_from_name" 
                                       value="{{ old('mail_from_name', $emailSettings['mail_from_name'] ?? 'London Abason') }}" 
                                       placeholder="London Abason">
                                @error('mail_from_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-secondary-light">Name shown in recipient's inbox</small>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="mail_from_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    From Email <span class="text-danger-600">*</span>
                                </label>
                                <input type="email" class="form-control radius-8 @error('mail_from_email') is-invalid @enderror" 
                                       id="mail_from_email" name="mail_from_email" 
                                       value="{{ old('mail_from_email', $emailSettings['mail_from_email'] ?? '') }}" 
                                       placeholder="noreply@londonabd.com">
                                @error('mail_from_email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-secondary-light">Email address used as sender</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- SMTP Settings -->
                    <h6 class="text-md text-primary-light mb-16 mt-16">
                        <iconify-icon icon="solar:server-outline" class="me-8"></iconify-icon>
                        SMTP Configuration
                    </h6>
                    
                    <div class="row">
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="smtp_host" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    SMTP Host
                                </label>
                                <input type="text" class="form-control radius-8 @error('smtp_host') is-invalid @enderror" 
                                       id="smtp_host" name="smtp_host" 
                                       value="{{ old('smtp_host', $emailSettings['smtp_host'] ?? '') }}" 
                                       placeholder="smtp.gmail.com">
                                @error('smtp_host')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="smtp_port" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    SMTP Port
                                </label>
                                <input type="number" class="form-control radius-8 @error('smtp_port') is-invalid @enderror" 
                                       id="smtp_port" name="smtp_port" 
                                       value="{{ old('smtp_port', $emailSettings['smtp_port'] ?? '587') }}" 
                                       placeholder="587">
                                @error('smtp_port')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-secondary-light">Common: 587 (TLS), 465 (SSL), 25</small>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="smtp_encryption" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    Encryption
                                </label>
                                <select class="form-control radius-8 @error('smtp_encryption') is-invalid @enderror" 
                                        id="smtp_encryption" name="smtp_encryption">
                                    <option value="" {{ old('smtp_encryption', $emailSettings['smtp_encryption'] ?? '') == '' ? 'selected' : '' }}>None</option>
                                    <option value="tls" {{ old('smtp_encryption', $emailSettings['smtp_encryption'] ?? '') == 'tls' ? 'selected' : '' }}>TLS</option>
                                    <option value="ssl" {{ old('smtp_encryption', $emailSettings['smtp_encryption'] ?? '') == 'ssl' ? 'selected' : '' }}>SSL</option>
                                </select>
                                @error('smtp_encryption')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="smtp_username" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    SMTP Username
                                </label>
                                <input type="text" class="form-control radius-8 @error('smtp_username') is-invalid @enderror" 
                                       id="smtp_username" name="smtp_username" 
                                       value="{{ old('smtp_username', $emailSettings['smtp_username'] ?? '') }}" 
                                       placeholder="your-email@gmail.com">
                                @error('smtp_username')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-lg-4">
                            <div class="mb-20">
                                <label for="smtp_password" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                    SMTP Password
                                </label>
                                <div class="position-relative">
                                    <input type="password" class="form-control radius-8 @error('smtp_password') is-invalid @enderror" 
                                           id="smtp_password" name="smtp_password" 
                                           value="{{ old('smtp_password', $emailSettings['smtp_password'] ?? '') }}" 
                                           placeholder="••••••••">
                                    <span class="position-absolute top-50 translate-middle-y end-0 me-12 cursor-pointer" onclick="togglePassword('smtp_password')">
                                        <iconify-icon icon="solar:eye-outline" class="text-secondary-light" id="smtp_password_icon"></iconify-icon>
                                    </span>
                                </div>
                                @error('smtp_password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-secondary-light">For Gmail, use App Password</small>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex align-items-center justify-content-between gap-3 mt-24">
                        <button type="button" class="btn btn-outline-info-600 px-20" onclick="showTestEmailModal()">
                            <iconify-icon icon="solar:mailbox-outline" class="me-8"></iconify-icon>
                            Send Test Email
                        </button>
                        <button type="submit" class="btn btn-primary-600 px-20">
                            <iconify-icon icon="solar:diskette-outline" class="me-8"></iconify-icon>
                            Save Email Settings
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <!-- Platform Basic Card -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="text-lg mb-0 d-flex align-items-center">
                    <iconify-icon icon="solar:settings-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
                    Notification Emails
                </h6>
            </div>
            <div class="card-body p-24">
                <form action="{{ route('admin.settings.update-platform') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h6 class="text-md text-primary-light mb-16">
                        <iconify-icon icon="solar:bell-outline" class="me-8"></iconify-icon>
                        Email Recipients
                    </h6>
                    
                    <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="support_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Support Email <span class="text-secondary-light">(For customer inquiries)</span>
                                        </label>
                                        <input type="email" class="form-control radius-8 @error('support_email') is-invalid @enderror" 
                                               id="support_email" name="support_email" 
                                               value="{{ old('support_email', $platformSettings['support_email'] ?? '') }}" 
                                               placeholder="support@example.com">
                                        @error('support_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-secondary-light">This email will be shown to customers for support</small>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="admin_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Admin Email <span class="text-secondary-light">(System notifications)</span>
                                        </label>
                                        <input type="email" class="form-control radius-8 @error('admin_email') is-invalid @enderror" 
                                               id="admin_email" name="admin_email" 
                                               value="{{ old('admin_email', $platformSettings['admin_email'] ?? '') }}" 
                                               placeholder="admin@example.com">
                                        @error('admin_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-secondary-light">System alerts and admin notifications</small>
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="booking_notification_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Booking Notification Email <span class="text-secondary-light">(New booking alerts)</span>
                                        </label>
                                        <input type="email" class="form-control radius-8 @error('booking_notification_email') is-invalid @enderror" 
                                               id="booking_notification_email" name="booking_notification_email" 
                                               value="{{ old('booking_notification_email', $platformSettings['booking_notification_email'] ?? '') }}" 
                                               placeholder="bookings@example.com">
                                        @error('booking_notification_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-secondary-light">Receives notifications for new bookings</small>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-end gap-3 mt-24">
                                <button type="submit" class="btn btn-primary-600 px-20">
                                    <iconify-icon icon="solar:diskette-outline" class="me-8"></iconify-icon>
                                    Save Platform Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
    
    <!-- Contact Details Card -->
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h6 class="text-lg mb-0 d-flex align-items-center">
                    <iconify-icon icon="solar:phone-calling-outline" class="me-8 text-xl text-primary-600"></iconify-icon>
                    Contact Details
                </h6>
            </div>
            <div class="card-body p-24">
                <form action="{{ route('admin.settings.update-contact') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <!-- Phone Numbers Section -->
                            <h6 class="text-md text-primary-light mb-16">
                                <iconify-icon icon="solar:phone-outline" class="me-8"></iconify-icon>
                                Phone Numbers
                            </h6>
                            
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="phone_primary" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Primary Phone Number
                                        </label>
                                        <input type="text" class="form-control radius-8 @error('phone_primary') is-invalid @enderror" 
                                               id="phone_primary" name="phone_primary" 
                                               value="{{ old('phone_primary', $contactSettings['phone_primary'] ?? '') }}" 
                                               placeholder="+880 1322-902986">
                                        @error('phone_primary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="phone_secondary" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Secondary Phone Number
                                        </label>
                                        <input type="text" class="form-control radius-8 @error('phone_secondary') is-invalid @enderror" 
                                               id="phone_secondary" name="phone_secondary" 
                                               value="{{ old('phone_secondary', $contactSettings['phone_secondary'] ?? '') }}" 
                                               placeholder="+880 1322-902987">
                                        @error('phone_secondary')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="whatsapp_number" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            WhatsApp Number
                                        </label>
                                        <input type="text" class="form-control radius-8 @error('whatsapp_number') is-invalid @enderror" 
                                               id="whatsapp_number" name="whatsapp_number" 
                                               value="{{ old('whatsapp_number', $contactSettings['whatsapp_number'] ?? '') }}" 
                                               placeholder="+880 1322-902986">
                                        @error('whatsapp_number')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Email Section -->
                            <h6 class="text-md text-primary-light mb-16 mt-16">
                                <iconify-icon icon="solar:mailbox-outline" class="me-8"></iconify-icon>
                                Contact Emails
                            </h6>
                            
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="contact_email" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Contact Email <span class="text-secondary-light">(info@...)</span>
                                        </label>
                                        <input type="email" class="form-control radius-8 @error('contact_email') is-invalid @enderror" 
                                               id="contact_email" name="contact_email" 
                                               value="{{ old('contact_email', $contactSettings['contact_email'] ?? '') }}" 
                                               placeholder="info@londonabd.com">
                                        @error('contact_email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="support_email_contact" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Support Email <span class="text-secondary-light">(help@...)</span>
                                        </label>
                                        <input type="email" class="form-control radius-8 @error('support_email_contact') is-invalid @enderror" 
                                               id="support_email_contact" name="support_email_contact" 
                                               value="{{ old('support_email_contact', $contactSettings['support_email_contact'] ?? '') }}" 
                                               placeholder="help@londonabd.com">
                                        @error('support_email_contact')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Office Details Section -->
                            <h6 class="text-md text-primary-light mb-16 mt-16">
                                <iconify-icon icon="solar:buildings-outline" class="me-8"></iconify-icon>
                                Office Details
                            </h6>
                            
                            <div class="row">
                                <div class="col-sm-6 col-lg-8">
                                    <div class="mb-20">
                                        <label for="office_address" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Office Address
                                        </label>
                                        <textarea class="form-control radius-8 @error('office_address') is-invalid @enderror" 
                                                  id="office_address" name="office_address" rows="3"
                                                  placeholder="House #123, Road #4, Dhanmondi, Dhaka-1205, Bangladesh">{{ old('office_address', $contactSettings['office_address'] ?? '') }}</textarea>
                                        @error('office_address')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="office_hours" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Office Hours
                                        </label>
                                        <input type="text" class="form-control radius-8 @error('office_hours') is-invalid @enderror" 
                                               id="office_hours" name="office_hours" 
                                               value="{{ old('office_hours', $contactSettings['office_hours'] ?? '') }}" 
                                               placeholder="Saturday - Thursday: 9 AM - 6 PM">
                                        @error('office_hours')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-20">
                                        <label for="google_map_embed" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            Google Map Embed URL <span class="text-secondary-light">(For contact page)</span>
                                        </label>
                                        <textarea class="form-control radius-8 @error('google_map_embed') is-invalid @enderror" 
                                                  id="google_map_embed" name="google_map_embed" rows="3"
                                                  placeholder="https://www.google.com/maps/embed?pb=...">{{ old('google_map_embed', $contactSettings['google_map_embed'] ?? '') }}</textarea>
                                        @error('google_map_embed')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-secondary-light">Paste the full Google Maps embed URL (src attribute value from iframe)</small>
                                    </div>
                                </div>
                                
                                <div class="col-12">
                                    <div class="mb-20">
                                        <label for="google_maps_url" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            <iconify-icon icon="solar:map-point-bold" class="me-4 text-danger-600"></iconify-icon>
                                            Google Maps Direct URL <span class="text-secondary-light">(For footer "Open on Map" link)</span>
                                        </label>
                                        <input type="url" class="form-control radius-8 @error('google_maps_url') is-invalid @enderror" 
                                               id="google_maps_url" name="google_maps_url" 
                                               value="{{ old('google_maps_url', $contactSettings['google_maps_url'] ?? '') }}" 
                                               placeholder="https://maps.google.com/maps?q=Your+Location">
                                        @error('google_maps_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-secondary-light">
                                            Paste the shareable Google Maps link. To get it: Open Google Maps → Search your location → Click "Share" → Copy link
                                        </small>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Social Media Section -->
                            <h6 class="text-md text-primary-light mb-16 mt-16">
                                <iconify-icon icon="solar:share-circle-outline" class="me-8"></iconify-icon>
                                Social Media Links
                            </h6>
                            
                            <div class="row">
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="facebook_url" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            <iconify-icon icon="logos:facebook" class="me-4"></iconify-icon>
                                            Facebook URL
                                        </label>
                                        <input type="url" class="form-control radius-8 @error('facebook_url') is-invalid @enderror" 
                                               id="facebook_url" name="facebook_url" 
                                               value="{{ old('facebook_url', $contactSettings['facebook_url'] ?? '') }}" 
                                               placeholder="https://facebook.com/londonabason">
                                        @error('facebook_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="twitter_url" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            <iconify-icon icon="skill-icons:twitter" class="me-4"></iconify-icon>
                                            Twitter/X URL
                                        </label>
                                        <input type="url" class="form-control radius-8 @error('twitter_url') is-invalid @enderror" 
                                               id="twitter_url" name="twitter_url" 
                                               value="{{ old('twitter_url', $contactSettings['twitter_url'] ?? '') }}" 
                                               placeholder="https://twitter.com/londonabason">
                                        @error('twitter_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="instagram_url" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            <iconify-icon icon="skill-icons:instagram" class="me-4"></iconify-icon>
                                            Instagram URL
                                        </label>
                                        <input type="url" class="form-control radius-8 @error('instagram_url') is-invalid @enderror" 
                                               id="instagram_url" name="instagram_url" 
                                               value="{{ old('instagram_url', $contactSettings['instagram_url'] ?? '') }}" 
                                               placeholder="https://instagram.com/londonabason">
                                        @error('instagram_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="youtube_url" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            <iconify-icon icon="logos:youtube-icon" class="me-4"></iconify-icon>
                                            YouTube URL
                                        </label>
                                        <input type="url" class="form-control radius-8 @error('youtube_url') is-invalid @enderror" 
                                               id="youtube_url" name="youtube_url" 
                                               value="{{ old('youtube_url', $contactSettings['youtube_url'] ?? '') }}" 
                                               placeholder="https://youtube.com/@londonabason">
                                        @error('youtube_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                
                                <div class="col-sm-6 col-lg-4">
                                    <div class="mb-20">
                                        <label for="linkedin_url" class="form-label fw-semibold text-primary-light text-sm mb-8">
                                            <iconify-icon icon="logos:linkedin-icon" class="me-4"></iconify-icon>
                                            LinkedIn URL
                                        </label>
                                        <input type="url" class="form-control radius-8 @error('linkedin_url') is-invalid @enderror" 
                                               id="linkedin_url" name="linkedin_url" 
                                               value="{{ old('linkedin_url', $contactSettings['linkedin_url'] ?? '') }}" 
                                               placeholder="https://linkedin.com/company/londonabason">
                                        @error('linkedin_url')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            
                            <div class="d-flex align-items-center justify-content-end gap-3 mt-24">
                                <button type="submit" class="btn btn-primary-600 px-20">
                                    <iconify-icon icon="solar:diskette-outline" class="me-8"></iconify-icon>
                                    Save Contact Settings
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Test Email Modal -->
<div class="modal fade" id="testEmailModal" tabindex="-1" aria-labelledby="testEmailModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <form action="{{ route('admin.settings.test-email') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="testEmailModalLabel">
                        <iconify-icon icon="solar:mailbox-outline" class="me-8"></iconify-icon>
                        Send Test Email
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-20">
                        <label for="test_email_address" class="form-label fw-semibold text-primary-light text-sm mb-8">
                            Recipient Email Address <span class="text-danger-600">*</span>
                        </label>
                        <input type="email" class="form-control radius-8" id="test_email_address" name="email" placeholder="Enter email address" required>
                        <small class="text-secondary-light">The test email will be sent to this address</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary-600" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary-600">
                        <iconify-icon icon="solar:paper-plane-outline" class="me-8"></iconify-icon>
                        Send Test Email
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Toggle password visibility
    function togglePassword(inputId) {
        const input = document.getElementById(inputId);
        const icon = document.getElementById(inputId + '_icon');
        
        if (input.type === 'password') {
            input.type = 'text';
            icon.setAttribute('icon', 'solar:eye-closed-outline');
        } else {
            input.type = 'password';
            icon.setAttribute('icon', 'solar:eye-outline');
        }
    }
    
    // Show test email modal
    function showTestEmailModal() {
        const modal = new bootstrap.Modal(document.getElementById('testEmailModal'));
        modal.show();
    }
</script>
@endpush
