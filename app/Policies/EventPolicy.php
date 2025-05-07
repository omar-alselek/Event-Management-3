<?php

namespace App\Policies;

use App\Models\Event;
use App\Models\User;

class EventPolicy
{
    public function viewAny(?User $user)
    {
        return true;
    }

    public function view(?User $user, Event $event)
    {
        return true;
    }

    public function create(User $user)
    {
        return $user->isOrganizer() && $user->is_approved;
    }

    public function update(User $user, Event $event)
    {
        return $user->isOrganizer() && $user->is_approved && $event->organizer_id === $user->organizer->id;
    }

    public function delete(User $user, Event $event)
    {
        return $user->isOrganizer() && $user->is_approved && $event->organizer_id === $user->organizer->id;
    }
} 