@extends('Emails.layout')

@section('title', 'New Booking Notification')

@section('content')
    <h2 style="color: #09306c; font-size: 22px; font-weight: 700; margin: 0 0 20px;">🎉 New Booking Received!</h2>
    
    <div style="background-color: #dbeafe; color: #09306c; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #09306c; margin-bottom: 25px;">
        <strong>Great News!</strong> A new booking has been submitted and requires your attention.
    </div>
    
    <!-- Booking Info Box -->
    <div style="background-color: #eff6ff; border-left: 4px solid #09306c; padding: 15px 20px; border-radius: 6px; margin: 20px 0;">
        <p style="margin: 0; color: #0c4a6e;">
            <strong>Booking ID:</strong> #{{ $booking->id }}<br>
            <strong>Status:</strong> <span style="background-color: #fef3c7; color: #92400e; padding: 2px 10px; border-radius: 4px; font-size: 13px;">{{ ucfirst($booking->status) }}</span><br>
            <strong>Date:</strong> {{ $booking->created_at->format('F d, Y - h:i A') }}
        </p>
    </div>
    
    <!-- Customer Details -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Customer Information</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Name</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $booking->customer_name ?? 'N/A' }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Email</span><br>
                <a href="mailto:{{ $booking->customer_email ?? '' }}" style="color: #09306c; font-size: 15px; font-weight: 500; text-decoration: none;">{{ $booking->customer_email ?? 'N/A' }}</a>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Phone</span><br>
                <a href="tel:{{ $booking->customer_phone ?? '' }}" style="color: #09306c; font-size: 15px; font-weight: 500; text-decoration: none;">{{ $booking->customer_phone ?? 'N/A' }}</a>
            </td>
        </tr>
    </table>
    
    <!-- Plot Details -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Plot Details</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Plot Number</span><br>
                <span style="color: #09306c; font-size: 18px; font-weight: 700;">{{ $plot->plot_no ?? 'N/A' }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Title</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $plot->title ?? 'N/A' }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Location</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $plot->location ?? 'N/A' }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Price</span><br>
                <span style="color: #10b981; font-size: 18px; font-weight: 700;">৳{{ number_format($plot->price ?? 0, 2) }}</span>
            </td>
        </tr>
    </table>
    
    @if($booking->notes)
    <!-- Customer Notes -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Customer Notes</h3>
    <div style="background-color: #f9fafb; padding: 15px; border-radius: 8px; border: 1px solid #e5e7eb;">
        <p style="color: #4b5563; font-size: 14px; margin: 0; line-height: 1.7;">{{ $booking->notes }}</p>
    </div>
    @endif
    
    <!-- Action Required -->
    <div style="background-color: #fef3c7; color: #92400e; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #f59e0b; margin: 25px 0;">
        <strong>⏰ Action Required:</strong> Please review this booking and contact the customer within 24 hours.
    </div>
    
    <!-- Action Button -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 25px 0;">
        <tr>
            <td align="center">
                <a href="{{ route('admin.bookings.show', $booking->id) }}" 
                   style="display: inline-block; background: linear-gradient(135deg, #09306c 0%, #062047 100%); color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px;">
                    View Booking Details
                </a>
            </td>
        </tr>
    </table>
@endsection
