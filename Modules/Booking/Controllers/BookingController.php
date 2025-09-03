<?php

namespace Modules\Booking\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use Modules\Booking\Services\BookingService;
use Modules\Booking\Requests\StoreBookingRequest;
use App\Models\TourPackage;

class BookingController extends Controller
{
    protected $bookingService;

    public function __construct(BookingService $bookingService = null)
    {
        $this->bookingService = $bookingService ?: app(BookingService::class);
    }

    public function index()
    {
        $bookings = Booking::where('user_id', auth()->id())
            ->with('tourPackage')
            ->latest()
            ->paginate(10);

        return view('booking::index', compact('bookings'));
    }

    /**
     * Show the booking form with auto-fill data
     */
    public function showBookingForm(Request $request)
    {
        // Extract auto-fill data from URL parameters
        $autoFillData = [
            'package_name' => $request->get('package_name'),
            'destination' => $request->get('destination'),
            'price' => $request->get('price'),
            'duration' => $request->get('duration'),
            'package_type' => $request->get('package_type'),
        ];

        // Filter out null/empty values
        $autoFillData = array_filter($autoFillData, function($value) {
            return !is_null($value) && $value !== '';
        });

        return view('booking::create', compact('autoFillData'));
    }

    public function create($tourPackageId = null)
    {
        $tourPackage = null;
        if ($tourPackageId) {
            $tourPackage = TourPackage::findOrFail($tourPackageId);
        }
        return view('booking::create', compact('tourPackage'));
    }

    public function store(StoreBookingRequest $request)
    {
        $booking = $this->bookingService->createBooking($request->validated());
        $ticketNumber = $this->bookingService->getTicketNumber($booking);
        
        // Check if request expects JSON (AJAX)
        if ($request->expectsJson() || $request->header('X-Requested-With') === 'XMLHttpRequest') {
            return response()->json([
                'success' => true,
                'message' => 'Booking created successfully!',
                'ticket_number' => $ticketNumber,
                'booking_id' => $booking->id,
                'redirect_url' => route('bookings.user')
            ]);
        }
        
        return redirect()->route('bookings.user')
            ->with('success', 'Booking created successfully! Your ticket number is: ' . $ticketNumber)
            ->with('ticket_number', $ticketNumber);
    }

    public function show(Booking $booking)
    {
        // Ensure user can only view their own bookings
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        return view('booking::show', compact('booking'));
    }
    
    public function cancel(Request $request, Booking $booking)
    {
        // Ensure user can only cancel their own bookings
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }
        
        // Only allow cancellation of pending bookings
        if ($booking->status !== 'pending') {
            return back()->with('error', 'Only pending bookings can be cancelled.');
        }
        
        // Validate cancellation reason
        $request->validate([
            'cancellation_reason' => 'required|string',
            'other_reason' => 'required_if:cancellation_reason,other|string|max:500'
        ]);
        
        // Prepare cancellation reason text
        $reason = $request->cancellation_reason;
        if ($reason === 'other' && $request->other_reason) {
            $reason = 'Other: ' . $request->other_reason;
        } else {
            $reason = str_replace('_', ' ', ucfirst($reason));
        }

        $this->bookingService->cancelBooking($booking, $reason);

        return back()->with('success', 'Booking cancelled successfully! Cancellation emails have been sent.');
    }

}
