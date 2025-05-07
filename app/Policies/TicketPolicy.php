<?php

namespace App\Policies;

use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    public function viewAny(User $user)
    {
        return $user->isOrganizer() && $user->is_approved;
    }

    public function view(User $user, Ticket $ticket)
    {
        return $user->isOrganizer() && $user->is_approved && $ticket->event->organizer_id === $user->organizer->id;
    }

    public function create(User $user)
    {
        return $user->isOrganizer() && $user->is_approved;
    }

    public function update(User $user, Ticket $ticket)
    {
        return $user->isOrganizer() && $user->is_approved && $ticket->event->organizer_id === $user->organizer->id;
    }

    public function delete(User $user, Ticket $ticket)
    {
        return $user->isOrganizer() && $user->is_approved && $ticket->event->organizer_id === $user->organizer->id;
    }
} 