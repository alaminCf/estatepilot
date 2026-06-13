<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'London Abason')</title>
</head>
<body style="margin: 0; padding: 0; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Arial, sans-serif; background-color: #f3f4f6; line-height: 1.6;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background-color: #f3f4f6; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="max-width: 600px; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);">
                    
                    <!-- Header -->
                    <tr>
                        <td style="padding: 0;">
                            <!-- Top Accent Line -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background: linear-gradient(90deg, #2A8441 0%, #3da556 50%, #2A8441 100%); height: 5px;"></td>
                                </tr>
                            </table>
                            <!-- Logo Area -->
                            <table width="100%" cellpadding="0" cellspacing="0">
                                <tr>
                                    <td style="background-color: rgba(42, 132, 65, 0.02); padding: 30px 40px; text-align: center; border-bottom: 1px solid #e8f5eb;">
                                        <img src="{{ asset('assets/logo-w.png') }}" alt="{{ $siteName ?? 'London Abason' }}" style="max-width: 220px; height: auto; max-height: 70px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" style="margin-top: 15px;">
                                            <tr>
                                                <td style="text-align: center;">
                                                    <span style="display: inline-block; width: 40px; height: 1px; background-color: #2A8441; vertical-align: middle;"></span>
                                                    <span style="display: inline-block; color: #2A8441; font-size: 11px; letter-spacing: 3px; text-transform: uppercase; font-weight: 600; padding: 0 15px; vertical-align: middle;">Your Dream Land Awaits</span>
                                                    <span style="display: inline-block; width: 40px; height: 1px; background-color: #2A8441; vertical-align: middle;"></span>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 35px 30px; color: #374151;">
                            @yield('content')
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #1f2937; padding: 25px 30px; text-align: center;">
                            <p style="color: #9ca3af; font-size: 13px; margin: 0 0 10px;">
                                {{ $siteName ?? 'London Abason' }} | Premium Land Development
                            </p>
                            @if(isset($phoneNumber) && $phoneNumber)
                                <p style="color: #9ca3af; font-size: 13px; margin: 0 0 5px;">
                                    📞 {{ $phoneNumber }}
                                </p>
                            @endif
                            @if(isset($contactEmail) && $contactEmail)
                                <p style="color: #9ca3af; font-size: 13px; margin: 0 0 15px;">
                                    ✉️ {{ $contactEmail }}
                                </p>
                            @endif
                            <p style="color: #6b7280; font-size: 12px; margin: 0; border-top: 1px solid #374151; padding-top: 15px;">
                                © {{ date('Y') }} {{ $siteName ?? 'London Abason' }}. All rights reserved.
                            </p>
                        </td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
