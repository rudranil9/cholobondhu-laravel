<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Admin Module Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', 'DashboardController@index')->name('admin.dashboard');
    
    // User Management
    Route::get('/users', 'UserController@index')->name('admin.users.index');
    Route::get('/users/{user}', 'UserController@show')->name('admin.users.show');
    Route::post('/users', 'UserController@store')->name('admin.users.store');
    Route::patch('/users/{user}/role', 'UserController@updateRole')->name('admin.users.updateRole');
    Route::patch('/users/{user}/status', 'UserController@updateStatus')->name('admin.users.updateStatus');
    Route::delete('/users/{user}', 'UserController@destroy')->name('admin.users.destroy');
    
    // Booking Management
    Route::get('/bookings', 'BookingController@index')->name('admin.bookings.index');
    Route::get('/bookings/{booking}', 'BookingController@show')->name('admin.bookings.show');
    Route::patch('/bookings/{booking}/status', 'BookingController@updateStatus')->name('admin.bookings.update-status');
    Route::delete('/bookings/{booking}', 'BookingController@destroy')->name('admin.bookings.destroy');
    
    // Tour Package Management
    Route::get('/tour-packages', 'TourPackageController@index')->name('admin.tour-packages.index');
});
