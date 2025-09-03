<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TourPackageController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\Admin\BookingController as AdminBookingController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::get('/tour-packages', [TourPackageController::class, 'index'])->name('tour-packages');
Route::get('/travel-categories/{category}', [TourPackageController::class, 'byCategory'])->name('travel-categories');
Route::get('/explore-by-region', [TourPackageController::class, 'exploreByRegion'])->name('explore-by-region');
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Booking routes (public access for booking form)
Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

// Email test route (for admin testing)
Route::get('/test-email', [BookingController::class, 'testEmail'])->name('test.email');

// Debug form (remove in production)
Route::get('/debug-form', function () {
    return view('debug-form');
})->name('debug.form');

// User booking management routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/my-bookings', [BookingController::class, 'myBookings'])->name('booking.my-bookings');
    Route::get('/my-bookings/{booking}', [BookingController::class, 'show'])->name('booking.show');
    Route::patch('/my-bookings/{booking}/cancel', [BookingController::class, 'cancel'])->name('booking.cancel');
});

// Protected routes (require authentication)
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        // Redirect admin users to admin dashboard
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // User booking management routes are handled by the Booking module
});

// Admin routes (require admin authentication)
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    // Admin dashboard
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Admin booking management
    Route::get('/bookings', [AdminBookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/{booking}', [AdminBookingController::class, 'show'])->name('bookings.show');
    Route::patch('/bookings/{booking}/status', [AdminBookingController::class, 'updateStatus'])->name('bookings.updateStatus');
    Route::delete('/bookings/{booking}', [AdminBookingController::class, 'destroy'])->name('bookings.destroy');
    
    // Admin user management
    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('users.show');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::patch('/users/{user}/status', [AdminUserController::class, 'updateStatus'])->name('users.updateStatus');
    Route::patch('/users/{user}/role', [AdminUserController::class, 'updateRole'])->name('users.updateRole');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    
    // Admin contact inquiries management (using ContactController for now)
    Route::get('/contact-inquiries', [ContactController::class, 'adminIndex'])->name('contact-inquiries.index');
    Route::get('/contact-inquiries/{contactInquiry}', [ContactController::class, 'adminShow'])->name('contact-inquiries.show');
    Route::patch('/contact-inquiries/{contactInquiry}/status', [ContactController::class, 'updateStatus'])->name('contact-inquiries.updateStatus');
    Route::delete('/contact-inquiries/{contactInquiry}', [ContactController::class, 'destroy'])->name('contact-inquiries.destroy');
});

require __DIR__.'/auth.php';

// Debug routes - remove after fixing CSS issue
Route::get('/debug/assets', function () {
    $data = [
        'app_env' => app()->environment(),
        'app_debug' => config('app.debug'),
        'public_path' => public_path(),
        'build_path' => public_path('build'),
        'css_file_exists' => file_exists(public_path('build/assets/app-BCXFDP9b.css')),
        'js_file_exists' => file_exists(public_path('build/assets/app-DtCVKgHt.js')),
        'manifest_exists' => file_exists(public_path('build/manifest.json')),
        'build_contents' => is_dir(public_path('build')) ? scandir(public_path('build')) : 'Build directory not found',
        'assets_contents' => is_dir(public_path('build/assets')) ? scandir(public_path('build/assets')) : 'Assets directory not found',
    ];
    
    if (file_exists(public_path('build/manifest.json'))) {
        $data['manifest_content'] = json_decode(file_get_contents(public_path('build/manifest.json')), true);
    }
    
    return response()->json($data, 200, [], JSON_PRETTY_PRINT);
});

Route::get('/debug/css', function () {
    $cssPath = public_path('build/assets/app-BCXFDP9b.css');
    
    if (file_exists($cssPath)) {
        return response(file_get_contents($cssPath), 200, [
            'Content-Type' => 'text/css'
        ]);
    }
    
    return response('CSS file not found', 404);
});
