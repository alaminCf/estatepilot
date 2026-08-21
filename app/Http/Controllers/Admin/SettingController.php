<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index()
    {
        $brandingSettings = WebsiteSetting::getGroup('branding');
        $platformSettings = WebsiteSetting::getGroup('platform');
        $contactSettings = WebsiteSetting::getGroup('contact');
        $emailSettings = WebsiteSetting::getGroup('email');

        return view('Accounts.Admin.settings.index', compact('brandingSettings', 'platformSettings', 'contactSettings', 'emailSettings'));
    }

    /**
     * Update branding settings.
     */
    public function updateBranding(Request $request)
    {
        $request->validate([
            'site_name' => 'required|string|max:100',
            'site_legal_name' => 'nullable|string|max:150',
            'site_tagline' => 'nullable|string|max:200',
        ]);

        WebsiteSetting::setMany([
            'site_name' => $request->site_name,
            'site_legal_name' => $request->site_legal_name,
            'site_tagline' => $request->site_tagline,
        ], 'branding');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Branding settings updated successfully!');
    }

    /**
     * Update platform settings.
     */
    public function updatePlatform(Request $request)
    {
        $request->validate([
            'support_email' => 'nullable|email|max:255',
            'admin_email' => 'nullable|email|max:255',
            'booking_notification_email' => 'nullable|email|max:255',
        ]);

        WebsiteSetting::setMany([
            'support_email' => $request->support_email,
            'admin_email' => $request->admin_email,
            'booking_notification_email' => $request->booking_notification_email,
        ], 'platform');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Platform settings updated successfully!');
    }

    /**
     * Update email settings.
     */
    public function updateEmail(Request $request)
    {
        $request->validate([
            'mail_from_name' => 'required|string|max:255',
            'mail_from_email' => 'required|email|max:255',
            'smtp_host' => 'nullable|string|max:255',
            'smtp_port' => 'nullable|integer|min:1|max:65535',
            'smtp_username' => 'nullable|string|max:255',
            'smtp_password' => 'nullable|string|max:255',
            'smtp_encryption' => 'nullable|in:,tls,ssl',
        ]);

        WebsiteSetting::setMany([
            'mail_from_name' => $request->mail_from_name,
            'mail_from_email' => $request->mail_from_email,
            'smtp_host' => $request->smtp_host,
            'smtp_port' => $request->smtp_port,
            'smtp_username' => $request->smtp_username,
            'smtp_password' => $request->smtp_password,
            'smtp_encryption' => $request->smtp_encryption,
        ], 'email');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Email settings updated successfully!');
    }

    /**
     * Test email connection.
     */
    public function testEmail(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|email'
            ]);

            $emailSettings = WebsiteSetting::getGroup('email');
            $contactSettings = WebsiteSetting::getGroup('contact');
            
            // Check if SMTP settings are configured
            if (empty($emailSettings['smtp_host']) || empty($emailSettings['mail_from_email'])) {
                return redirect()->route('admin.settings.index')
                    ->with('error', 'Please configure SMTP settings first before sending test email.');
            }
            
            // Configure mail on the fly - force SMTP mailer
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings['smtp_host'],
                'mail.mailers.smtp.port' => $emailSettings['smtp_port'] ?? 587,
                'mail.mailers.smtp.username' => $emailSettings['smtp_username'] ?? null,
                'mail.mailers.smtp.password' => $emailSettings['smtp_password'] ?? null,
                'mail.mailers.smtp.encryption' => $emailSettings['smtp_encryption'] ?: null,
                'mail.from.address' => $emailSettings['mail_from_email'],
                'mail.from.name' => $emailSettings['mail_from_name'] ?? site_name(),
            ]);

            $siteName = site_name();
            $phoneNumber = $contactSettings['phone_primary'] ?? '+880 1322-902986';
            $contactEmail = $contactSettings['contact_email'] ?? 'info@londonabd.com';
            
            // Get logo URL
            $siteLogo = WebsiteSetting::get('site_logo', '');
            $logoUrl = $siteLogo ? url('uploads/admin/' . $siteLogo) : null;

            $emailData = [
                'siteName' => $siteName,
                'phoneNumber' => $phoneNumber,
                'contactEmail' => $contactEmail,
                'logoUrl' => $logoUrl,
            ];

            \Illuminate\Support\Facades\Mail::send('Emails.admin.test-email', $emailData, function ($message) use ($request, $siteName) {
                $message->to($request->email)
                        ->subject('Test Email - ' . $siteName . ' Email System');
            });

            return redirect()->route('admin.settings.index')
                ->with('success', 'Test email sent successfully to ' . $request->email . '! Please check the inbox (including spam folder).');
        } catch (\Swift_TransportException $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'SMTP Connection Failed: ' . $e->getMessage() . '. Please verify your SMTP settings.');
        } catch (\Exception $e) {
            return redirect()->route('admin.settings.index')
                ->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }

    /**
     * Update contact settings.
     */
    public function updateContact(Request $request)
    {
        $request->validate([
            'phone_primary' => 'nullable|string|max:50',
            'phone_secondary' => 'nullable|string|max:50',
            'whatsapp_number' => 'nullable|string|max:50',
            'contact_email' => 'nullable|email|max:255',
            'support_email_contact' => 'nullable|email|max:255',
            'office_address' => 'nullable|string|max:500',
            'office_hours' => 'nullable|string|max:255',
            'google_map_embed' => 'nullable|string',
            'google_maps_url' => 'nullable|url|max:500',
            'facebook_url' => 'nullable|url|max:500',
            'twitter_url' => 'nullable|url|max:500',
            'instagram_url' => 'nullable|url|max:500',
            'youtube_url' => 'nullable|url|max:500',
            'linkedin_url' => 'nullable|url|max:500',
        ]);

        WebsiteSetting::setMany([
            'phone_primary' => $request->phone_primary,
            'phone_secondary' => $request->phone_secondary,
            'whatsapp_number' => $request->whatsapp_number,
            'contact_email' => $request->contact_email,
            'support_email_contact' => $request->support_email_contact,
            'office_address' => $request->office_address,
            'office_hours' => $request->office_hours,
            'google_map_embed' => $request->google_map_embed,
            'google_maps_url' => $request->google_maps_url,
            'facebook_url' => $request->facebook_url,
            'twitter_url' => $request->twitter_url,
            'instagram_url' => $request->instagram_url,
            'youtube_url' => $request->youtube_url,
            'linkedin_url' => $request->linkedin_url,
        ], 'contact');

        return redirect()->route('admin.settings.index')
            ->with('success', 'Contact settings updated successfully!');
    }
}
