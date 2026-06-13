@extends('Emails.layout')

@section('title', 'Commission Payout Received - ' . ($siteName ?? 'London Abason'))

@section('content')
    <h2 style="color: #2A8441; font-size: 22px; font-weight: 700; margin: 0 0 20px;">🎉 Commission Payout Received</h2>

    <p style="color: #4b5563; font-size: 15px; margin-bottom: 20px; line-height: 1.7;">
        Dear <strong>{{ $user->name }}</strong>,<br>
        Great news! Your commission payout has been processed. Thank you for your continued partnership with {{ $siteName ?? 'London Abason' }}.
    </p>

    <div style="background-color: #d1fae5; color: #065f46; padding: 15px 20px; border-radius: 8px; border-left: 4px solid #2A8441; margin: 25px 0;">
        <strong>✅ Commission Payout Confirmed!</strong> Your commission has been recorded and disbursed.
    </div>

    <!-- Commission Payout Details -->
    <h3 style="color: #1f2937; font-size: 16px; font-weight: 600; margin: 25px 0 15px;">Payout Details</h3>
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f9fafb; border-radius: 8px;">
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Receipt ID</span><br>
                <span style="color: #2A8441; font-size: 15px; font-weight: 700;">#{{ str_pad($payout->id, 6, '0', STR_PAD_LEFT) }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Payout Amount</span><br>
                <span style="color: #10b981; font-size: 24px; font-weight: 700;">৳{{ number_format($payout->amount, 2) }}</span>
            </td>
        </tr>
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Payout Date</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $payout->created_at->format('F d, Y') }}</span>
            </td>
        </tr>
        @if($payout->booking_id)
        <tr>
            <td style="padding: 15px; border-bottom: 1px solid #e5e7eb;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Booking Reference</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">#{{ $payout->booking_id }}{{ $payout->booking && $payout->booking->plot ? ' — Plot ' . $payout->booking->plot->plot_no : '' }}</span>
            </td>
        </tr>
        @endif
        @if($payout->payment_note)
        <tr>
            <td style="padding: 15px;">
                <span style="color: #6b7280; font-size: 12px; text-transform: uppercase;">Note</span><br>
                <span style="color: #1f2937; font-size: 15px; font-weight: 500;">{{ $payout->payment_note }}</span>
            </td>
        </tr>
        @endif
    </table>

    <!-- Invoice Link Banner -->
    <div style="background: linear-gradient(135deg, #f0fdf4 0%, #dcfce7 100%); border: 1px solid #86efac; border-radius: 10px; padding: 20px; margin: 25px 0; text-align: center;">
        <p style="color: #15803d; font-size: 14px; font-weight: 600; margin: 0 0 12px;">📄 Your Commission Invoice is Ready</p>
        <p style="color: #4b5563; font-size: 13px; margin: 0 0 15px;">View and download your official commission receipt for your records.</p>
        <a href="{{ route('commission.payouts.invoice', $payout->id) }}"
           style="display: inline-block; background: linear-gradient(135deg, #2A8441 0%, #1f6b33 100%); color: #ffffff; padding: 12px 28px; font-size: 14px; font-weight: 700; text-decoration: none; border-radius: 8px; letter-spacing: 0.5px;">
            🧾 View Commission Invoice
        </a>
    </div>

    <!-- Action Buttons -->
    <table width="100%" cellpadding="0" cellspacing="0" style="margin: 30px 0;">
        <tr>
            <td align="center">
                <a href="{{ route('commission.payouts') }}"
                   style="display: inline-block; background: linear-gradient(135deg, #2A8441 0%, #1f6b33 100%); color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 5px;">
                    View All Payouts
                </a>
                <a href="{{ route('commission.earnings') }}"
                   style="display: inline-block; background-color: #1f2937; color: #ffffff; padding: 14px 32px; font-size: 15px; font-weight: 600; text-decoration: none; border-radius: 8px; margin: 5px;">
                    Earnings Summary
                </a>
            </td>
        </tr>
    </table>

    <div style="border-top: 1px solid #e5e7eb; padding-top: 25px; margin-top: 30px;">
        <p style="color: #6b7280; font-size: 13px; margin: 0; line-height: 1.7;">
            This is an automated commission payout confirmation. If you have any questions about this payout,
            please contact our support team with your Receipt ID #{{ str_pad($payout->id, 6, '0', STR_PAD_LEFT) }}.
        </p>
    </div>
@endsection
