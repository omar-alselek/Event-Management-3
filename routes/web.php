<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminWebController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/admin/dashboard', [AdminWebController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('/admin/organizers/pending', [AdminWebController::class, 'pendingOrganizers'])->name('admin.organizers.pending');
    Route::post('/admin/organizers/{organizer}/approve', [AdminWebController::class, 'approveOrganizer'])->name('admin.organizers.approve');
    Route::get('/admin/reports', [AdminWebController::class, 'reports'])->name('admin.reports');
    Route::get('/admin/reports/{report}', [AdminWebController::class, 'showReport'])->name('admin.reports.show');
    Route::post('/admin/reports/{report}/update', [AdminWebController::class, 'updateReport'])->name('admin.reports.update');
});

Route::get('/admin/login', function() {
    return view('auth.login');
})->name('admin.login');
Route::post('/admin/login', [App\Http\Controllers\AdminWebController::class, 'login'])->name('admin.login.submit');
