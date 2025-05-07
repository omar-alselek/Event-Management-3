<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

    protected $fillable = [
        'event_id',
        'type',
        'price',
        'quantity',
        'remaining_quantity',
        'description',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'quantity' => 'integer',
        'remaining_quantity' => 'integer',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }
} 