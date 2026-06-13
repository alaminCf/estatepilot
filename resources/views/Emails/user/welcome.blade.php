@extends('Emails.layout')

@section('title', 'Welcome to ' . ($siteName ?? 'London Abason'))

@section('content')
    <h2 style="color: #2A8441; font-size: 22px; font-weight: 700; margin: 0 0 20px;">👋 Welcome, {{ $user->name }}!</h2>
    
    <p style="color: #4b5563; font-size: 15px; margin-bottom: 20px; line-height: 1.7;">
        Thank you for creating an account with <strong>{{ $siteName ?? 'London Abason' }}</strong>. 
        We're excited to have you on board and look forward to helping you find your perfect plot of land.
    </p>
    
    <div style="background-color: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #2A8441; margin: 25px 0;">
        <strong>🎉 Your account has been created successfully!</strong>
    </div>
    
    <!-- Account Info -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Your Account Details</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Name</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $user->name }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Email</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $user->email }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Phone</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $user->phone }}</span>
            </td>
        </tr>
    </table>
    
    <!-- What You Can Do -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">What You Can Do Now</h3>
    <div style="background-color: #f0fdf4; padding: 20px; border-radius: 8px; border-left: 4px solid #2A8441;">
        <ul style="margin: 0; padding-left: 20px; color: #14532d; line-height: 2;">
            <li>Browse our available plots</li>
            <li>Book your preferred plot</li>
            <li>Track your booking status</li>
            <li>View payment history</li>
            <li>Manage your profile</li>
        </ul>
    </div>
    
    <!-- CTA Buttons -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ route('plots.index') }}" 
                   style="display: inline-block; background: linear-gradient(135deg, #2A8441 0%, #1f6b33 100%); color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 5px;">
                    Browse Plots
                </a>
                <a href="{{ route('account.dashboard') }}" 
                   style="display: inline-block; background-color: #1f2937; color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 5px;">
                    Go to Dashboard
                </a>
            </td>
        </tr>
    </table>
    
    <div style="border-top: 1px solid #e5e7eb; padding-top: 25px; margin-top: 30px;">
        <p style="color: #6b7280; font-size: 14px; margin: 0; line-height: 1.7;">
            If you have any questions or need assistance, feel free to contact our support team. 
            We're here to help you every step of the way!
        </p>
    </div>
@endsection
