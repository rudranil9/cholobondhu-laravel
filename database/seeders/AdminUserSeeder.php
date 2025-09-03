<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::updateOrCreate(
            ['email' => 'admin@cholobondhu.com'],
            [
                'name' => 'Admin User',
                'email' => 'admin@cholobondhu.com',
                'phone' => '+91 98765 43210',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'email_verified_at' => now(),
            ]
        );

        // Create a test regular user
        User::updateOrCreate(
            ['email' => 'user@cholobondhu.com'],
            [
                'name' => 'Test User',
                'email' => 'user@cholobondhu.com',
                'phone' => '+91 87654 32109',
                'password' => Hash::make('user123'),
                'role' => 'user',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('Admin user created: admin@cholobondhu.com / admin123');
        $this->command->info('Test user created: user@cholobondhu.com / user123');
    }
}
