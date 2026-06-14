<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PlatformUserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'admin')->where('id', '!=', 1);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $perPage = $request->get('per_page', 25);
        $users = $query->latest()->paginate($perPage)->appends($request->query());

        return view('Accounts.Admin.platform-users.index', compact('users'));
    }

    public function create()
    {
        $permissions = User::PERMISSIONS;
        $actions = User::PERMISSION_ACTIONS;
        return view('Accounts.Admin.platform-users.edit', compact('permissions', 'actions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', User::allPermissions()),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => 'admin',
            'status' => $request->status,
            'permissions' => $request->permissions ?? [],
        ];

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin'), $filename);
            $data['photo'] = 'uploads/admin/' . $filename;
        }

        User::create($data);

        return redirect()->route('admin.platform-users.index')->with('success', 'Platform user created successfully.');
    }

    public function edit(User $platform_user)
    {
        $user = $platform_user;
        $permissions = User::PERMISSIONS;
        $actions = User::PERMISSION_ACTIONS;
        return view('Accounts.Admin.platform-users.edit', compact('user', 'permissions', 'actions'));
    }

    public function update(Request $request, User $platform_user)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $platform_user->id,
            'phone' => 'nullable|string|max:20',
            'password' => 'nullable|string|min:6|confirmed',
            'status' => 'required|in:active,inactive',
            'permissions' => 'nullable|array',
            'permissions.*' => 'in:' . implode(',', User::allPermissions()),
            'photo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'permissions' => $request->permissions ?? [],
        ];

        if ($request->filled('password')) {
            $data['password'] = bcrypt($request->password);
        }

        if ($request->hasFile('photo')) {
            // Delete old photo
            if ($platform_user->photo && file_exists(public_path($platform_user->photo))) {
                unlink(public_path($platform_user->photo));
            }
            $file = $request->file('photo');
            $filename = time() . '_' . $file->getClientOriginalName();
            $file->move(public_path('uploads/admin'), $filename);
            $data['photo'] = 'uploads/admin/' . $filename;
        }

        $platform_user->update($data);

        return redirect()->route('admin.platform-users.index')->with('success', 'Platform user updated successfully.');
    }

    public function destroy(User $platform_user)
    {
        if ($platform_user->id === 1) {
            return redirect()->route('admin.platform-users.index')->with('error', 'Cannot delete the super admin.');
        }

        if ($platform_user->photo && file_exists(public_path($platform_user->photo))) {
            unlink(public_path($platform_user->photo));
        }

        $platform_user->delete();

        return redirect()->route('admin.platform-users.index')->with('success', 'Platform user deleted successfully.');
    }
}
