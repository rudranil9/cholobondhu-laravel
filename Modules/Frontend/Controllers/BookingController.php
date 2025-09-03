<?php

namespace Modules\Frontend\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Modules\Booking\Controllers\BookingController as BaseBookingController;
use Modules\Booking\Requests\StoreBookingRequest;

class BookingController extends Controller
{
    protected $bookingController;

    public function __construct()
    {
        $this->bookingController = app(BaseBookingController::class);
    }

    /**
     * Display the booking form
     */
    public function create($tourPackageId = null)
    {
        return $this->bookingController->create($tourPackageId);
    }

    /**
     * Store a new booking
     */
    public function store(StoreBookingRequest $request)
    {
        return $this->bookingController->store($request);
    }

    /**
     * Display user's bookings
     */
    public function index()
    {
        return $this->bookingController->index();
    }
}
