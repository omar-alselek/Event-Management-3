<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminWebController;
use App\Http\Controllers\LoginController;

// Authentication routes
Route::get('/', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.submit');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminWebController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/organizers/pending', [AdminWebController::class, 'pendingOrganizers'])->name('admin.organizers.pending');
    Route::post('/admin/organizers/{organizer}/approve', [AdminWebController::class, 'approveOrganizer'])->name('admin.organizers.approve');
    Route::get('/admin/reports', [AdminWebController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/reports/{report}', [AdminWebController::class, 'showReport'])->name('admin.reports.show');
    Route::post('/admin/reports/{report}/update', [AdminWebController::class, 'updateReport'])->name('admin.reports.update');

    // Users
    Route::get('/admin/users', [AdminWebController::class, 'usersIndex'])->name('admin.users.index');
    Route::get('/admin/users/{user}', [AdminWebController::class, 'usersShow'])->name('admin.users.show');
    Route::get('/admin/users/{user}/edit', [AdminWebController::class, 'usersEdit'])->name('admin.users.edit');
    Route::post('/admin/users/{user}/update', [AdminWebController::class, 'usersUpdate'])->name('admin.users.update');
    Route::post('/admin/users/{user}/ban', [AdminWebController::class, 'usersBan'])->name('admin.users.ban');
    Route::post('/admin/users/{user}/unban', [AdminWebController::class, 'usersUnban'])->name('admin.users.unban');
    Route::get('/admin/users/{user}/change-role', [AdminWebController::class, 'usersChangeRole'])->name('admin.users.changeRole');
    Route::delete('/admin/users/{user}', [AdminWebController::class, 'usersDestroy'])->name('admin.users.destroy');

    // Events
    Route::get('/admin/events', [AdminWebController::class, 'eventsIndex'])->name('admin.events.index');
    Route::get('/admin/events/{event}', [AdminWebController::class, 'eventsShow'])->name('admin.events.show');
    Route::get('/admin/events/{event}/edit', [AdminWebController::class, 'eventsEdit'])->name('admin.events.edit');
    Route::post('/admin/events/{event}/update', [AdminWebController::class, 'eventsUpdate'])->name('admin.events.update');
    Route::delete('/admin/events/{event}', [AdminWebController::class, 'eventsDestroy'])->name('admin.events.destroy');
    Route::post('/admin/events/{event}/publish', [AdminWebController::class, 'eventsPublish'])->name('admin.events.publish');
    Route::post('/admin/events/{event}/unpublish', [AdminWebController::class, 'eventsUnpublish'])->name('admin.events.unpublish');

    // Bookings
    Route::get('/admin/bookings', [AdminWebController::class, 'bookingsIndex'])->name('admin.bookings.index');
    Route::get('/admin/bookings/{booking}', [AdminWebController::class, 'bookingsShow'])->name('admin.bookings.show');
    Route::get('/admin/bookings/{booking}/edit', [AdminWebController::class, 'bookingsEdit'])->name('admin.bookings.edit');
    Route::post('/admin/bookings/{booking}/update', [AdminWebController::class, 'bookingsUpdate'])->name('admin.bookings.update');
    Route::post('/admin/bookings/{booking}/cancel', [AdminWebController::class, 'bookingsCancel'])->name('admin.bookings.cancel');
    Route::post('/admin/bookings/{booking}/complete', [AdminWebController::class, 'bookingsComplete'])->name('admin.bookings.complete');

    // Tickets
    Route::get('/admin/tickets', [AdminWebController::class, 'ticketsIndex'])->name('admin.tickets.index');
    Route::get('/admin/tickets/{ticket}', [AdminWebController::class, 'ticketsShow'])->name('admin.tickets.show');
    Route::get('/admin/tickets/{ticket}/edit', [AdminWebController::class, 'ticketsEdit'])->name('admin.tickets.edit');
    Route::post('/admin/tickets/{ticket}/update', [AdminWebController::class, 'ticketsUpdate'])->name('admin.tickets.update');
    Route::delete('/admin/tickets/{ticket}', [AdminWebController::class, 'ticketsDestroy'])->name('admin.tickets.destroy');
    Route::post('/admin/tickets/{ticket}/activate', [AdminWebController::class, 'ticketsActivate'])->name('admin.tickets.activate');
    Route::post('/admin/tickets/{ticket}/deactivate', [AdminWebController::class, 'ticketsDeactivate'])->name('admin.tickets.deactivate');
});

// Admin logout route (kept for compatibility with existing code)
Route::post('/admin/logout', function() {
    auth()->logout();
    return redirect()->route('login');
})->name('admin.logout');
