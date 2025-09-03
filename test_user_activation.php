<?php

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/bootstrap/app.php';

use App\Models\User;
use Illuminate\Support\Facades\DB;

echo "=== Testing User Activation/Deactivation ===\n\n";

try {
    // Check if is_active column exists
    $columns = DB::select("DESCRIBE users");
    $hasIsActive = false;
    echo "Users table columns:\n";
    foreach ($columns as $column) {
        echo "- {$column->Field} ({$column->Type})\n";
        if ($column->Field === 'is_active') {
            $hasIsActive = true;
        }
    }
    
    if (!$hasIsActive) {
        echo "\n❌ ERROR: is_active column doesn't exist in users table!\n";
        echo "Running migration to add is_active column...\n";
        exec('php artisan migrate', $output, $returnCode);
        if ($returnCode === 0) {
            echo "✅ Migration completed successfully\n";
        } else {
            echo "❌ Migration failed\n";
        }
        exit;
    }
    
    echo "\n✅ is_active column exists\n\n";
    
    // Find a test user (not admin)
    $testUser = User::where('role', 'user')->first();
    
    if (!$testUser) {
        echo "Creating a test user...\n";
        $testUser = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user',
            'is_active' => true
        ]);
        echo "✅ Test user created: {$testUser->name} (ID: {$testUser->id})\n";
    }
    
    echo "Current test user status:\n";
    echo "- Name: {$testUser->name}\n";
    echo "- Email: {$testUser->email}\n";
    echo "- Role: {$testUser->role}\n";
    echo "- Active: " . ($testUser->is_active ? 'Yes' : 'No') . "\n\n";
    
    // Test deactivation
    echo "Testing deactivation...\n";
    $originalStatus = $testUser->is_active;
    $testUser->update(['is_active' => false]);
    $testUser->refresh();
    echo "✅ User deactivated. New status: " . ($testUser->is_active ? 'Active' : 'Inactive') . "\n\n";
    
    // Test activation
    echo "Testing activation...\n";
    $testUser->update(['is_active' => true]);
    $testUser->refresh();
    echo "✅ User activated. New status: " . ($testUser->is_active ? 'Active' : 'Inactive') . "\n\n";
    
    // Test the UserController method
    echo "Testing UserController updateStatus method...\n";
    $controller = new \Modules\Admin\Controllers\UserController();
    
    // Simulate request
    $request = new \Illuminate\Http\Request([
        'is_active' => '0'  // Deactivate
    ]);
    
    try {
        $response = $controller->updateStatus($request, $testUser);
        $testUser->refresh();
        echo "✅ UserController method works. User status: " . ($testUser->is_active ? 'Active' : 'Inactive') . "\n";
    } catch (Exception $e) {
        echo "❌ UserController method error: " . $e->getMessage() . "\n";
    }
    
    echo "\n=== Test Complete ===\n";
    
} catch (Exception $e) {
    echo "❌ ERROR: " . $e->getMessage() . "\n";
    echo "Stack trace:\n" . $e->getTraceAsString() . "\n";
}
