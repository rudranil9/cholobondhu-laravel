<?php

namespace Modules\Booking\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\TourPackage;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'tour_package_id',
        'customer_name',
        'customer_email',
        'customer_phone',
        'destination',
        'start_date',
        'end_date',
        'number_of_travelers',
        'budget_range',
        'special_requirements',
        'total_amount',
        'status',
        'payment_status',
        'notes',
        'booking_date',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'booking_date' => 'datetime',
        'total_amount' => 'decimal:2',
    ];

    protected $dates = [
        'start_date',
        'end_date',
        'booking_date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function tourPackage(): BelongsTo
    {
        return $this->belongsTo(TourPackage::class);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeConfirmed($query)
    {
        return $query->where('status', 'confirmed');
    }

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'warning',
            'confirmed' => 'success',
            'cancelled' => 'danger',
            'completed' => 'info',
            default => 'secondary'
        };
    }
}
