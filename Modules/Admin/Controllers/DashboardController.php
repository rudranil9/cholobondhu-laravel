<?php

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Modules\Booking\Models\Booking;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Get dashboard statistics
        $stats = [
            'total_bookings' => Booking::count(),
            'pending_bookings' => Booking::where('status', 'pending')->count(),
            'confirmed_bookings' => Booking::where('status', 'confirmed')->count(),
            'total_users' => User::where('role', 'user')->count(),
            'total_revenue' => Booking::where('status', 'confirmed')->sum('total_amount'),
            'recent_bookings' => Booking::with(['user', 'tourPackage'])
                ->latest()
                ->take(10)
                ->get(),
        ];

        return view('admin::dashboard', compact('stats'));
    }
}
