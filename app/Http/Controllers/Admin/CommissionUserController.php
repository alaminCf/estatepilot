<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommissionEarning;
use App\Models\CommissionPayout;
use App\Models\User;
use App\Services\CommissionService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CommissionUserController extends Controller
{
    /**
     * Display a listing of commission users.
     */
    public function index(Request $request)
    {
        $query = User::commissionUsers()->with('parent');

        // Search filter
        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('email', 'like', '%' . $request->search . '%')
                  ->orWhere('phone', 'like', '%' . $request->search . '%')
                  ->orWhere('referral_code', 'like', '%' . $request->search . '%');
            });
        }

        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Type filter (incl. converted agents not yet assigned a type)
        if ($request->commission_type === 'unassigned') {
            $query->whereNull('commission_type');
        } elseif ($request->commission_type) {
            $query->where('commission_type', $request->commission_type);
        }

        $perPage = $request->per_page ?? 25;
        $commissionUsers = $query->orderByRaw("FIELD(commission_type, 'ed', 'gm', 'agm', 'manager', 'ast_manager')")
            ->orderBy('name')
            ->paginate($perPage)
            ->appends($request->except('page'));

        return view('Accounts.Admin.commission-users.index', compact('commissionUsers'));
    }

    /**
     * Show the form for creating a new commission user.
     */
    public function create()
    {
        return view('Accounts.Admin.commission-users.edit', [
            'hierarchy' => $this->hierarchyData(),
        ]);
    }

    /**
     * Store a newly created commission user.
     */
    public function store(Request $request)
    {
        $validated = $this->validateCommissionUser($request);

        $validated['role'] = 'agent';
        $validated['password'] = bcrypt($validated['password']);

        // Auto-generate referral code if not provided
        if (empty($validated['referral_code'])) {
            $validated['referral_code'] = 'AG' . strtoupper(substr(md5(uniqid()), 0, 6));
        }

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/agent'), $filename);
            $validated['photo'] = 'uploads/agent/' . $filename;
        }

        User::create($validated);

        return redirect()->route('admin.commission-users.index')->with('success', 'Commission user created successfully.');
    }

    /**
     * Display the specified commission user.
     */
    public function show(User $commission_user)
    {
        $commissionUser = $commission_user;
        $service = new CommissionService();

        // Referred bookings (own sales)
        $bookings = $commissionUser->referredBookings()->with(['plot', 'user', 'payments'])->latest()->get();
        $customers = $bookings->pluck('user')->unique('id');

        // Hierarchy chain upward (excluding self)
        $chain = array_slice($service->uplineChain($commissionUser), 1);

        // Direct downline with their sale counts
        $downline = $commissionUser->children()->withCount('referredBookings')->get();

        // Earnings ledger (latest rows)
        $recentEarnings = CommissionEarning::where('user_id', $commissionUser->id)
            ->with(['booking.plot', 'seller'])
            ->latest('created_at')
            ->limit(20)
            ->get();

        // Payouts
        $payouts = CommissionPayout::where('user_id', $commissionUser->id)
            ->with(['booking.plot'])
            ->latest()
            ->get();

        $earningsSummary = $service->earningsSummaryFor($commissionUser);
        $legacyCommission = $service->legacyCommissionFor($commissionUser);
        $totalPaid = $service->payoutTotalFor($commissionUser);
        $balance = $service->balanceFor($commissionUser);

        return view('Accounts.Admin.commission-users.show', compact(
            'commissionUser',
            'bookings',
            'customers',
            'chain',
            'downline',
            'recentEarnings',
            'payouts',
            'earningsSummary',
            'legacyCommission',
            'totalPaid',
            'balance'
        ));
    }

    /**
     * Show the form for editing the specified commission user.
     */
    public function edit(User $commission_user)
    {
        return view('Accounts.Admin.commission-users.edit', [
            'commissionUser' => $commission_user,
            'hierarchy' => $this->hierarchyData($commission_user->id),
        ]);
    }

    /**
     * Update the specified commission user.
     */
    public function update(Request $request, User $commission_user)
    {
        $validated = $this->validateCommissionUser($request, $commission_user);

        if (! empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($commission_user->photo && file_exists(public_path($commission_user->photo))) {
                unlink(public_path($commission_user->photo));
            }

            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/agent'), $filename);
            $validated['photo'] = 'uploads/agent/' . $filename;
        }

        $commission_user->update($validated);

        return redirect()->route('admin.commission-users.index')->with('success', 'Commission user updated successfully.');
    }

    /**
     * Remove the specified commission user.
     */
    public function destroy(User $commission_user)
    {
        if ($commission_user->children()->exists()) {
            return back()->with('error', 'Cannot delete: this user has downline commission users. Reassign them first.');
        }

        if ($commission_user->referredBookings()->exists()) {
            return back()->with('error', 'Cannot delete: this user has bookings. Deactivate the user instead.');
        }

        if ($commission_user->commissionEarnings()->exists() || $commission_user->commissionPayouts()->exists()) {
            return back()->with('error', 'Cannot delete: this user has commission history. Deactivate the user instead.');
        }

        if ($commission_user->photo && file_exists(public_path($commission_user->photo))) {
            unlink(public_path($commission_user->photo));
        }
        $commission_user->delete();

        return redirect()->route('admin.commission-users.index')->with('success', 'Commission user deleted successfully.');
    }

    /**
     * Shared validation for store/update.
     */
    private function validateCommissionUser(Request $request, ?User $existing = null): array
    {
        $typeKeys = array_keys(config('commission.types'));

        return $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users', 'email')->ignore($existing?->id)],
            'phone' => 'required|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'password' => ($existing ? 'nullable' : 'required') . '|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'referral_code' => [
                $existing ? 'required' : 'nullable',
                'string',
                Rule::unique('users', 'referral_code')->ignore($existing?->id),
            ],
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'commission_type' => ['required', Rule::in($typeKeys)],
            'parent_id' => [
                'nullable',
                'required_unless:commission_type,ed',
                Rule::exists('users', 'id'),
                function ($attribute, $value, $fail) use ($request, $existing) {
                    if (! $value) {
                        return;
                    }

                    if ($existing && (int) $value === $existing->id) {
                        $fail('A commission user cannot be their own upline.');
                        return;
                    }

                    $requiredParentType = config('commission.types.' . $request->input('commission_type') . '.parent');
                    $parent = User::find($value);

                    if (! $parent || ! $parent->isCommissionUser() || $parent->commission_type !== $requiredParentType) {
                        $expected = config("commission.types.{$requiredParentType}.label", $requiredParentType);
                        $fail("The selected upline must be a {$expected}.");
                    }
                },
            ],
            'booking_pct' => 'required|numeric|min:0|max:100',
            'down_pct' => 'required|numeric|min:0|max:100',
            'instalment_pct' => 'required|numeric|min:0|max:100',
        ]);
    }

    /**
     * Hierarchy data preloaded into the form for cascading upline selects.
     */
    private function hierarchyData(?int $excludeId = null): array
    {
        return User::commissionUsers()
            ->whereNotNull('commission_type')
            ->when($excludeId, fn ($q) => $q->where('id', '!=', $excludeId))
            ->orderBy('name')
            ->get(['id', 'name', 'commission_type', 'parent_id', 'referral_code', 'booking_pct', 'down_pct', 'instalment_pct'])
            ->toArray();
    }
}
