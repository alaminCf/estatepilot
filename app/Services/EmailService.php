<?php

namespace App\Services;

use App\Models\WebsiteSetting;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class EmailService
{
    protected $fromEmail;
    protected $fromName;
    protected $siteName;
    protected $phoneNumber;
    protected $contactEmail;

    public function __construct()
    {
        $this->loadSettings();
    }

    /**
     * Load email settings from database
     */
    protected function loadSettings()
    {
        $emailSettings = WebsiteSetting::getGroup('email');
        $contactSettings = WebsiteSetting::getGroup('contact');

        $this->fromEmail = $emailSettings['mail_from_email'] ?? config('mail.from.address');
        $this->fromName = $emailSettings['mail_from_name'] ?? config('mail.from.name', site_name());
        $this->siteName = site_name();
        $this->phoneNumber = $contactSettings['phone_primary'] ?? '+880 1322-902986';
        $this->contactEmail = $contactSettings['contact_email'] ?? 'info@londonabd.com';

        // Configure mail settings dynamically
        $this->configureMailer($emailSettings);
    }

    /**
     * Configure mailer with database settings
     */
    protected function configureMailer($emailSettings)
    {
        if (!empty($emailSettings['smtp_host'])) {
            // Force SMTP mailer - this is crucial for the email to work
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $emailSettings['smtp_host'],
                'mail.mailers.smtp.port' => $emailSettings['smtp_port'] ?? 587,
                'mail.mailers.smtp.username' => $emailSettings['smtp_username'] ?? null,
                'mail.mailers.smtp.password' => $emailSettings['smtp_password'] ?? null,
                'mail.mailers.smtp.encryption' => $emailSettings['smtp_encryption'] ?: null,
            ]);
        }

        if ($this->fromEmail) {
            config([
                'mail.from.address' => $this->fromEmail,
                'mail.from.name' => $this->fromName,
            ]);
        }
    }

    /**
     * Get common email data
     */
    protected function getCommonData()
    {
        return [
            'siteName' => $this->siteName,
            'phoneNumber' => $this->phoneNumber,
            'contactEmail' => $this->contactEmail,
        ];
    }

    /**
     * Send email using a template
     */
    public function send($to, $subject, $template, $data = [], $attachments = [])
    {
        try {
            $data = array_merge($this->getCommonData(), $data);

            Mail::send($template, $data, function ($message) use ($to, $subject, $attachments) {
                $message->to($to)
                        ->subject($subject)
                        ->from($this->fromEmail, $this->fromName);

                // Add attachments if any
                foreach ($attachments as $attachment) {
                    if (isset($attachment['path'])) {
                        $message->attach($attachment['path'], [
                            'as' => $attachment['name'] ?? null,
                            'mime' => $attachment['mime'] ?? null,
                        ]);
                    } elseif (isset($attachment['data'])) {
                        $message->attachData(
                            $attachment['data'],
                            $attachment['name'],
                            ['mime' => $attachment['mime'] ?? 'application/octet-stream']
                        );
                    }
                }
            });

            Log::info("Email sent successfully to: {$to}, Subject: {$subject}");
            return ['success' => true, 'message' => 'Email sent successfully'];

        } catch (\Exception $e) {
            Log::error("Email sending failed: " . $e->getMessage());
            return ['success' => false, 'message' => $e->getMessage()];
        }
    }

    /**
     * Send contact form email to admin
     */
    public function sendContactFormEmail($data)
    {
        // Get platform settings for support email
        $platformSettings = WebsiteSetting::getGroup('platform');
        $contactSettings = WebsiteSetting::getGroup('contact');
        
        // Priority: platform support_email -> contact support_email_contact -> platform admin_email
        $adminEmail = $platformSettings['support_email'] 
            ?? $contactSettings['support_email_contact'] 
            ?? $platformSettings['admin_email'] 
            ?? null;
        
        if (!$adminEmail) {
            return ['success' => false, 'message' => 'Support email not configured. Please configure Support Email in Admin Settings.'];
        }

        return $this->send(
            $adminEmail,
            'New Contact Form Submission - ' . ($data['subject'] ?? 'General Inquiry'),
            'Emails.admin.contact-form',
            ['data' => $data]
        );
    }

    /**
     * Send new booking notification to admin
     */
    public function sendNewBookingNotification($booking, $plot)
    {
        $bookingEmail = WebsiteSetting::get('booking_notification_email', WebsiteSetting::get('admin_email'));
        
        if (!$bookingEmail) {
            return ['success' => false, 'message' => 'Booking notification email not configured'];
        }

        return $this->send(
            $bookingEmail,
            'New Booking Received - Booking #' . $booking->id,
            'Emails.admin.new-booking',
            [
                'booking' => $booking,
                'plot' => $plot,
            ]
        );
    }

    /**
     * Send welcome email to new user
     */
    public function sendWelcomeEmail($user)
    {
        return $this->send(
            $user->email,
            'Welcome to ' . $this->siteName . '!',
            'Emails.user.welcome',
            ['user' => $user]
        );
    }

    /**
     * Send payment recorded email to user
     */
    public function sendPaymentRecordedEmail($payment, $booking, $user)
    {
        return $this->send(
            $user->email,
            'Payment Received - ' . $this->siteName,
            'Emails.user.payment-recorded',
            [
                'payment' => $payment,
                'booking' => $booking,
                'user' => $user,
            ]
        );
    }

    /**
     * Send commission payout email to a commission user
     */
    public function sendCommissionPayoutEmail($payout, $user)
    {
        return $this->send(
            $user->email,
            'Commission Payout Received - ' . $this->siteName,
            'Emails.commission.payout',
            [
                'payout' => $payout,
                'user' => $user,
            ]
        );
    }
}
