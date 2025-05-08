<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrganizerController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReportController;

// Public routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/register/attendee', [AuthController::class, 'registerAttendee']);
Route::post('/register/organizer', [AuthController::class, 'registerOrganizer']);
Route::post('/login', [AuthController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // Organizer routes
    Route::apiResource('events', EventController::class);
    // Explicit route for updating events to ensure PUT requests work
    Route::put('/events/{event}', [EventController::class, 'update']);
    Route::apiResource('tickets', TicketController::class);

    // Attendee routes
    Route::get('/events', [EventController::class, 'index']);
    Route::get('/events/{event}', [EventController::class, 'show']);
    Route::apiResource('bookings', BookingController::class);
    Route::post('/events/{event}/report', [ReportController::class, 'store']);
    Route::get('/bookings/{booking}/qr', [BookingController::class, 'qrCode']);
    Route::post('/bookings/{booking}/cancel', [BookingController::class, 'cancel']);
    // مسار جلب تفاصيل الحجز بشكل صريح
    Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show']);
    // مسار جلب كود QR للحجز بشكل صريح
    Route::get('/bookings/{booking}/qr-code', [App\Http\Controllers\BookingController::class, 'qrCode']);

    // Admin routes
    Route::get('/organizers/pending', [OrganizerController::class, 'pendingApprovals']);
    Route::post('/organizers/{organizer}/approve', [OrganizerController::class, 'approve']);
    Route::get('/reports', [ReportController::class, 'index']);
    Route::put('/reports/{report}', [ReportController::class, 'update']);

    // مسار جلب بيانات المستخدم الحالي
    Route::get('/profile', [AuthController::class, 'profile']);
    Route::middleware('auth:sanctum')->put('/profile', [App\Http\Controllers\AuthController::class, 'updateProfile']);
}); 