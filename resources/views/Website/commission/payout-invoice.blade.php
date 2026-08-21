<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=800">
    <title>Commission Receipt #{{ str_pad($commissionPayout->id, 6, '0', STR_PAD_LEFT) }}</title>
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
            @page { margin: 8mm; size: A4 portrait; }
        }
        .label { color: #374151; font-size: 12px; font-weight: 500; }
        .value { color: #1f2937; font-weight: 600; }
    </style>
</head>
<body class="bg-gray-100">

    <!-- Action Buttons -->
    <div class="no-print fixed top-3 right-3 flex gap-2 z-50">
        <a href="{{ route('commission.payouts') }}" class="bg-gray-600 text-white px-4 py-2 rounded text-sm">← Back</a>
        <button onclick="window.print()" class="bg-primary text-white px-4 py-2 rounded text-sm">Print Receipt</button>
    </div>

    <!-- Receipt -->
    <div class="bg-white max-w-3xl mx-auto my-4 border border-gray-300">

        <!-- Header -->
        @php
            $invoiceAddress = \App\Models\WebsiteSetting::get('office_address', '123 Business Street, Dhaka, Bangladesh');
            $invoicePhone = \App\Models\WebsiteSetting::get('phone_primary', '+880 1322-902986');
            $invoiceEmail = \App\Models\WebsiteSetting::get('contact_email', 'info@londonabd.com');

            $service = new \App\Services\CommissionService();
            $earningsSummary = $service->earningsSummaryFor($commissionPayout->user);
            $legacyCommission = $service->legacyCommissionFor($commissionPayout->user);
            $totalEarned = $earningsSummary['total'] + $legacyCommission;
            $totalPaidOut = $service->payoutTotalFor($commissionPayout->user);
            $balanceDue = $service->balanceFor($commissionPayout->user);
        @endphp
        <div class="border-b-2 border-primary">
            <div class="flex items-center justify-between px-5 py-4">
                <!-- Left: Logo & Company Info -->
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('assets/logo-w.png') }}" alt="{{ site_name() }}" class="h-14">
                    </div>
                    <div class="pl-4">
                        <h2 class="text-base font-bold text-gray-800">{{ site_legal_name() }}</h2>
                        <p class="text-xs text-gray-600">{{ $invoiceAddress }}</p>
                        <p class="text-xs text-gray-600">{{ $invoicePhone }} | {{ $invoiceEmail }}</p>
                    </div>
                </div>

                <!-- Right: Receipt Info -->
                <div class="text-right">
                    <h1 class="text-lg font-bold text-primary uppercase">Commission Receipt</h1>
                    <p class="text-sm text-gray-700 font-semibold">#{{ str_pad($commissionPayout->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-xs text-gray-500">{{ $commissionPayout->created_at->format('d F Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-5">

            <!-- Commission User & Reference Details - Two Columns -->
            <div class="grid grid-cols-2 gap-6 mb-5">

                <!-- Commission User Details -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Commission User Details</h3>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1 w-28">User ID</td>
                            <td class="value py-1 text-primary">: CU-{{ str_pad($commissionPayout->user->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Name</td>
                            <td class="value py-1">: {{ $commissionPayout->user->name }}</td>
                        </tr>
                        @if($commissionPayout->user->commission_type)
                        <tr>
                            <td class="label py-1">Designation</td>
                            <td class="value py-1">: {{ $commissionPayout->user->commissionTypeLabel() }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label py-1">Phone</td>
                            <td class="value py-1">: {{ $commissionPayout->user->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Email</td>
                            <td class="value py-1">: {{ $commissionPayout->user->email }}</td>
                        </tr>
                        @if($commissionPayout->user->referral_code)
                        <tr>
                            <td class="label py-1">Referral Code</td>
                            <td class="value py-1">: {{ $commissionPayout->user->referral_code }}</td>
                        </tr>
                        @endif
                    </table>
                </div>

                <!-- Reference Details -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Payout Reference</h3>
                    <table class="w-full text-sm">
                        @if($commissionPayout->booking)
                        <tr>
                            <td class="label py-1 w-28">Booking ID</td>
                            <td class="value py-1 text-primary">: #{{ str_pad($commissionPayout->booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        @if($commissionPayout->booking->plot)
                        <tr>
                            <td class="label py-1">Plot No</td>
                            <td class="value py-1">: {{ $commissionPayout->booking->plot->plot_no }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label py-1">Customer</td>
                            <td class="value py-1">: {{ $commissionPayout->booking->user->name ?? 'N/A' }}</td>
                        </tr>
                        @else
                        <tr>
                            <td class="label py-1 w-28">Payout Type</td>
                            <td class="value py-1">: Commission balance payout</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label py-1">Payout Date</td>
                            <td class="value py-1">: {{ $commissionPayout->created_at->format('d M Y') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            <!-- Payout Details -->
            <div class="mb-5">
                <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Payout Details</h3>
                <div class="bg-primary/5 p-3 rounded">
                    <div class="grid grid-cols-2 gap-4 text-sm">
                        <div>
                            <span class="label">Payout Date</span>
                            <p class="value text-base">{{ $commissionPayout->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="label">Amount Received</span>
                            <p class="value text-xl text-primary">৳{{ number_format($commissionPayout->amount, 2) }}</p>
                        </div>
                    </div>

                    @if($commissionPayout->payment_note)
                    <div class="mt-2 pt-2 border-t border-gray-200">
                        <span class="label">Note:</span> <span class="text-gray-700">{{ $commissionPayout->payment_note }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Commission Summary -->
            <div class="mb-4">
                <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Commission Account Summary</h3>
                <div class="grid grid-cols-2 gap-4">
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1">Earned from Own Sales</td>
                            <td class="value py-1 text-right">৳{{ number_format($earningsSummary['own'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Earned from Team Sales</td>
                            <td class="value py-1 text-right">৳{{ number_format($earningsSummary['override'], 2) }}</td>
                        </tr>
                        @if($legacyCommission > 0)
                        <tr>
                            <td class="label py-1">Legacy Commission</td>
                            <td class="value py-1 text-right">৳{{ number_format($legacyCommission, 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label py-1">Total Commission Earned</td>
                            <td class="value py-1 text-right text-primary">৳{{ number_format($totalEarned, 2) }}</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="label py-1 font-semibold">This Payout</td>
                            <td class="value py-1 text-right text-primary text-base">৳{{ number_format($commissionPayout->amount, 2) }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Total Paid Out</td>
                            <td class="value py-1 text-right">৳{{ number_format($totalPaidOut, 2) }}</td>
                        </tr>
                        @if($balanceDue > 0)
                        <tr>
                            <td class="label py-1 font-semibold">Remaining Balance</td>
                            <td class="value py-1 text-right text-red-600 text-base">৳{{ number_format($balanceDue, 2) }}</td>
                        </tr>
                        @else
                        <tr>
                            <td class="label py-1 font-semibold">Status</td>
                            <td class="value py-1 text-right text-primary text-base">✅ Fully Paid</td>
                        </tr>
                        @endif
                    </table>
                </div>
            </div>

            <!-- Footer Note -->
            <div class="border-t border-gray-200 pt-3 mt-4 text-xs text-gray-500 text-center">
                This is an official commission payout receipt issued by {{ site_legal_name() }}
                Receipt #{{ str_pad($commissionPayout->id, 6, '0', STR_PAD_LEFT) }} | Generated: {{ now()->format('d M Y, h:i A') }}
            </div>

        </div>

    </div>

</body>
</html>
