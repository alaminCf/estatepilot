<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=800">
    <title>Receipt #{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/icon.png') }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2A8441',
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
        <a href="{{ url()->previous() }}" class="bg-gray-600 text-white px-4 py-2 rounded text-sm">← Back</a>
        <button onclick="window.print()" class="bg-primary text-white px-4 py-2 rounded text-sm">Print Receipt</button>
    </div>

    <!-- Receipt -->
    <div class="bg-white max-w-3xl mx-auto my-4 border border-gray-300">
        
        <!-- Combined Header -->
        @php
            $invoiceAddress = \App\Models\WebsiteSetting::get('office_address', '123 Business Street, Dhaka, Bangladesh');
            $invoicePhone = \App\Models\WebsiteSetting::get('phone_primary', '+880 1322-902986');
            $invoiceEmail = \App\Models\WebsiteSetting::get('contact_email', 'info@londonabd.com');
        @endphp
        <div class="border-b-2 border-primary">
            <div class="flex items-center justify-between px-5 py-4">
                <!-- Left: Logo & Company Info -->
                <div class="flex items-center gap-4">
                    <div class="flex flex-col items-center">
                        <img src="{{ asset('assets/logo-w.png') }}" alt="London Abason" class="h-14">
                    </div>
                    <div class="pl-4">
                        <h2 class="text-base font-bold text-gray-800">London Abason Ltd.</h2>
                        <p class="text-xs text-gray-600">{{ $invoiceAddress }}</p>
                        <p class="text-xs text-gray-600">{{ $invoicePhone }} | {{ $invoiceEmail }}</p>
                    </div>
                </div>
                
                <!-- Right: Receipt Info -->
                <div class="text-right">
                    <h1 class="text-lg font-bold text-primary uppercase">
                        @if($payment->payment_type == 'Booking Payment')
                            Booking Receipt
                        @elseif($payment->payment_type == 'Part Of Installment')
                            Part Payment Receipt
                        @else
                            Installment Receipt
                        @endif
                    </h1>
                    <p class="text-sm text-gray-700 font-semibold">#{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p class="text-xs text-gray-500">{{ $payment->created_at->format('d F Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="p-5">

            <!-- Customer & Property Details - Two Columns -->
            <div class="grid grid-cols-2 gap-6 mb-5">
                
                <!-- Customer Details -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Customer Details</h3>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1 w-24">Client ID</td>
                            <td class="value py-1 text-primary">: CID-{{ str_pad($payment->booking->user->client_id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Name</td>
                            <td class="value py-1">: {{ $payment->booking->user->name }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Phone</td>
                            <td class="value py-1">: {{ $payment->booking->user->phone ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Email</td>
                            <td class="value py-1">: {{ $payment->booking->user->email }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Address</td>
                            <td class="value py-1">: {{ $payment->booking->user->address ?? 'N/A' }}</td>
                        </tr>
                    </table>
                </div>

                <!-- Property Details -->
                <div>
                    <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Property Details</h3>
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1 w-24">Plot No</td>
                            <td class="value py-1">: {{ $payment->booking->plot->plot_no }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Size</td>
                            <td class="value py-1">: {{ $payment->booking->plot->size_katha }} Katha</td>
                        </tr>
                        @if($payment->booking->plot->block)
                        <tr>
                            <td class="label py-1">Block</td>
                            <td class="value py-1">: {{ $payment->booking->plot->block }}</td>
                        </tr>
                        @endif
                        @if($payment->booking->plot->road_no)
                        <tr>
                            <td class="label py-1">Road</td>
                            <td class="value py-1">: {{ $payment->booking->plot->road_no }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label py-1">Booking ID</td>
                            <td class="value py-1">: #{{ str_pad($payment->booking->id, 5, '0', STR_PAD_LEFT) }}</td>
                        </tr>
                    </table>
                </div>

            </div>

            @if(!empty($payment->booking->owners) && count($payment->booking->owners) > 0)
            <table class="w-full text-sm mb-5" style="margin-top: -1rem;">
                <tr>
                    <td class="label py-1" style="width: 120px;">Additional Owners</td>
                    <td class="value py-1">: {{ implode(', ', array_column($payment->booking->owners, 'name')) }}</td>
                </tr>
            </table>
            @endif

            <!-- Payment Details -->
            <div class="mb-5">
                <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Payment Details</h3>
                <div class="bg-primary/5 p-3 rounded">
                    <div class="grid grid-cols-3 gap-4 text-sm">
                        <div>
                            <span class="label">Payment Type</span>
                            <p class="value text-base text-primary">
                                {{ $payment->payment_type }}
                            </p>
                        </div>
                        <div>
                            <span class="label">Payment Date</span>
                            <p class="value text-base">{{ $payment->created_at->format('d M Y') }}</p>
                        </div>
                        <div>
                            <span class="label">Amount Received</span>
                            <p class="value text-xl text-primary">৳{{ format_bd_number($payment->amount, 2) }}</p>
                        </div>
                    </div>

                    {{-- Part Of Installment: Show remaining to complete current installment --}}
                    @if($payment->payment_type == 'Part Of Installment' && !empty($invoiceExtra))
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        <div class="bg-amber-50 border border-amber-200 rounded p-3">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                                <span class="font-bold text-amber-800 text-sm">Installment #{{ $invoiceExtra['instalment_number'] }} — Partial Payment</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3 text-sm">
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">EMI Amount</span>
                                    <span class="font-bold text-gray-800">৳{{ format_bd_number($invoiceExtra['emi_amount'], 2) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">Paid So Far</span>
                                    <span class="font-bold text-primary">৳{{ format_bd_number($invoiceExtra['partial_accumulated'], 2) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">Remaining</span>
                                    <span class="font-bold {{ $invoiceExtra['remaining_to_complete'] > 0 ? 'text-red-600' : 'text-green-600' }}">
                                        @if($invoiceExtra['remaining_to_complete'] > 0)
                                            ৳{{ format_bd_number($invoiceExtra['remaining_to_complete'], 2) }}
                                        @else
                                            Completed!
                                        @endif
                                    </span>
                                </div>
                            </div>
                            @if($invoiceExtra['remaining_to_complete'] > 0)
                            <p class="text-xs text-amber-700 mt-2 text-center italic">
                                You still need to pay ৳{{ format_bd_number($invoiceExtra['remaining_to_complete'], 2) }} to complete Installment #{{ $invoiceExtra['instalment_number'] }}.
                            </p>
                            @else
                            <p class="text-xs text-green-700 mt-2 text-center italic">
                                Installment #{{ $invoiceExtra['instalment_number'] }} has been fully completed with this partial payment.
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif

                    {{-- Full Installment Payment: Show breakdown for multiple installments --}}
                    @if($payment->payment_type == 'Installment Payment' && !empty($invoiceExtra))
                    <div class="mt-3 pt-3 border-t border-gray-200">
                        @if($payment->instalment_quantity > 1)
                        <div class="bg-blue-50 border border-blue-200 rounded p-3 mb-2">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-blue-600" fill="currentColor" viewBox="0 0 20 20"><path d="M6 2a2 2 0 00-2 2v12a2 2 0 002 2h8a2 2 0 002-2V7.414A2 2 0 0015.414 6L12 2.586A2 2 0 0010.586 2H6zm5 6a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V8z"/></svg>
                                <span class="font-bold text-blue-800 text-sm">Multiple Installments Covered</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3 text-sm">
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">Installments Paid</span>
                                    <span class="font-bold text-gray-800">{{ $payment->instalment_quantity }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">EMI Rate</span>
                                    <span class="font-bold text-gray-800">৳{{ format_bd_number($invoiceExtra['emi_amount'], 2) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">Breakdown</span>
                                    <span class="font-bold text-primary">{{ $payment->instalment_quantity }} × ৳{{ format_bd_number($invoiceExtra['emi_amount'], 2) }}</span>
                                </div>
                            </div>
                        </div>
                        @elseif($payment->instalment_quantity == 1)
                        <div class="mb-2">
                            <span class="label">Installment Covered:</span>
                            <span class="text-gray-700 font-semibold">1 installment</span>
                            @if(!empty($invoiceExtra['partial_accumulated_before']) && $invoiceExtra['partial_accumulated_before'] > 0)
                                <div class="text-xs text-gray-500 mt-1">
                                    Prior partial payments: ৳{{ format_bd_number($invoiceExtra['partial_accumulated_before'], 2) }} + This payment: ৳{{ format_bd_number($payment->amount, 2) }} = Installment completed
                                </div>
                            @endif
                        </div>
                        @endif

                        {{-- Overpayment notice: admin paid more than expected, reduces future EMI --}}
                        @if(!empty($invoiceExtra['overpayment']) && $invoiceExtra['overpayment'] > 0)
                        <div class="bg-green-50 border border-green-200 rounded p-3">
                            <div class="flex items-center gap-2 mb-2">
                                <svg class="w-4 h-4 text-green-600" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                                <span class="font-bold text-green-800 text-sm">Advance Payment Applied</span>
                            </div>
                            <div class="grid grid-cols-3 gap-3 text-sm">
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">Expected Amount</span>
                                    <span class="font-bold text-gray-800">৳{{ format_bd_number($invoiceExtra['expected_amount'], 2) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">Extra Paid</span>
                                    <span class="font-bold text-green-600">+৳{{ format_bd_number($invoiceExtra['overpayment'], 2) }}</span>
                                </div>
                                <div class="text-center">
                                    <span class="block text-xs text-gray-500 uppercase">New EMI</span>
                                    <span class="font-bold text-primary">৳{{ format_bd_number($invoiceExtra['new_emi'], 2) }}</span>
                                </div>
                            </div>
                            <p class="text-xs text-green-700 mt-2 text-center italic">
                                The extra payment of ৳{{ format_bd_number($invoiceExtra['overpayment'], 2) }} has been applied to reduce your remaining EMI from ৳{{ format_bd_number($invoiceExtra['emi_amount'], 2) }} to ৳{{ format_bd_number($invoiceExtra['new_emi'], 2) }}.
                            </p>
                        </div>
                        @endif
                    </div>
                    @endif

                    @if($payment->payment_note)
                    <div class="mt-2 pt-2 border-t border-gray-200">
                        <span class="label">Note:</span> <span class="text-gray-700">{{ $payment->payment_note }}</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Financial Summary -->
            <div class="mb-4">
                <h3 class="text-sm font-bold text-gray-700 uppercase border-b border-gray-200 pb-1 mb-2">Financial Summary</h3>
                <div class="grid grid-cols-2 gap-4">
                    
                    <!-- Left Column -->
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1">Total Plot Price</td>
                            <td class="value py-1 text-right">৳{{ format_bd_number($financialSummary['total_price'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Total Amount Paid</td>
                            <td class="value py-1 text-right text-primary">৳{{ format_bd_number($financialSummary['total_paid'], 2) }}</td>
                        </tr>
                        <tr class="border-t border-gray-200">
                            <td class="label py-1 font-semibold">Outstanding Balance</td>
                            <td class="value py-1 text-right text-red-600 text-base">৳{{ format_bd_number($financialSummary['outstanding_balance'], 2) }}</td>
                        </tr>
                    </table>

                    <!-- Right Column - Installment Info -->
                    @if(in_array($payment->payment_type, ['Installment Payment', 'Part Of Installment']))
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1">Payment Plan</td>
                            <td class="value py-1 text-right capitalize">{{ $financialSummary['installment_plan'] ?? 'N/A' }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Original EMI Amount</td>
                            <td class="value py-1 text-right">৳{{ format_bd_number($financialSummary['installment_payment'] ?? 0, 2) }}</td>
                        </tr>
                        @if($financialSummary['adjusted_installment'] > 0 && abs($financialSummary['adjusted_installment'] - $financialSummary['installment_payment']) > 0.01 && empty($invoiceExtra['partial_accumulated_before']))
                        <tr>
                            <td class="label py-1">Adjusted EMI Amount</td>
                            <td class="value py-1 text-right text-primary">৳{{ format_bd_number($financialSummary['adjusted_installment'], 2) }}</td>
                        </tr>
                        @endif
                        <tr>
                            <td class="label py-1">Installments Paid</td>
                            <td class="value py-1 text-right">{{ $financialSummary['paid_installments'] }} of {{ $financialSummary['total_installments'] ?? 0 }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Remaining Installments</td>
                            <td class="value py-1 text-right">{{ $financialSummary['remaining_installments'] ?? 0 }}</td>
                        </tr>
                    </table>
                    @else
                    <table class="w-full text-sm">
                        <tr>
                            <td class="label py-1">Booking Payments</td>
                            <td class="value py-1 text-right">৳{{ format_bd_number($financialSummary['booking_payments_received'], 2) }}</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Payment Progress</td>
                            <td class="value py-1 text-right">{{ $financialSummary['payment_progress'] }}%</td>
                        </tr>
                        <tr>
                            <td class="label py-1">Booking Status</td>
                            <td class="value py-1 text-right capitalize">{{ $payment->booking->status }}</td>
                        </tr>
                    </table>
                    @endif

                </div>
            </div>

            @if($payment->booking->agent)
            <!-- Agent Info -->
            <div class="text-sm text-gray-600 border-t border-gray-200 pt-2">
                Referred by: <span class="font-semibold text-gray-800">{{ $payment->booking->agent->name }}</span>
                @if($payment->booking->agent->phone) ({{ $payment->booking->agent->phone }})@endif
            </div>
            @endif

        </div>

        <!-- Footer with QR -->
        <div class="flex items-center justify-between px-5 py-3 border-t border-gray-300 bg-gray-50">
            <div class="text-xs text-gray-500">
                <p>This is a computer-generated receipt.</p>
                <p>Generated on: {{ now()->format('d M Y, h:i A') }}</p>
            </div>
            <div class="text-center text-xs text-gray-500">
                <p class="font-semibold text-gray-700">Thank you for choosing London Abason</p>
            </div>
            <div class="text-right">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=60x60&data={{ urlencode(request()->url()) }}" alt="QR" class="w-12 h-12 inline-block">
                <p class="text-[10px] text-gray-400 mt-1">Scan for online copy</p>
            </div>
        </div>

    </div>

</body>
</html>
