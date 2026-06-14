<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Booking;
use App\Services\CommissionService;
use App\Services\EmailService;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    /**
     * Calculate instalment summary for a booking.
     */
    private function getInstalmentSummary(Booking $booking): array
    {
        $payments = $booking->payments;
        $totalPaid = $payments->sum('amount');

        // Count paid instalments from instalment_quantity (both full and partial instalment payments)
        $paidInstallments = (int) $payments->whereIn('payment_type', ['Installment Payment', 'Part Of Installment'])->sum('instalment_quantity');

        // Calculate partial payment accumulation toward current instalment
        $partialPayments = $payments->where('payment_type', 'Part Of Installment');
        $partialTotal = (float) $partialPayments->sum('amount');

        $remainingInstallments = max(0, ($booking->total_installments ?? 0) - $paidInstallments);
        $outstandingBalance = max(0, $booking->price - $totalPaid);
        $originalInstalment = (float) $booking->installment_payment;

        // Adjusted installment = remaining balance / remaining installments
        // Exclude uncommitted partial payments so EMI stays stable
        // (partial payments reduce outstanding but shouldn't change per-instalment amount)
        $outstandingForEMI = $outstandingBalance + $partialTotal;
        $adjustedInstallment = $remainingInstallments > 0 ? round($outstandingForEMI / $remainingInstallments, 2) : 0;

        // Calculate how much of the current instalment has been partially paid
        // (partial payments that haven't completed a full instalment yet)
        $partialTowardCurrentInstalment = 0;
        if ($adjustedInstallment > 0 && $partialTotal > 0) {
            // The partial payments that didn't complete a full instalment
            $partialTowardCurrentInstalment = fmod($partialTotal, $adjustedInstallment);
            if ($partialTowardCurrentInstalment < 0.01) {
                $partialTowardCurrentInstalment = 0;
            }
        }
        $remainingForCurrentInstalment = $adjustedInstallment > 0 ? max(0, $adjustedInstallment - $partialTowardCurrentInstalment) : 0;

        $bookingPayments = (float) $payments->where('payment_type', 'Booking Payment')->sum('amount');

        return [
            'total_price' => $booking->price,
            'total_paid' => $totalPaid,
            'outstanding_balance' => $outstandingBalance,
            'booking_payment_expected' => $booking->booking_payment,
            'booking_payments_received' => $bookingPayments,
            'installment_payment' => $originalInstalment,
            'adjusted_installment' => $adjustedInstallment,
            'total_installments' => $booking->total_installments,
            'paid_installments' => $paidInstallments,
            'remaining_installments' => $remainingInstallments,
            'installment_plan' => $booking->installment_plan,
            'payments_count' => $payments->count(),
            'payment_progress' => $booking->price > 0 ? round(($totalPaid / $booking->price) * 100, 2) : 0,
            'partial_toward_current_instalment' => round($partialTowardCurrentInstalment, 2),
            'remaining_for_current_instalment' => round($remainingForCurrentInstalment, 2),
            'partial_payments_total' => round($partialTotal, 2),
        ];
    }

    /**
     * Display a listing of payments.
     */
    public function index(Request $request)
    {
        $query = Payment::with(['booking.plot', 'booking.user'])->latest();

        // Payment ID filter
        if ($request->filled('payment_id')) {
            $query->where('id', (int) preg_replace('/\D/', '', $request->payment_id));
        }

        // Client ID filter (accepts "CID-00003" or plain "3")
        if ($request->filled('client_id')) {
            $clientId = (int) preg_replace('/\D/', '', $request->client_id);
            $query->whereHas('booking.user', fn($q) => $q->where('client_id', $clientId));
        }

        // Plot No filter
        if ($request->filled('plot_no')) {
            $plotNo = $request->plot_no;
            $query->whereHas('booking.plot', fn($q) => $q->where('plot_no', 'like', '%' . $plotNo . '%'));
        }

        // Search filter
        if ($request->search) {
            $search = $request->search;
            $searchClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $search, $m)) {
                $searchClientId = (int) $m[1];
            }
            $query->where(function($q) use ($search, $searchClientId) {
                $q->whereHas('booking.user', function ($uq) use ($search, $searchClientId) {
                    $uq->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                    if ($searchClientId !== null) {
                        $uq->orWhere('client_id', $searchClientId);
                    }
                })->orWhereHas('booking.plot', function ($pq) use ($search) {
                    $pq->where('plot_no', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->booking_id) {
            $query->where('booking_id', $request->booking_id);
        }

        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        // Date range filter
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $perPage = $request->per_page ?? 25;
        $payments = $query->paginate($perPage)->appends($request->except('page'));
        $bookings = Booking::with(['plot', 'user'])->get();

        return view('Accounts.Admin.payments.index', compact('payments', 'bookings'));
    }

    /**
     * Export payments to CSV.
     */
    public function export(Request $request)
    {
        $query = Payment::with(['booking.plot', 'booking.user'])->latest();

        if ($request->filled('payment_id')) {
            $query->where('id', (int) preg_replace('/\D/', '', $request->payment_id));
        }

        if ($request->filled('client_id')) {
            $clientId = (int) preg_replace('/\D/', '', $request->client_id);
            $query->whereHas('booking.user', fn($q) => $q->where('client_id', $clientId));
        }

        if ($request->filled('plot_no')) {
            $plotNo = $request->plot_no;
            $query->whereHas('booking.plot', fn($q) => $q->where('plot_no', 'like', '%' . $plotNo . '%'));
        }

        if ($request->search) {
            $search = $request->search;
            $searchClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $search, $m)) {
                $searchClientId = (int) $m[1];
            }
            $query->where(function($q) use ($search, $searchClientId) {
                $q->whereHas('booking.user', function ($uq) use ($search, $searchClientId) {
                    $uq->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%');
                    if ($searchClientId !== null) {
                        $uq->orWhere('client_id', $searchClientId);
                    }
                })->orWhereHas('booking.plot', function ($pq) use ($search) {
                    $pq->where('plot_no', 'like', '%' . $search . '%');
                });
            });
        }

        if ($request->booking_id) {
            $query->where('booking_id', $request->booking_id);
        }

        if ($request->payment_type) {
            $query->where('payment_type', $request->payment_type);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $payments = $query->get();

        $filename = 'payments_' . now()->format('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function () use ($payments) {
            $file = fopen('php://output', 'w');

            fputcsv($file, [
                'Payment ID', 'Booking ID', 'Plot No', 'Plot Title',
                'Customer Name', 'Customer Email', 'Customer Phone',
                'Payment Type', 'Instalment Qty', 'Amount', 'Payment Date', 'Notes',
            ]);

            foreach ($payments as $payment) {
                fputcsv($file, [
                    $payment->id,
                    $payment->booking_id,
                    $payment->booking->plot->plot_no,
                    $payment->booking->plot->title,
                    $payment->booking->user->name,
                    $payment->booking->user->email,
                    $payment->booking->user->phone ?? 'N/A',
                    $payment->payment_type,
                    $payment->instalment_quantity,
                    number_format($payment->amount, 2, '.', ''),
                    $payment->created_at->format('Y-m-d'),
                    $payment->payment_note ?? 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new payment.
     */
    public function create(Request $request)
    {
        $bookings = Booking::with(['plot', 'user'])->whereIn('status', ['approved', 'pre-booked'])->get();

        $selectedBooking = null;
        $summary = null;
        $paymentType = $request->get('payment_type');
        $bookingId = $request->get('booking_id');

        if ($paymentType && $bookingId) {
            $selectedBooking = Booking::with(['plot', 'user', 'payments'])->find($bookingId);
            if ($selectedBooking) {
                $summary = $this->getInstalmentSummary($selectedBooking);
            }
        }

        return view('Accounts.Admin.payments.create', compact('bookings', 'selectedBooking', 'summary', 'paymentType', 'bookingId'));
    }

    /**
     * AJAX: Search bookings for Select2 dropdown.
     */
    public function searchBookings(Request $request)
    {
        $search = $request->get('q', '');

        $query = Booking::with(['plot', 'user'])->whereIn('status', ['approved', 'pre-booked']);

        if ($search) {
            $searchClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $search, $m)) {
                $searchClientId = (int) $m[1];
            }
            $query->where(function ($q) use ($search, $searchClientId) {
                $q->whereHas('user', function ($uq) use ($search, $searchClientId) {
                    $uq->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                    if ($searchClientId !== null) {
                        $uq->orWhere('client_id', $searchClientId);
                    }
                })->orWhereHas('plot', function ($pq) use ($search) {
                    $pq->where('plot_no', 'like', "%{$search}%")
                        ->orWhere('title', 'like', "%{$search}%");
                })->orWhere('id', $search);
            });
        }

        $bookings = $query->limit(20)->get();

        return response()->json([
            'results' => $bookings->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'text' => '#' . str_pad($booking->id, 5, '0', STR_PAD_LEFT)
                        . ' | ' . $booking->plot->plot_no
                        . ' | ' . $booking->user->name
                        . ' (' . $booking->user->phone . ')',
                ];
            }),
        ]);
    }

    /**
     * AJAX: Get booking details for payment form.
     */
    public function getBookingDetails(Booking $booking)
    {
        $booking->load(['plot', 'user', 'payments']);

        $summary = $this->getInstalmentSummary($booking);

        return response()->json([
            'booking' => [
                'id' => $booking->id,
                'plot' => [
                    'plot_no' => $booking->plot->plot_no,
                    'title' => $booking->plot->title,
                    'size_katha' => $booking->plot->size_katha,
                    'block' => $booking->plot->block,
                ],
                'user' => [
                    'id' => $booking->user->id,
                    'name' => $booking->user->name,
                    'phone' => $booking->user->phone,
                    'email' => $booking->user->email,
                    'photo' => $booking->user->photo,
                    'profile_image_url' => $booking->user->profile_image_url,
                ],
                'price' => $booking->price,
                'booking_payment' => $booking->booking_payment,
                'installment_payment' => $booking->installment_payment,
                'installment_plan' => $booking->installment_plan,
                'total_installments' => $booking->total_installments,
            ],
            'summary' => $summary,
        ]);
    }

    /**
     * Store a newly created payment.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'booking_id' => 'required|exists:bookings,id',
            'payment_type' => 'required|in:Booking Payment,Down Payment,Installment Payment,Part Of Installment',
            'amount' => 'required|numeric|min:0.01',
            'instalment_quantity' => 'nullable|integer|min:0',
            'payment_note' => 'nullable|string',
            'payment_date' => 'nullable|date',
            'payment_time' => 'nullable|date_format:H:i',
        ]);

        // Remove date/time from validated (will set created_at manually)
        $paymentDate = $validated['payment_date'] ?? null;
        $paymentTime = $validated['payment_time'] ?? null;
        unset($validated['payment_date'], $validated['payment_time']);

        $booking = Booking::with(['plot', 'user', 'payments'])->findOrFail($validated['booking_id']);

        // Set instalment_quantity based on payment type
        if ($validated['payment_type'] === 'Installment Payment') {
            $qty = (int) ($validated['instalment_quantity'] ?? 0);
            if ($qty <= 0) {
                // Auto-calculate from amount if not provided
                $summary = $this->getInstalmentSummary($booking);
                $adjustedEMI = $summary['adjusted_installment'];
                // Account for accumulated partial payments toward current instalment
                $partialAccum = $summary['partial_toward_current_instalment'];
                $remainingForCurrent = $adjustedEMI > 0 ? max(0, $adjustedEMI - $partialAccum) : 0;
                if ($remainingForCurrent > 0 && $validated['amount'] >= $remainingForCurrent - 0.01) {
                    // This payment completes the current instalment (partials + this >= EMI)
                    $leftover = $validated['amount'] - $remainingForCurrent;
                    $qty = 1 + ($adjustedEMI > 0 ? (int) floor($leftover / $adjustedEMI) : 0);
                } else {
                    $qty = $adjustedEMI > 0 ? (int) floor($validated['amount'] / $adjustedEMI) : 0;
                }
            }
            $validated['instalment_quantity'] = max(0, $qty);
        } elseif ($validated['payment_type'] === 'Part Of Installment') {
            // Part Of Installment never counts as a full instalment
            $validated['instalment_quantity'] = 0;
        } else {
            $validated['instalment_quantity'] = 0;
        }

        // Validate amount doesn't exceed outstanding balance
        $totalPaid = $booking->payments->sum('amount');
        $outstandingBalance = $booking->price - $totalPaid;

        if ($validated['amount'] > $outstandingBalance + 0.01) {
            return back()->withErrors(['amount' => 'Amount (৳' . number_format($validated['amount'], 2) . ') exceeds outstanding balance (৳' . number_format($outstandingBalance, 2) . ').'])->withInput();
        }

        $payment = DB::transaction(function () use ($validated, $paymentDate, $paymentTime) {
            $payment = Payment::create($validated);

            // Set custom payment date if provided
            if ($paymentDate) {
                $time = $paymentTime ?? now()->format('H:i');
                $payment->created_at = $paymentDate . ' ' . $time . ':00';
                $payment->save();
            }

            // Distribute commission to the seller's chain (hierarchy bookings only)
            (new CommissionService())->recordEarningsForPayment($payment);

            return $payment;
        });

        // Send SMS notification
        if ($booking->user && $booking->user->phone) {
            try {
                $smsService = new SmsService();
                $smsService->sendPaymentConfirmation(
                    $booking->user->phone,
                    number_format($validated['amount'], 0, '.', ','),
                    $booking->plot->plot_no
                );
            } catch (\Exception $e) {
                // SMS failure should not block payment recording
            }
        }

        // Send email with invoice link to the customer
        if ($booking->user && $booking->user->email) {
            try {
                $emailService = new EmailService();
                $emailService->sendPaymentRecordedEmail($payment, $booking, $booking->user);
            } catch (\Exception $e) {
                \Log::error('Failed to send payment invoice email to customer', [
                    'payment_id' => $payment->id,
                    'user_id' => $booking->user->id,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return redirect()->route('admin.payments.index')->with('success', 'Payment recorded successfully.');
    }

    /**
     * Display the specified payment.
     */
    public function show(Payment $payment)
    {
        $payment->load(['booking.plot', 'booking.user', 'booking.payments']);
        return view('Accounts.Admin.payments.show', compact('payment'));
    }

    /**
     * Display the payment invoice with complete booking financial summary.
     */
    public function invoice(Payment $payment)
    {
        $payment->load(['booking.plot', 'booking.user', 'booking.agent', 'booking.payments']);

        $booking = $payment->booking;
        $financialSummary = $this->getInstalmentSummary($booking);

        // Calculate extra invoice details for instalment payments
        $invoiceExtra = [];
        if (in_array($payment->payment_type, ['Installment Payment', 'Part Of Installment'])) {
            $adjustedEMI = $financialSummary['adjusted_installment'];
            $qty = $payment->instalment_quantity;
            $amount = (float) $payment->amount;

            if ($payment->payment_type === 'Part Of Installment') {
                // Calculate remaining to complete the current instalment
                // Look at all partial payments before and including this one
                $allPartials = $booking->payments
                    ->where('payment_type', 'Part Of Installment')
                    ->where('created_at', '<=', $payment->created_at)
                    ->sum('amount');

                // Get the EMI at the time (use original if adjusted is not available)
                $emiForCalc = $adjustedEMI > 0 ? $adjustedEMI : (float) $booking->installment_payment;
                $partialAccumulated = $emiForCalc > 0 ? fmod($allPartials, $emiForCalc) : 0;
                if ($partialAccumulated < 0.01) $partialAccumulated = 0;
                $remainingToComplete = max(0, $emiForCalc - $partialAccumulated);
                $instalmentNumber = $financialSummary['paid_installments'] + 1;

                $invoiceExtra['is_partial'] = true;
                $invoiceExtra['partial_accumulated'] = round($partialAccumulated, 2);
                $invoiceExtra['remaining_to_complete'] = round($remainingToComplete, 2);
                $invoiceExtra['instalment_number'] = $instalmentNumber;
                $invoiceExtra['emi_amount'] = $emiForCalc;
            } else {
                // Full instalment payment
                $invoiceExtra['is_partial'] = false;
                $invoiceExtra['instalment_qty'] = $qty;

                // Account for prior partial payments that contributed toward the first instalment covered
                $priorPartials = $booking->payments
                    ->where('payment_type', 'Part Of Installment')
                    ->where('created_at', '<', $payment->created_at)
                    ->sum('amount');
                $partialAccumBefore = $adjustedEMI > 0 ? fmod((float) $priorPartials, $adjustedEMI) : 0;
                if ($partialAccumBefore < 0.01) $partialAccumBefore = 0;

                // Expected = remaining for current instalment + (qty-1) full EMIs
                $remainingForFirst = max(0, $adjustedEMI - $partialAccumBefore);
                $expectedAmount = $remainingForFirst + max(0, $qty - 1) * $adjustedEMI;
                $overpayment = $amount - $expectedAmount;

                $invoiceExtra['expected_amount'] = round($expectedAmount, 2);
                $invoiceExtra['emi_amount'] = $adjustedEMI;
                $invoiceExtra['partial_accumulated_before'] = round($partialAccumBefore, 2);

                // If overpaid, this reduces future EMI
                if ($overpayment > 0.01 && $financialSummary['remaining_installments'] > 0) {
                    // Use consistent EMI calculation (excluding partial payment effects)
                    $outstandingForNewEMI = $financialSummary['outstanding_balance'] + $financialSummary['partial_payments_total'];
                    $newEMI = $outstandingForNewEMI / $financialSummary['remaining_installments'];
                    $invoiceExtra['overpayment'] = round($overpayment, 2);
                    $invoiceExtra['new_emi'] = round($newEMI, 2);
                }
            }
        }

        return view('Accounts.Admin.payments.invoice', compact('payment', 'financialSummary', 'invoiceExtra'));
    }

    /**
     * Update the payment date/time (created_at).
     */
    public function updateDate(Request $request, Payment $payment)
    {
        $validated = $request->validate([
            'payment_date' => 'required|date_format:Y-m-d',
            'payment_time' => 'required|date_format:H:i',
        ]);

        $payment->created_at = $validated['payment_date'] . ' ' . $validated['payment_time'] . ':00';
        $payment->save();

        // Keep ledger rows aligned with the payment date for reports
        $payment->commissionEarnings()->update(['created_at' => $payment->created_at]);

        return redirect()->route('admin.payments.show', $payment)->with('success', 'Payment date updated successfully.');
    }

    /**
     * Remove the specified payment.
     */
    public function destroy(Payment $payment)
    {
        DB::transaction(function () use ($payment) {
            (new CommissionService())->reverseEarningsForPayment($payment);
            $payment->delete();
        });

        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted successfully.');
    }
}
