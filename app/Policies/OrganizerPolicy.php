<?php

namespace App\Policies;

use App\Models\Organizer;
use App\Models\User;

class OrganizerPolicy
{
    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function view(User $user, Organizer $organizer)
    {
        return $user->isAdmin() || $user->id === $organizer->user_id;
    }

    public function create(User $user)
    {
        return $user->isOrganizer();
    }

    public function update(User $user, Organizer $organizer)
    {
        return $user->isAdmin() || $user->id === $organizer->user_id;
    }

    public function delete(User $user, Organizer $organizer)
    {
        return $user->isAdmin();
    }
} 