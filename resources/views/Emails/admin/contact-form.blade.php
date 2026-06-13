@extends('Emails.layout')

@section('title', 'New Contact Form Submission')

@section('content')
    <h2 style="color: #2A8441; font-size: 22px; font-weight: 700; margin: 0 0 20px;">📬 New Contact Form Submission</h2>
    
    <p style="color: #4b5563; font-size: 15px; margin-bottom: 20px;">
        You have received a new message from your website contact form.
    </p>
    
    <!-- Details Box -->
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px; margin: 20px 0;">
        <tr>
            <td style="padding: 20px;">
                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; text-transform: uppercase;">Name</span><br>
                            <span style="color: #1f2937; font-size: 15px; font-weight: 600;">{{ $data['name'] ?? 'N/A' }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; text-transform: uppercase;">Email</span><br>
                            <a href="mailto:{{ $data['email'] ?? '' }}" style="color: #2A8441; font-size: 15px; font-weight: 600; text-decoration: none;">{{ $data['email'] ?? 'N/A' }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #e5e7eb;">
                            <span style="color: #6b7280; font-size: 13px; text-transform: uppercase;">Phone</span><br>
                            <a href="tel:{{ $data['phone'] ?? '' }}" style="color: #2A8441; font-size: 15px; font-weight: 600; text-decoration: none;">{{ $data['phone'] ?? 'N/A' }}</a>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">
                            <span style="color: #6b7280; font-size: 13px; text-transform: uppercase;">Subject</span><br>
                            <span style="color: #1f2937; font-size: 15px; font-weight: 600;">
                                @php
                                    $subjects = [
                                        'general' => 'General Inquiry',
                                        'plot' => 'Plot Information',
                                        'booking' => 'Booking Query',
                                        'payment' => 'Payment Related',
                                        'visit' => 'Site Visit Request',
                                        'other' => 'Other'
                                    ];
                                @endphp
                                {{ $subjects[$data['subject'] ?? ''] ?? ucfirst($data['subject'] ?? 'General') }}
                            </span>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
    
    <!-- Message Box -->
    <div style="background-color: #f0fdf4; border-left: 4px solid #2A8441; padding: 20px; border-radius: 6px; margin: 20px 0;">
        <span style="color: #6b7280; font-size: 13px; text-transform: uppercase; display: block; margin-bottom: 10px;">Message</span>
        <p style="color: #14532d; font-size: 15px; margin: 0; white-space: pre-wrap; line-height: 1.7;">{{ $data['message'] ?? 'No message provided.' }}</p>
    </div>
    
    <!-- Action Button -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 25px 0;">
        <tr>
            <td align="center">
                <a href="mailto:{{ $data['email'] ?? '' }}?subject=Re: {{ urlencode($subjects[$data['subject'] ?? ''] ?? 'Contact Form') }}" 
                   style="display: inline-block; background: linear-gradient(135deg, #2A8441 0%, #1f6b33 100%); color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px;">
                    Reply to {{ $data['name'] ?? 'Customer' }}
                </a>
            </td>
        </tr>
    </table>
    
    <p style="color: #6b7280; font-size: 13px; margin-top: 30px; text-align: center;">
        Received on {{ now()->format('F d, Y \a\t h:i A') }}
    </p>
@endsection
