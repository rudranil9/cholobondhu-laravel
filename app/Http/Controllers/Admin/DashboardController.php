<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Get statistics for dashboard
        $bookingStats = [
            'total' => Booking::count(),
            'pending' => Booking::where('status', 'pending')->count(),
            'in_process' => Booking::where('status', 'in_process')->count(),
            'confirmed' => Booking::where('status', 'confirmed')->count(),
            'cancelled' => Booking::where('status', 'cancelled')->count(),
            'rejected' => Booking::where('status', 'rejected')->count(),
            'recent' => Booking::where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        $userStats = [
            'total' => User::count(),
            'active' => User::where('is_active', true)->count(),
            'inactive' => User::where('is_active', false)->count(),
            'admins' => User::where('role', 'admin')->count(),
            'recent' => User::where('created_at', '>=', now()->subDays(7))->count(),
        ];
        
        $recentBookings = Booking::latest()->take(5)->get();
        $recentUsers = User::latest()->take(5)->get();
        
        return view('admin.dashboard', compact('bookingStats', 'userStats', 'recentBookings', 'recentUsers'));
    }
}
