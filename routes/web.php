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
    Route::post('/request-counseling/{id}/approve', [RequestCounselingController::class, 'approve'])->name('request-counseling.approve');
    Route::post('/request-counseling/{id}/reject', [RequestCounselingController::class, 'reject'])->name('request-counseling.reject');
    Route::post('/request-counseling/{id}/complete', [RequestCounselingController::class, 'markAsCompleted'])->name('request-counseling.complete');
    Route::get('/shared-experience', [SharedExperienceController::class, 'index'])->name('shared-experience');
    Route::get('/resolve-cases', [ResolveCasesController::class, 'index'])->name('resolve-cases');
    Route::get('/schedule-calendar', [ScheduleCalendarController::class, 'index'])->name('schedule-calendar');
    Route::get('/schedule-calendar/events', [ScheduleCalendarController::class, 'getEvents'])->name('schedule-calendar.events');
    Route::get('/incident', [IncidentController::class, 'index'])->name('incident');
    Route::get('/incident/print', [IncidentController::class, 'print'])->name('incident.print');
    Route::post('/incident', [IncidentController::class, 'store'])->name('incident.store');
    Route::put('/incident/{id}', [IncidentController::class, 'update'])->name('incident.update');
    Route::delete('/incident/{id}', [IncidentController::class, 'destroy'])->name('incident.destroy');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

Route::post('/request-counseling', [WelcomeController::class, 'store'])
    ->name('request-counseling.store');

Route::post('/share-experience', [WelcomeController::class, 'storeExperience'])
    ->name('share-experience.store');
