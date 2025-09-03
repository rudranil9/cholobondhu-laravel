<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

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
        'booking_number'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'booking_date' => 'datetime',
        'total_amount' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function tourPackage()
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

    public function scopeByDateRange($query, $startDate, $endDate)
    {
        return $query->whereBetween('booking_date', [$startDate, $endDate]);
    }

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($booking) {
            if (empty($booking->booking_number)) {
                $booking->booking_number = self::generateBookingNumber();
            }
        });
    }
    
    public static function generateBookingNumber()
    {
        do {
            // Generate format: CB + YYYYMMDD + 4 random characters
            $date = now()->format('Ymd');
            $random = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 4));
            $bookingNumber = 'CB' . $date . $random;
        } while (self::where('booking_number', $bookingNumber)->exists());
        
        return $bookingNumber;
    }
}
