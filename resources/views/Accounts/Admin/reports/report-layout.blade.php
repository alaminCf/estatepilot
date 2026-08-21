<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Report') - {{ $company['site_name'] }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#09306c',
                    }
                }
            }
        }
    </script>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Segoe UI', system-ui, sans-serif; font-size: 12px; line-height: 1.4; }
        @media print {
            .no-print { display: none !important; }
            body { -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
            @page { margin: 8mm; size: A4 landscape; }
            .page-break { page-break-before: always; }
        }
        table { border-collapse: collapse; }
        th, td { border: 1px solid #d1d5db; padding: 4px 8px; text-align: left; font-size: 11px; }
        th { background-color: #f3f4f6; font-weight: 600; white-space: nowrap; }
        .summary-box { background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 6px; padding: 12px 16px; }
        .badge { display: inline-block; padding: 2px 8px; border-radius: 10px; font-size: 10px; font-weight: 600; }
        .badge-available { background: #dcfce7; color: #166534; }
        .badge-pending { background: #fef9c3; color: #854d0e; }
        .badge-booked { background: #dbeafe; color: #1e40af; }
        .badge-approved { background: #dcfce7; color: #166534; }
        .badge-cancelled { background: #fee2e2; color: #991b1b; }
        .badge-pre-booked { background: #e0e7ff; color: #3730a3; }
        .badge-active { background: #dcfce7; color: #166534; }
        .badge-inactive { background: #fee2e2; color: #991b1b; }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-100">
    
    <!-- Floating Print Button -->
    <div class="no-print fixed top-3 right-3 flex gap-2 z-50">
        <button onclick="window.close()" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded text-sm shadow-lg">✕ Close</button>
        <button onclick="window.print()" class="bg-primary hover:bg-green-700 text-white px-4 py-2 rounded text-sm shadow-lg">🖨 Print Report</button>
    </div>

    <!-- Report Content -->
    <div class="bg-white max-w-[1200px] mx-auto my-4 border border-gray-300">
        
        <!-- Header with Company Info -->
        <div class="border-b-2 border-primary">
            <div class="flex items-center justify-between px-6 py-4">
                <div class="flex items-center gap-4">
                    @if($company['site_logo'])
                        <img src="{{ asset('uploads/admin/' . $company['site_logo']) }}" alt="{{ $company['site_name'] }}" class="h-14">
                    @else
                        <img src="{{ asset('assets/logo-w.png') }}" alt="{{ $company['site_name'] }}" class="h-14">
                    @endif
                    <div class="border-l-2 border-primary pl-4">
                        <h2 class="text-base font-bold text-gray-800">{{ $company['site_name'] }}</h2>
                        @if($company['address'])
                            <p class="text-xs text-gray-500">{{ $company['address'] }}</p>
                        @endif
                        <p class="text-xs text-gray-500">
                            @if($company['phone']){{ $company['phone'] }}@endif
                            @if($company['phone'] && $company['email']) | @endif
                            @if($company['email']){{ $company['email'] }}@endif
                        </p>
                    </div>
                </div>
                <div class="text-right">
                    <h1 class="text-lg font-bold text-primary uppercase">@yield('report-title', 'Report')</h1>
                    <p class="text-xs text-gray-500">Generated: {{ now()->format('d F Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Filters Applied -->
        @if(!empty($filters) && count(array_filter($filters)))
        <div class="px-6 py-3 bg-gray-50 border-b text-xs text-gray-600">
            <strong>Filters Applied:</strong>
            @foreach($filters as $key => $value)
                @if($value && $key !== '_token')
                    <span class="inline-block bg-white border rounded px-2 py-0.5 ml-1">{{ ucwords(str_replace('_', ' ', $key)) }}: <strong>{{ $value }}</strong></span>
                @endif
            @endforeach
        </div>
        @endif

        <!-- Report Body -->
        <div class="p-6">
            @yield('content')
        </div>

        <!-- Footer -->
        <div class="border-t px-6 py-3 text-center text-xs text-gray-400">
            @auth
            <p class="text-gray-600 font-semibold mb-0.5">Printed by: {{ auth()->user()->name }}@if(auth()->user()->role) ({{ ucfirst(auth()->user()->role) }})@endif</p>
            @endauth
            <p>This report was generated by {{ $company['site_name'] }} on {{ now()->format('d F Y') }} at {{ now()->format('h:i A') }}. &copy; {{ date('Y') }} {{ $company['site_name'] }}. All rights reserved.</p>
        </div>
    </div>

    @stack('scripts')
</body>
</html>
