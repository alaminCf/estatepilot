<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Plot;
use App\Models\User;
use App\Services\SmsService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected SmsService $smsService;

    public function __construct(SmsService $smsService)
    {
        $this->smsService = $smsService;
    }

    /**
     * Display a listing of bookings.
     */
    public function index(Request $request)
    {
        $query = Booking::with(['plot', 'user', 'agent'])->withCount('payments')->latest();

        // Booking ID filter
        if ($request->filled('booking_id')) {
            $query->where('id', (int) preg_replace('/\D/', '', $request->booking_id));
        }

        // Client ID filter (accepts "CID-00003" or plain "3")
        if ($request->filled('client_id')) {
            $clientId = (int) preg_replace('/\D/', '', $request->client_id);
            $query->whereHas('user', fn($q) => $q->where('client_id', $clientId));
        }

        // Plot No filter
        if ($request->filled('plot_no')) {
            $plotNo = $request->plot_no;
            $query->whereHas('plot', fn($q) => $q->where('plot_no', 'like', '%' . $plotNo . '%'));
        }

        // Search filter
        if ($request->search) {
            $search = $request->search;
            // Extract client_id from formats like "CID-00003"
            $searchClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $search, $m)) {
                $searchClientId = (int) $m[1];
            }
            $query->where(function($q) use ($search, $searchClientId) {
                $q->whereHas('user', function($uq) use ($search, $searchClientId) {
                    $uq->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                    if ($searchClientId !== null) {
                        $uq->orWhere('client_id', $searchClientId);
                    }
                })->orWhereHas('plot', function($pq) use ($search) {
                    $pq->where('plot_no', 'like', '%' . $search . '%')
                      ->orWhere('title', 'like', '%' . $search . '%');
                });
            });
        }
        
        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        // Date range filter
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        $perPage = $request->per_page ?? 25;
        $bookings = $query->paginate($perPage)->appends($request->except('page'));
        
        return view('Accounts.Admin.bookings.index', compact('bookings'));
    }

    /**
     * Export bookings to CSV.
     */
    public function export(Request $request)
    {
        $query = Booking::with(['plot', 'user', 'agent', 'payments'])->latest();

        // Apply same filters as index method
        if ($request->filled('booking_id')) {
            $query->where('id', (int) preg_replace('/\D/', '', $request->booking_id));
        }

        if ($request->filled('client_id')) {
            $clientId = (int) preg_replace('/\D/', '', $request->client_id);
            $query->whereHas('user', fn($q) => $q->where('client_id', $clientId));
        }

        if ($request->filled('plot_no')) {
            $plotNo = $request->plot_no;
            $query->whereHas('plot', fn($q) => $q->where('plot_no', 'like', '%' . $plotNo . '%'));
        }

        if ($request->search) {
            $search = $request->search;
            $searchClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $search, $m)) {
                $searchClientId = (int) $m[1];
            }
            $query->where(function($q) use ($search, $searchClientId) {
                $q->whereHas('user', function($uq) use ($search, $searchClientId) {
                    $uq->where('name', 'like', '%' . $search . '%')
                      ->orWhere('phone', 'like', '%' . $search . '%')
                      ->orWhere('email', 'like', '%' . $search . '%');
                    if ($searchClientId !== null) {
                        $uq->orWhere('client_id', $searchClientId);
                    }
                })->orWhereHas('plot', function($pq) use ($search) {
                    $pq->where('plot_no', 'like', '%' . $search . '%')
                      ->orWhere('title', 'like', '%' . $search . '%');
                });
            });
        }
        
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        
        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }
        
        // Get all results without pagination
        $bookings = $query->get();
        
        // Create CSV filename with timestamp
        $filename = 'bookings_' . now()->format('Y-m-d_His') . '.csv';
        
        // Set headers for CSV download
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];
        
        // Create CSV content
        $callback = function() use ($bookings) {
            $file = fopen('php://output', 'w');
            
            // Add CSV headers
            fputcsv($file, [
                'Booking ID',
                'Plot No',
                'Plot Title',
                'Customer Name',
                'Customer Email',
                'Customer Phone',
                'Seller Name',
                'Seller Code',
                'Booking Date',
                'Total Price',
                'Total Paid',
                'Total Due',
                'Status',
                'Additional Info'
            ]);
            
            // Add data rows
            foreach ($bookings as $booking) {
                $totalPaid = $booking->payments->sum('amount');
                $totalDue = $booking->price - $totalPaid;
                
                fputcsv($file, [
                    $booking->id,
                    $booking->plot->plot_no,
                    $booking->plot->title,
                    $booking->user->name,
                    $booking->user->email,
                    $booking->user->phone ?? 'N/A',
                    $booking->agent ? $booking->agent->name : 'N/A',
                    $booking->agent && $booking->agent->referral_code ? $booking->agent->referral_code : 'N/A',
                    $booking->created_at->format('Y-m-d H:i:s'),
                    number_format($booking->price, 2, '.', ''),
                    number_format($totalPaid, 2, '.', ''),
                    number_format($totalDue, 2, '.', ''),
                    ucfirst($booking->status),
                    $booking->additional_info ?? 'N/A'
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }

    /**
     * Show the form for creating a new booking.
     */
    public function create()
    {
        $plots = Plot::where('status', 'available')->get();
        $users = User::where('role', 'user')->where('status', 'active')->get();
        $agents = $this->activeSellers();

        return view('Accounts.Admin.bookings.create', compact('plots', 'users', 'agents'));
    }

    /**
     * Commission users eligible to be assigned as a booking's seller.
     */
    private function activeSellers()
    {
        return User::commissionUsers()
            ->whereNotNull('commission_type')
            ->where('status', 'active')
            ->orderBy('name')
            ->get();
    }

    /**
     * Display the specified booking.
     */
    public function show(Booking $booking)
    {
        $booking->load(['plot', 'user', 'agent', 'payments', 'commissionEarnings.beneficiary']);
        $agents = $this->activeSellers();
        return view('Accounts.Admin.bookings.show', compact('booking', 'agents'));
    }

    /**
     * Quick update for status and additional info only.
     */
    public function updateQuick(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,approved,cancelled,pre-booked',
            'additional_info' => 'nullable|string',
        ]);

        $oldStatus = $booking->status;
        $booking->update($validated);

        // Update plot status based on booking status change
        if ($validated['status'] !== $oldStatus) {
            $plot = $booking->plot;
            
            if ($validated['status'] === 'approved') {
                $plot->update(['status' => 'booked']);
                
                // Clear pre-booking expiry if upgrading from pre-booked
                if ($oldStatus === 'pre-booked') {
                    $booking->update(['pre_booking_expires_at' => null, 'custom_booking_amount' => null]);
                }
                
                // Send SMS notification to user
                if ($booking->user && $booking->user->phone) {
                    $this->smsService->sendBookingApproval(
                        $booking->user->phone,
                        $booking->id,
                        $plot->plot_no
                    );
                }
            } elseif ($validated['status'] === 'cancelled') {
                $plot->update(['status' => 'available']);
            }
        }

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking updated successfully.');
    }

    /**
     * Update only the booking date/time.
     */
    public function updateBookingDate(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'booking_date' => 'required|date_format:Y-m-d',
            'booking_time' => 'required|date_format:H:i',
        ]);

        $booking->update([
            'booking_date' => $validated['booking_date'] . ' ' . $validated['booking_time'] . ':00',
        ]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Booking date updated successfully.');
    }

    /**
     * Store a newly created booking.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'plot_id' => 'required|exists:plots,id',
            'user_id' => 'required|exists:users,id',
            'referral_agent_id' => 'nullable|exists:users,id',
            'agent_commission' => 'nullable|numeric|min:0|max:100',
            'additional_info' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'booking_payment' => 'required|numeric|min:0',
            'custom_booking_amount' => 'nullable|numeric|min:0',
            'installment_plan' => 'nullable|in:monthly,quarterly',
            'total_installments' => 'nullable|integer|min:1',
            'installment_payment' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,cancelled,pre-booked',
            'booking_date' => 'nullable|date',
            'booking_time' => 'nullable|date_format:H:i',
            'owners' => 'nullable|array',
            'owners.*.name' => 'required_with:owners|string|max:255',
            'owners.*.phone' => 'required_with:owners|string|max:20',
            'owners.*.address' => 'required_with:owners|string|max:500',
            'owners.*.nid' => 'required_with:owners|string|max:50',
            'owners.*.father_name' => 'nullable|string|max:255',
            'owners.*.mother_name' => 'nullable|string|max:255',
            'owners.*.spouse_name' => 'nullable|string|max:255',
            'owners.*.nominee_info' => 'nullable|string|max:2000',
        ]);

        // Combine booking_date and booking_time into booking_date datetime
        if (!empty($validated['booking_date'])) {
            $time = $validated['booking_time'] ?? '00:00';
            $validated['booking_date'] = $validated['booking_date'] . ' ' . $time . ':00';
        }
        unset($validated['booking_time']);

        // Auto-calculate remaining payment
        $validated['remaining_payment'] = $validated['price'] - $validated['booking_payment'];

        // Set pre-booking expiry if status is pre-booked
        if ($validated['status'] === 'pre-booked') {
            $validated['pre_booking_expires_at'] = now()->addDays(15);
        }

        // New bookings distribute commission per the hierarchy chart at payment time;
        // the legacy per-booking flat rate is not used.
        $validated['commission_scheme'] = 'hierarchy';
        $validated['agent_commission'] = null;

        $booking = Booking::create($validated);

        // Update plot status to booked if booking is approved
        if ($validated['status'] === 'approved') {
            Plot::find($validated['plot_id'])->update(['status' => 'booked']);
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking created successfully.');
    }

    /**
     * Show the form for editing the specified booking.
     */
    public function edit(Booking $booking)
    {
        $plots = Plot::all();
        $users = User::where('role', 'user')->get();
        $agents = $this->activeSellers();

        return view('Accounts.Admin.bookings.show', compact('booking', 'plots', 'users', 'agents'));
    }

    /**
     * Update the specified booking.
     */
    public function update(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'plot_id' => 'required|exists:plots,id',
            'user_id' => 'required|exists:users,id',
            'referral_agent_id' => 'nullable|exists:users,id',
            'agent_commission' => 'nullable|numeric|min:0|max:100',
            'additional_info' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'booking_payment' => 'required|numeric|min:0',
            'custom_booking_amount' => 'nullable|numeric|min:0',
            'installment_plan' => 'nullable|in:monthly,quarterly',
            'total_installments' => 'nullable|integer|min:1',
            'installment_payment' => 'nullable|numeric|min:0',
            'status' => 'required|in:pending,approved,cancelled,pre-booked',
            'booking_date' => 'nullable|date',
            'booking_time' => 'nullable|date_format:H:i',
        ]);

        // Combine booking_date and booking_time into booking_date datetime
        if (!empty($validated['booking_date'])) {
            $time = $validated['booking_time'] ?? '00:00';
            $validated['booking_date'] = $validated['booking_date'] . ' ' . $time . ':00';
        }
        unset($validated['booking_time']);

        // Auto-calculate remaining payment
        $validated['remaining_payment'] = $validated['price'] - $validated['booking_payment'];

        if ($booking->isHierarchyScheme()) {
            // Hierarchy bookings never store a flat rate; the ledger handles distribution.
            $validated['agent_commission'] = null;
        } else {
            // Legacy flat bookings: keep agent_commission aligned with the assigned agent.
            // If no rate is provided but an agent is set, snapshot the agent's profile rate;
            // if no agent is set, null out the rate.
            if (!empty($validated['referral_agent_id']) && empty($validated['agent_commission'])) {
                $referralAgent = User::find($validated['referral_agent_id']);
                $validated['agent_commission'] = $referralAgent ? ($referralAgent->commission_rate ?? 0) : 0;
            }
            if (empty($validated['referral_agent_id'])) {
                $validated['agent_commission'] = null;
            }
        }

        $oldStatus = $booking->status;
        $booking->update($validated);

        // Update plot status based on booking status change
        if ($validated['status'] !== $oldStatus) {
            $plot = Plot::find($validated['plot_id']);
            
            if ($validated['status'] === 'approved') {
                $plot->update(['status' => 'booked']);
            } elseif ($validated['status'] === 'cancelled') {
                $plot->update(['status' => 'available']);
            }
        }

        return redirect()->route('admin.bookings.index')->with('success', 'Booking updated successfully.');
    }

    /**
     * Remove the specified booking.
     */
    public function destroy(Booking $booking)
    {
        // Check if booking has any payments - must remove payments first
        if ($booking->payments()->exists()) {
            return redirect()->route('admin.bookings.show', $booking)->with('error', 'This booking has payments recorded. Please remove all payments first before deleting the booking.');
        }

        // If booking was approved, set plot back to available
        if ($booking->status === 'approved') {
            $booking->plot->update(['status' => 'available']);
        }
        
        $booking->delete();

        return redirect()->route('admin.bookings.index')->with('success', 'Booking deleted successfully.');
    }

    /**
     * Change the agent for a booking.
     * New agent's commission starts from this point forward.
     */
    public function changeAgent(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'referral_agent_id' => 'nullable|exists:users,id',
            'agent_commission' => 'nullable|numeric|min:0|max:100',
        ]);

        $newAgentId = $validated['referral_agent_id'] ?: null;
        $oldAgentId = $booking->referral_agent_id;
        $newCommission = $validated['agent_commission'] ?? null;

        // Hierarchy bookings: just swap the seller. Earnings are snapshotted per
        // payment, so past distributions stay with the old chain and future
        // payments pay the new seller's chain — no baseline bookkeeping needed.
        if ($booking->isHierarchyScheme()) {
            if ($newAgentId == $oldAgentId) {
                return redirect()->route('admin.bookings.show', $booking)->with('error', 'No changes were made.');
            }

            $booking->update([
                'referral_agent_id' => $newAgentId,
                'agent_changed_at' => now(),
            ]);

            $newAgent = $newAgentId ? User::find($newAgentId) : null;
            $agentName = $newAgent ? $newAgent->name : 'None';

            return redirect()->route('admin.bookings.show', $booking)->with('success', "Seller changed to {$agentName} successfully. Future payments will pay the new seller's chain.");
        }

        // Legacy flat bookings keep the original baseline behaviour below.
        // Same agent - only update commission if it changed
        if ($newAgentId == $oldAgentId) {
            if ($newAgentId && $newCommission != $booking->agent_commission) {
                $booking->update(['agent_commission' => $newCommission]);
                return redirect()->route('admin.bookings.show', $booking)->with('success', 'Agent commission updated successfully.');
            }
            return redirect()->route('admin.bookings.show', $booking)->with('error', 'No changes were made.');
        }

        // Calculate total customer paid so far
        $totalCustomerPaid = $booking->payments()->sum('amount');

        // Update booking with new agent and record the baseline
        $booking->update([
            'referral_agent_id' => $newAgentId,
            'agent_changed_at' => now(),
            'agent_commission_base_paid' => $totalCustomerPaid,
            'agent_commission' => $newAgentId ? $newCommission : null,
        ]);

        $newAgent = $newAgentId ? User::find($newAgentId) : null;
        $agentName = $newAgent ? $newAgent->name : 'None';

        return redirect()->route('admin.bookings.show', $booking)->with('success', "Agent changed to {$agentName} successfully. Commission for the new agent will be calculated from this point forward.");
    }

    /**
     * Change the booking's primary ID. Cascades the new ID to every table
     * that references bookings.id (payments, commission_payouts, commission_earnings).
     */
    public function updateBookingId(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'new_id' => 'required|integer|min:1',
        ]);

        $newId = (int) $validated['new_id'];
        $oldId = (int) $booking->id;

        if ($newId === $oldId) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'The new Booking ID is the same as the current one.');
        }

        if (Booking::where('id', $newId)->exists()) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', "Booking ID #{$newId} is already in use. Please choose a different ID.");
        }

        try {
            DB::transaction(function () use ($oldId, $newId) {
                DB::statement('SET FOREIGN_KEY_CHECKS=0');
                DB::table('bookings')->where('id', $oldId)->update(['id' => $newId]);
                DB::table('payments')->where('booking_id', $oldId)->update(['booking_id' => $newId]);
                DB::table('commission_payouts')->where('booking_id', $oldId)->update(['booking_id' => $newId]);
                DB::table('commission_earnings')->where('booking_id', $oldId)->update(['booking_id' => $newId]);
                DB::statement('SET FOREIGN_KEY_CHECKS=1');
            });
        } catch (\Throwable $e) {
            return redirect()->route('admin.bookings.show', $booking)
                ->with('error', 'Failed to change Booking ID: ' . $e->getMessage());
        }

        return redirect()->route('admin.bookings.show', $newId)
            ->with('success', "Booking ID changed from #{$oldId} to #{$newId} successfully.");
    }

    /**
     * Update the additional owners for a booking.
     */
    public function updateOwners(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'owners' => 'nullable|array',
            'owners.*.name' => 'required_with:owners|string|max:255',
            'owners.*.phone' => 'required_with:owners|string|max:20',
            'owners.*.nid' => 'required_with:owners|string|max:50',
            'owners.*.address' => 'required_with:owners|string|max:500',
            'owners.*.father_name' => 'nullable|string|max:255',
            'owners.*.mother_name' => 'nullable|string|max:255',
            'owners.*.spouse_name' => 'nullable|string|max:255',
            'owners.*.nominee_info' => 'nullable|string|max:2000',
        ]);

        // Re-index array to remove gaps from removed owners
        $owners = isset($validated['owners']) ? array_values($validated['owners']) : [];

        $booking->update(['owners' => $owners ?: null]);

        return redirect()->route('admin.bookings.show', $booking)->with('success', 'Additional owners updated successfully.');
    }
}
