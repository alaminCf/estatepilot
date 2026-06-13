<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'user');
        
        // Search filter
        if ($request->search) {
            $search = $request->search;
            // Extract numeric ID from formats like "CID-00011" or plain "11"
            $searchClientId = null;
            if (preg_match('/^CID-0*(\d+)$/i', $search, $m)) {
                $searchClientId = (int) $m[1];
            } elseif (is_numeric($search)) {
                $searchClientId = (int) $search;
            }
            $query->where(function($q) use ($search, $searchClientId) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('email', 'like', '%' . $search . '%')
                  ->orWhere('phone', 'like', '%' . $search . '%');
                if ($searchClientId !== null) {
                    $q->orWhere('client_id', $searchClientId);
                }
            });
        }
        
        // Status filter
        if ($request->status) {
            $query->where('status', $request->status);
        }
        
        $perPage = $request->per_page ?? 25;
        $users = $query->paginate($perPage)->appends($request->except('page'));
        
        return view('Accounts.Admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('Accounts.Admin.users.edit');
    }

    /**
     * Store a newly created user.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'password' => 'required|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'created_at' => 'nullable|date',
        ]);

        $validated['role'] = 'user';
        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $validated['photo'] = 'uploads/user/' . $filename;
        }

        User::create($validated);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(User $user)
    {
        // Load user's bookings with related data
        $bookings = $user->bookings()->with(['plot', 'payments'])->latest()->get();
        
        // Get all payments
        $payments = \App\Models\Payment::whereHas('booking', function($query) use ($user) {
            $query->where('user_id', $user->id);
        })->with(['booking.plot'])->latest()->get();
        
        // Calculate totals
        $totalPaid = $payments->sum('amount');
        $totalDue = $bookings->sum('price') - $totalPaid;
        
        return view('Accounts.Admin.users.show', compact('user', 'bookings', 'payments', 'totalPaid', 'totalDue'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('Accounts.Admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user.
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'father_name' => 'nullable|string|max:255',
            'mother_name' => 'nullable|string|max:255',
            'nid' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'password' => 'nullable|min:8|confirmed',
            'status' => 'required|in:active,inactive',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'created_at' => 'nullable|date',
        ]);

        if (!empty($validated['password'])) {
            $validated['password'] = bcrypt($validated['password']);
        } else {
            unset($validated['password']);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }
            
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/user'), $filename);
            $validated['photo'] = 'uploads/user/' . $filename;
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Change a user's Client ID.
     */
    public function changeId(Request $request, User $user)
    {
        $oldClientId = $user->client_id;

        $request->validate([
            'new_id' => [
                'required',
                'integer',
                'min:1',
                'max:999999',
                Rule::unique('users', 'client_id'),
            ],
        ]);

        $newClientId = (int) $request->new_id;

        if ($newClientId === $oldClientId) {
            return redirect()->route('admin.users.edit', $user)->with('error', 'The new Client ID is the same as the current one.');
        }

        $user->update(['client_id' => $newClientId]);

        return redirect()->route('admin.users.edit', $user->id)->with('success', 'Client ID changed from CID-' . str_pad($oldClientId, 5, '0', STR_PAD_LEFT) . ' to CID-' . str_pad($newClientId, 5, '0', STR_PAD_LEFT) . ' successfully.');
    }

    /**
     * Remove the specified user.
     */
    public function destroy(User $user)
    {
        if ($user->photo && file_exists(public_path($user->photo))) {
            unlink(public_path($user->photo));
        }
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
