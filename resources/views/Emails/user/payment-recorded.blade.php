@extends('Emails.layout')

@section('title', 'Payment Received - ' . ($siteName ?? site_name()))

@section('content')
    <h2 style="color: #09306c; font-size: 22px; font-weight: 700; margin: 0 0 20px;">💰 Payment Received</h2>
    
    <p style="color: #4b5563; font-size: 15px; margin-bottom: 20px; line-height: 1.7;">
        Dear <strong>{{ $user->name }}</strong>,<br>
        We have successfully received your payment. Thank you for your trust in {{ $siteName ?? site_name() }}.
    </p>
    
    <div style="background-color: #dbeafe; color: #09306c; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #09306c; margin: 25px 0;">
        <strong>✅ Payment Confirmed!</strong> Your payment has been recorded successfully.
    </div>
    
    <!-- Payment Details -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Payment Details</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Payment ID</span><br>
                <span style="color: #09306c; font-size: 15px; font-weight: 700;">#{{ $payment->id }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Amount Paid</span><br>
                <span style="color: #10b981; font-size: 20px; font-weight: 700;">৳{{ number_format($payment->amount, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Payment Method</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ ucfirst($payment->payment_method ?? 'N/A') }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Payment Date</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $payment->payment_date ? $payment->payment_date->format('F d, Y') : $payment->created_at->format('F d, Y') }}</span>
            </td>
        </tr>
        @if($payment->transaction_id)
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Transaction ID</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $payment->transaction_id }}</span>
            </td>
        </tr>
        @endif
    </table>
    
    <!-- Booking Details -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Related Booking</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Booking ID</span><br>
                <span style="color: #09306c; font-size: 15px; font-weight: 700;">#{{ $booking->id }}</span>
            </td>
        </tr>
        @if($booking->plot)
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Plot Number</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $booking->plot->plot_no }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Plot Location</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $booking->plot->location ?? 'N/A' }}</span>
            </td>
        </tr>
        @endif
    </table>
    
    <!-- Payment Summary -->
    @if($booking->plot)
    <div style="background-color: #eff6ff; padding: 20px; border-radius: 8px; border-left: 4px solid #09306c; margin: 25px 0;">
        <h4 style="color: #14532d; font-size: 14px; margin: 0 0 15px;">Payment Summary</h4>
        <table width="100%" cellpadding="0" cellspacing="0">
            <tr>
                <td style="color: #4b5563; font-size: 14px; padding: 5px 0;">Total Plot Price:</td>
                <td style="color: #1f2937; font-size: 14px; font-weight: 600; text-align: right;">৳{{ number_format($booking->plot->price ?? 0, 2) }}</td>
            </tr>
            <tr>
                <td style="color: #4b5563; font-size: 14px; padding: 5px 0;">This Payment:</td>
                <td style="color: #09306c; font-size: 14px; font-weight: 600; text-align: right;">৳{{ number_format($payment->amount, 2) }}</td>
            </tr>
            @php
                $totalPaid = $booking->payments()->sum('amount');
                $remaining = ($booking->plot->price ?? 0) - $totalPaid;
            @endphp
            <tr style="border-top: 1px solid #bbf7d0; margin-top: 10px;">
                <td style="color: #4b5563; font-size: 14px; padding: 10px 0 5px;">Total Paid:</td>
                <td style="color: #1f2937; font-size: 14px; font-weight: 600; text-align: right; padding-top: 10px;">৳{{ number_format($totalPaid, 2) }}</td>
            </tr>
            <tr>
                <td style="color: #4b5563; font-size: 14px; padding: 5px 0;"><strong>Remaining Balance:</strong></td>
                <td style="color: {{ $remaining > 0 ? '#f59e0b' : '#09306c' }}; font-size: 16px; font-weight: 700; text-align: right;">৳{{ number_format(max(0, $remaining), 2) }}</td>
            </tr>
        </table>
    </div>
    @endif
    
    <!-- Invoice Link Banner -->
    <div style="background: linear-gradient(135deg, #eff6ff 0%, #dbeafe 100%); border: 1px solid #86efac; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: center;">
        <p style="color: #15803d; font-size: 14px; font-weight: 600; margin: 0 0 12px;">📄 Your Invoice is Ready</p>
        <p style="color: #4b5563; font-size: 13px; margin: 0 0 15px;">View and download your official payment receipt / invoice.</p>
        <a href="{{ route('account.payments.invoice', $payment->id) }}"
           style="display: inline-block; background: linear-gradient(135deg, #09306c 0%, #062047 100%); color: #ffffff; padding: 12px 28px; font-size: 14px; font-weight: 700; text-decoration: none; border-radius: 8px; letter-spacing: 0.5px;">
            🧾 View Invoice #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}
        </a>
    </div>

    <!-- Action Buttons -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ route('account.payments') }}" 
                   style="display: inline-block; background: linear-gradient(135deg, #09306c 0%, #062047 100%); color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 5px;">
                    View All Payments
                </a>
                <a href="{{ route('account.bookings') }}" 
                   style="display: inline-block; background-color: #1f2937; color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 5px;">
                    View Bookings
                </a>
            </td>
        </tr>
    </table>
    
    <div style="border-top: 1px solid #e5e7eb; padding-top: 25px; margin-top: 30px;">
        <p style="color: #6b7280; font-size: 13px; margin: 0; line-height: 1.7;">
            This is an automated payment confirmation. If you have any questions about this payment, 
            please contact our support team with your Payment ID #{{ $payment->id }}.
        </p>
    </div>
@endsection
