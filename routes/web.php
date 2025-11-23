<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\dashboard\DashboardController;
use App\Http\Controllers\incident\IncidentController;
use App\Http\Controllers\requestcounseling\RequestCounselingController;
use App\Http\Controllers\resolvecases\ResolveCasesController;
use App\Http\Controllers\schedulecalendar\ScheduleCalendarController;
use App\Http\Controllers\sharedexperience\SharedExperienceController;
use App\Http\Controllers\welcome\WelcomeController;
use App\Http\Controllers\profile\ProfileController;
use App\Http\Controllers\usermanagement\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', [WelcomeController::class, 'index'])->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'create'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.submit');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::post('/notifications/{id}/mark-as-read', function ($id) {
    $notification = \App\Models\notification::findOrFail($id);
    $notification->update(['status' => 'read']);
    return response()->json(['success' => true]);
})->middleware('auth')->name('notifications.mark-as-read');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/request-counseling', [RequestCounselingController::class, 'index'])->name('request-counseling');
    Route::get('/request-counseling/print', [RequestCounselingController::class, 'print'])->name('request-counseling.print');
    Route::post('/request-counseling/{id}/approve', [RequestCounselingController::class, 'approve'])->name('request-counseling.approve');
    Route::post('/request-counseling/{id}/reject', [RequestCounselingController::class, 'reject'])->name('request-counseling.reject');
    Route::post('/request-counseling/{id}/complete', [RequestCounselingController::class, 'markAsCompleted'])->name('request-counseling.complete');
    Route::post('/request-counseling/{id}/update-remarks', [RequestCounselingController::class, 'updateRemarks'])->name('request-counseling.update-remarks');
    Route::delete('/request-counseling/{id}', [RequestCounselingController::class, 'destroy'])->name('request-counseling.destroy');
    Route::get('/shared-experience', [SharedExperienceController::class, 'index'])->name('shared-experience');
    Route::get('/shared-experience/print', [SharedExperienceController::class, 'print'])->name('shared-experience.print');
    Route::post('/shared-experience/{id}/mark-as-read', [SharedExperienceController::class, 'markAsRead'])->name('shared-experience.mark-as-read');
    Route::get('/resolve-cases', [ResolveCasesController::class, 'index'])->name('resolve-cases');
    Route::get('/resolve-cases/print', [ResolveCasesController::class, 'print'])->name('resolve-cases.print');
    Route::get('/schedule-calendar', [ScheduleCalendarController::class, 'index'])->name('schedule-calendar');
    Route::get('/schedule-calendar/events', [ScheduleCalendarController::class, 'getEvents'])->name('schedule-calendar.events');
    Route::get('/incident', [IncidentController::class, 'index'])->name('incident');
    Route::get('/incident/print', [IncidentController::class, 'print'])->name('incident.print');
    Route::get('/incident/{id}/print', [IncidentController::class, 'printSingle'])->name('incident.print-single');
    Route::post('/incident', [IncidentController::class, 'store'])->name('incident.store');
    Route::put('/incident/{id}', [IncidentController::class, 'update'])->name('incident.update');
    Route::delete('/incident/{id}', [IncidentController::class, 'destroy'])->name('incident.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    
    // User Management routes - Admin only
    Route::middleware('admin')->group(function () {
        Route::get('/user-management', [UserManagementController::class, 'index'])->name('user-management');
        Route::post('/user-management', [UserManagementController::class, 'store'])->name('user-management.store');
        Route::put('/user-management/{id}', [UserManagementController::class, 'update'])->name('user-management.update');
        Route::put('/user-management/{id}/status', [UserManagementController::class, 'updateStatus'])->name('user-management.update-status');
        Route::delete('/user-management/{id}', [UserManagementController::class, 'destroy'])->name('user-management.destroy');
    });
});

Route::post('/request-counseling', [WelcomeController::class, 'store'])
    ->name('request-counseling.store');

Route::post('/share-experience', [WelcomeController::class, 'storeExperience'])
    ->name('share-experience.store');
