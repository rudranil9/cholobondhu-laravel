<?php

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::withCount('bookings');

        // Filter by role
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $isActive = $request->status === 'active';
            $query->where('is_active', $isActive);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        $users = $query->latest()->paginate(20);

        // Calculate statistics
        $stats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admins' => User::where('role', 'admin')->count(),
            'users' => User::where('role', 'user')->count(),
            'total_bookings' => \DB::table('bookings')->count(),
        ];

        return view('admin::users.index', compact('users', 'stats'));
    }

    public function show(User $user)
    {
        $user->load(['bookings' => function($query) {
            $query->latest();
        }]);

        return view('admin::users.show', compact('user'));
    }

    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
        ]);

        // Prevent changing own role
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role!');
        }

        $user->update(['role' => $request->role]);

        return back()->with('success', 'User role updated successfully!');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:user,admin',
            'is_active' => 'boolean',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'is_active' => $request->boolean('is_active', true),
        ]);

        return back()->with('success', 'User created successfully!');
    }

    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
        ]);

        // Prevent deactivating own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own status!');
        }

        $user->update(['is_active' => $request->boolean('is_active')]);

        $status = $request->boolean('is_active') ? 'activated' : 'deactivated';
        return back()->with('success', "User {$status} successfully!");
    }

    public function destroy(User $user)
    {
        // Prevent deleting own account
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account!');
        }

        // Store user name for success message
        $userName = $user->name;

        // Delete the user (this will also cascade delete related bookings if set up)
        $user->delete();

        return back()->with('success', "User '{$userName}' deleted successfully!");
    }
}
