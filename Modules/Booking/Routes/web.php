<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Booking Module Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    // Booking creation routes  
    Route::get('/booking', 'BookingController@showBookingForm')->name('booking.create');
    Route::get('/booking/{tour_package}', 'BookingController@create')->name('booking.create.package');
    Route::post('/booking', 'BookingController@store')->name('booking.store');
    
    // User booking management
    Route::get('/my-bookings', 'BookingController@index')->name('bookings.user');
    Route::get('/booking/{booking}', 'BookingController@show')->name('booking.show');
    Route::patch('/booking/{booking}/cancel', 'BookingController@cancel')->name('booking.cancel');
});
