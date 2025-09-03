<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('user_devices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('device_name')->nullable();
            $table->string('device_fingerprint')->unique(); // Browser + OS fingerprint
            $table->string('ip_address');
            $table->string('user_agent');
            $table->string('session_token')->unique();
            $table->timestamp('last_activity');
            $table->boolean('is_active')->default(true);
            $table->timestamp('trusted_until')->nullable(); // For remember me functionality
            $table->timestamps();
            
            // Indexes for efficient queries
            $table->index(['user_id', 'is_active']);
            $table->index(['session_token', 'is_active']);
            $table->index(['device_fingerprint', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_devices');
    }
};
