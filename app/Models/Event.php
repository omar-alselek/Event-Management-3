<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        'organizer_id',
        'title',
        'description',
        'location',
        'latitude',
        'longitude',
        'start_date',
        'end_date',
        'category',
        'image_path',
        'video_path',
        'is_published',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function organizer()
    {
        return $this->belongsTo(Organizer::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
} 