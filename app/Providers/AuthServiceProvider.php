<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Event;
use App\Models\Ticket;
use App\Models\Booking;
use App\Models\Report;
use App\Models\Organizer;
use App\Policies\EventPolicy;
use App\Policies\TicketPolicy;
use App\Policies\BookingPolicy;
use App\Policies\ReportPolicy;
use App\Policies\OrganizerPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class => EventPolicy::class,
        Ticket::class => TicketPolicy::class,
        Booking::class => BookingPolicy::class,
        Report::class => ReportPolicy::class,
        Organizer::class => OrganizerPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
} 