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
        Schema::create('tour_packages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('location');
            $table->string('image_url');
            $table->decimal('price', 10, 2);
            $table->string('duration');
            $table->string('category'); // cultural, adventure, beach, spiritual, etc.
            $table->json('features')->nullable(); // array of features/inclusions
            $table->json('highlights')->nullable(); // array of tour highlights
            $table->string('difficulty_level')->nullable();
            $table->integer('max_travelers')->default(20);
            $table->boolean('is_active')->default(true);
            $table->boolean('is_featured')->default(false);
            $table->string('mood_category')->nullable(); // relaxing, adventurous, cultural, etc.
            $table->integer('distance_from_city')->nullable(); // in km
            $table->string('best_season')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tour_packages');
    }
};
