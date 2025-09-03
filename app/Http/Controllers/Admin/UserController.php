<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search functionality
        if ($search = $request->get('search')) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($role = $request->get('role')) {
            if ($role !== 'all') {
                $query->where('role', $role);
            }
        }

        // Filter by status
        if ($status = $request->get('status')) {
            if ($status !== 'all') {
                $isActive = $status === 'active';
                $query->where('is_active', $isActive);
            }
        }

        try {
            $users = $query->withCount('bookings')->latest()->paginate(15);
        } catch (\Exception $e) {
            \Log::error('Error loading users with booking count: ' . $e->getMessage());
            // Fallback: load users without booking count
            $users = $query->latest()->paginate(15);
            // Add bookings_count manually
            foreach ($users as $user) {
                $user->bookings_count = 0;
                try {
                    $user->bookings_count = $user->bookings()->count();
                } catch (\Exception $e) {
                    // Skip if relationship doesn't exist
                }
            }
        }

        // Get statistics with error handling
        $stats = [
            'total' => 0,
            'active' => 0,
            'inactive' => 0,
            'admins' => 0,
            'users' => 0,
            'total_bookings' => 0,
        ];
        
        try {
            $stats['total'] = User::count();
            $stats['active'] = User::where('is_active', true)->count();
            $stats['inactive'] = User::where('is_active', false)->count();
            $stats['admins'] = User::where('role', 'admin')->count();
            $stats['users'] = User::where('role', 'user')->count();
            
            try {
                $stats['total_bookings'] = \App\Models\Booking::count();
            } catch (\Exception $e) {
                \Log::error('Error counting bookings: ' . $e->getMessage());
                $stats['total_bookings'] = 0;
            }
        } catch (\Exception $e) {
            \Log::error('Error getting user statistics: ' . $e->getMessage());
        }

        return view('admin.users.index', compact('users', 'stats'));
    }

    /**
     * Show user details
     */
    public function show(User $user)
    {
        $user->load(['bookings' => function($query) {
            $query->latest()->take(10);
        }]);

        $userStats = [
            'total_bookings' => $user->bookings()->count(),
            'pending_bookings' => $user->bookings()->where('status', 'pending')->count(),
            'confirmed_bookings' => $user->bookings()->where('status', 'confirmed')->count(),
            'cancelled_bookings' => $user->bookings()->where('status', 'cancelled')->count(),
        ];

        return view('admin.users.show', compact('user', 'userStats'));
    }

    /**
     * Update user status (activate/deactivate)
     */
    public function updateStatus(Request $request, User $user)
    {
        $request->validate([
            'is_active' => 'required|boolean',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        $oldStatus = $user->is_active;
        $user->is_active = $request->is_active;
        $user->save();

        $statusText = $request->is_active ? 'activated' : 'deactivated';
        
        // Log the status change (you could create a user_logs table for this)
        \Log::info("User {$user->email} was {$statusText} by admin " . auth()->user()->email, [
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'admin_notes' => $request->admin_notes
        ]);

        // Send email notification to user (optional)
        if ($request->admin_notes) {
            $this->sendStatusChangeEmail($user, $oldStatus, $request->is_active, $request->admin_notes);
        }

        // Return JSON response for AJAX requests
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => "User {$user->name} has been {$statusText} successfully.",
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'is_active' => $user->is_active
                ]
            ]);
        }

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been {$statusText} successfully.");
    }

    /**
     * Update user role
     */
    public function updateRole(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|in:user,admin',
            'admin_notes' => 'nullable|string|max:500'
        ]);

        // Prevent self-demotion
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return redirect()->back()->with('error', 'You cannot change your own admin role.');
        }

        $oldRole = $user->role;
        $user->role = $request->role;
        $user->save();

        \Log::info("User {$user->email} role changed from {$oldRole} to {$request->role} by admin " . auth()->user()->email, [
            'user_id' => $user->id,
            'admin_id' => auth()->id(),
            'admin_notes' => $request->admin_notes
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} role has been updated to {$request->role}.");
    }

    /**
     * Create a new user
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|max:20',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => 'required|in:user,admin',
            'is_active' => 'required|boolean'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_active' => $request->is_active,
        ]);

        \Log::info("New user {$user->email} created by admin " . auth()->user()->email, [
            'user_id' => $user->id,
            'admin_id' => auth()->id()
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', "User {$user->name} has been created successfully.");
    }

    /**
     * Delete a user
     */
    public function destroy(Request $request, User $user)
    {
        // Prevent self-deletion
        if ($user->id === auth()->id()) {
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot delete your own account.'
                ], 400);
            }
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        // Check if user has active bookings (with error handling)
        $activeBookings = 0;
        $bookingsCheckFailed = false;
        
        try {
            // First check if bookings relationship exists
            if (method_exists($user, 'bookings')) {
                $activeBookings = $user->bookings()->whereIn('status', ['pending', 'confirmed', 'in_process'])->count();
            } else {
                // Fallback: Check if Booking model exists and has user_id
                if (class_exists('\App\Models\Booking')) {
                    $activeBookings = \App\Models\Booking::where('user_id', $user->id)
                        ->whereIn('status', ['pending', 'confirmed', 'in_process'])
                        ->count();
                }
            }
        } catch (\Exception $e) {
            \Log::error('Error checking user bookings for deletion: ' . $e->getMessage());
            $bookingsCheckFailed = true;
            // Continue with deletion since we can't verify bookings
        }
        
        if (!$bookingsCheckFailed && $activeBookings > 0) {
            $errorMessage = "Cannot delete user {$user->name}. They have {$activeBookings} active booking(s). Please cancel or complete their bookings first.";
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $errorMessage
                ], 400);
            }
            
            return redirect()->back()->with('error', $errorMessage);
        }

        $userName = $user->name;
        $userEmail = $user->email;
        $bookingsCount = 0;
        
        try {
            if (method_exists($user, 'bookings')) {
                $bookingsCount = $user->bookings()->count();
            } else if (class_exists('\App\Models\Booking')) {
                $bookingsCount = \App\Models\Booking::where('user_id', $user->id)->count();
            }
        } catch (\Exception $e) {
            \Log::error('Error counting user bookings: ' . $e->getMessage());
        }

        \Log::info("User {$userEmail} deleted by admin " . auth()->user()->email, [
            'deleted_user_id' => $user->id,
            'admin_id' => auth()->id(),
            'bookings_count' => $bookingsCount,
            'bookings_check_failed' => $bookingsCheckFailed
        ]);

        try {
            $user->delete();
            
            // Return JSON response for AJAX requests
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => "User {$userName} has been deleted successfully.",
                    'deleted_user_id' => $user->id
                ]);
            }

            return redirect()->route('admin.users.index')
                ->with('success', "User {$userName} has been deleted successfully.");
                
        } catch (\Exception $e) {
            \Log::error("Error deleting user {$userEmail}: " . $e->getMessage());
            
            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => "An error occurred while deleting the user. Please try again."
                ], 500);
            }
            
            return redirect()->back()->with('error', 'An error occurred while deleting the user. Please try again.');
        }
    }

    /**
     * Get user statistics for dashboard
     */
    public function getStats()
    {
        return [
            'total_users' => User::count(),
            'active_users' => User::where('is_active', true)->count(),
            'inactive_users' => User::where('is_active', false)->count(),
            'admin_users' => User::where('role', 'admin')->count(),
            'regular_users' => User::where('role', 'user')->count(),
            'users_with_bookings' => User::has('bookings')->count(),
            'recent_users' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];
    }

    /**
     * Send email notification for status change
     */
    private function sendStatusChangeEmail($user, $oldStatus, $newStatus, $adminNotes)
    {
        try {
            $subject = 'Account Status Update - Cholo Bondhu';
            $statusText = $newStatus ? 'activated' : 'deactivated';
            
            $emailContent = $this->buildStatusChangeEmailContent($user, $oldStatus, $newStatus, $adminNotes);
            
            $headers = [
                'MIME-Version: 1.0',
                'Content-type: text/html; charset=UTF-8',
                'From: Cholo Bondhu Admin <admin@cholobondhu.com>',
                'Reply-To: admin@cholobondhu.com',
            ];
            
            mail($user->email, $subject, $emailContent, implode("\r\n", $headers));
            
            \Log::info("Status change email sent to user {$user->email}");
        } catch (\Exception $e) {
            \Log::error("Failed to send status change email to {$user->email}: " . $e->getMessage());
        }
    }

    /**
     * Build status change email content
     */
    private function buildStatusChangeEmailContent($user, $oldStatus, $newStatus, $adminNotes)
    {
        $statusText = $newStatus ? 'activated' : 'deactivated';
        $statusColor = $newStatus ? '#22c55e' : '#ef4444';
        
        return "
        <html>
        <body style='font-family: Arial, sans-serif; line-height: 1.6; color: #333;'>
            <div style='max-width: 600px; margin: 0 auto; padding: 20px;'>
                <h2 style='color: {$statusColor}; text-align: center;'>Account Status Update</h2>
                
                <p>Dear {$user->name},</p>
                
                <p>Your account status has been updated by our administrators.</p>
                
                <div style='background: #f8fafc; padding: 20px; border-radius: 8px; margin: 20px 0; border-left: 4px solid {$statusColor};'>
                    <h3 style='margin-top: 0; color: {$statusColor};'>Status Change Details</h3>
                    <p><strong>Account Status:</strong> " . ucfirst($statusText) . "</p>
                    <p><strong>Date:</strong> " . now()->format('M d, Y H:i') . "</p>
                    " . ($adminNotes ? "<p><strong>Admin Notes:</strong> {$adminNotes}</p>" : "") . "
                </div>
                
                " . ($newStatus ? 
                    "<p>Your account is now active and you can use all features of Cholo Bondhu.</p>" : 
                    "<p>Your account has been temporarily deactivated. If you have any questions, please contact our support team.</p>"
                ) . "
                
                <hr style='margin: 30px 0; border: none; border-top: 1px solid #e5e7eb;'>
                <p style='font-size: 12px; color: #6b7280;'>
                    Best regards,<br>
                    Cholo Bondhu Admin Team<br>
                    Email: admin@cholobondhu.com
                </p>
            </div>
        </body>
        </html>";
    }
}
