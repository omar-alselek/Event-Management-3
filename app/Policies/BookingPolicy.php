<?php

namespace App\Policies;

use App\Models\Booking;
use App\Models\User;

class BookingPolicy
{
    public function viewAny(User $user)
    {
        return true;
    }

    public function view(User $user, Booking $booking)
    {
        // فقط المشارك صاحب الحجز يمكنه رؤية QR
        return $user->role === 'attendee' && $user->id === $booking->user_id;
    }

    public function create(User $user)
    {
        return $user->isAttendee();
    }

    public function update(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id;
    }

    public function delete(User $user, Booking $booking)
    {
        return $user->id === $booking->user_id;
    }
} 