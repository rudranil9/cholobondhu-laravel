<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Booking\Models\Booking;

class TourPackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'location',
        'image_url',
        'price',
        'duration',
        'category',
        'features',
        'highlights',
        'difficulty_level',
        'max_travelers',
        'is_active',
        'is_featured',
        'mood_category',
        'distance_from_city',
        'best_season'
    ];

    protected $casts = [
        'features' => 'array',
        'highlights' => 'array',
        'price' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean'
    ];

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeByMood($query, $mood)
    {
        return $query->where('mood_category', $mood);
    }
}
