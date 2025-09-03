<?php

namespace Modules\Admin\Controllers;

use App\Http\Controllers\Controller;
use Modules\Booking\Models\Booking;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['user', 'tourPackage']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Search functionality
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('customer_name', 'like', "%{$search}%")
                  ->orWhere('customer_email', 'like', "%{$search}%")
                  ->orWhere('destination', 'like', "%{$search}%")
                  ->orWhere('notes', 'like', "%{$search}%");
            });
        }

        $bookings = $query->latest()->paginate(20);

        return view('admin::bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['user', 'tourPackage']);
        return view('admin::bookings.show', compact('booking'));
    }

    public function updateStatus(Request $request, Booking $booking)
    {
        $request->validate([
            'status' => 'required|in:pending,confirmed,cancelled,completed',
            'notes' => 'nullable|string|max:500',
        ]);

        $booking->update([
            'status' => $request->status,
            'notes' => $booking->notes . ' | Admin updated status to ' . $request->status . ' on ' . now()->format('Y-m-d H:i:s') . ($request->notes ? ' - ' . $request->notes : ''),
        ]);

        return back()->with('success', 'Booking status updated successfully!');
    }

    public function destroy(Booking $booking)
    {
        $ticketNumber = null;
        if (preg_match('/Ticket Number: ([A-Z0-9]+)/', $booking->notes, $matches)) {
            $ticketNumber = $matches[1];
        }

        $booking->delete();

        return back()->with('success', 'Booking ' . ($ticketNumber ? '(' . $ticketNumber . ') ' : '') . 'deleted successfully!');
    }
}
