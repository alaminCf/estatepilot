@extends('Emails.layout')

@section('title', 'Test Email - ' . ($siteName ?? 'London Abason'))

@section('content')
    <h2 style="color: #2A8441; font-size: 22px; font-weight: 700; margin: 0 0 20px;">✉️ Test Email</h2>
    
    <p style="color: #4b5563; font-size: 15px; margin-bottom: 20px; line-height: 1.7;">
        This is a test email from <strong>{{ $siteName ?? 'London Abason' }}</strong> email system.
    </p>
    
    <div style="background-color: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #2A8441; margin: 25px 0;">
        <strong>✅ Congratulations!</strong> Your email configuration is working properly.
    </div>
    
    <!-- Test Details -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Email Configuration Test</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Sent From</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ config('mail.from.name') }} &lt;{{ config('mail.from.address') }}&gt;</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Date & Time</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ now()->format('F d, Y - h:i:s A') }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Server</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ config('mail.mailers.smtp.host') ?? 'Default SMTP' }}</span>
            </td>
        </tr>
    </table>
    
    <div style="background-color: #f0fdf4; padding: 20px; border-radius: 8px; border-left: 4px solid #2A8441; margin: 25px 0;">
        <p style="margin: 0; color: #14532d; font-size: 14px; line-height: 1.7;">
            <strong>What this means:</strong><br>
            If you're reading this email, it means your SMTP configuration is correct and emails are being sent successfully from your London Abason platform.
        </p>
    </div>
    
    <div style="border-top: 1px solid #e5e7eb; padding-top: 25px; margin-top: 30px;">
        <p style="color: #6b7280; font-size: 13px; margin: 0; line-height: 1.7;">
            This is an automated test email. If you did not request this test, please contact your system administrator.
        </p>
    </div>
@endsection
