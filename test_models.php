<?php
require 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "Testing models consistency...\n";

try {
    // Test App\Models\Booking
    echo "\nApp\\Models\\Booking:\n";
    $appBookings = \App\Models\Booking::count();
    echo "  Total bookings: $appBookings\n";
    $appPending = \App\Models\Booking::where('status', 'pending')->count();
    echo "  Pending: $appPending\n";
    
    // Test Modules\Booking\Models\Booking
    echo "\nModules\\Booking\\Models\\Booking:\n";
    try {
        $moduleBookings = \Modules\Booking\Models\Booking::count();
        echo "  Total bookings: $moduleBookings\n";
        $modulePending = \Modules\Booking\Models\Booking::where('status', 'pending')->count();
        echo "  Pending: $modulePending\n";
    } catch (Exception $e) {
        echo "  Error: " . $e->getMessage() . "\n";
    }
    
    // Test User model
    echo "\nApp\\Models\\User:\n";
    $users = \App\Models\User::count();
    echo "  Total users: $users\n";
    $adminUsers = \App\Models\User::where('role', 'admin')->count();
    echo "  Admin users: $adminUsers\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
