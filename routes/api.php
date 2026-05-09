<?php

use App\Http\Controllers\Api\ActivityLogController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DeadlineController;
use App\Http\Controllers\Api\DocumentController;
use App\Http\Controllers\Api\NotificationController;
use App\Http\Controllers\Api\QuizAttemptController;
use App\Http\Controllers\Api\QuizController;
use App\Http\Controllers\Api\SubjectController;
use App\Http\Controllers\Api\SummaryController;
use App\Http\Controllers\Api\UserPreferenceController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes — Siramen
|--------------------------------------------------------------------------
|
| Semua route diawali /api (dikonfigurasi di bootstrap/app.php)
| Auth menggunakan Laravel Sanctum (token-based)
|
*/

// ─── AUTH (Public) ────────────────────────────────────────────────────────────
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('/{provider}/redirect', [AuthController::class, 'redirect'])->name('redirect');
    Route::get('/{provider}/callback', [AuthController::class, 'callback'])->name('callback');
});

// ─── PROTECTED ROUTES (Temporarily Unprotected for Development) ─────────────
// Route::middleware('auth:sanctum')->group(function () {
Route::name('api.')->group(function () {

    // Auth
    Route::prefix('auth')->name('auth.')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('/me',      [AuthController::class, 'me'])->name('me');
    });

    // User Preferences
    Route::prefix('preferences')->name('preferences.')->group(function () {
        Route::get('/',  [UserPreferenceController::class, 'show'])->name('show');
        Route::put('/',  [UserPreferenceController::class, 'update'])->name('update');
    });

    // Subjects
    Route::apiResource('subjects', SubjectController::class);

    // Deadlines
    Route::prefix('deadlines')->name('deadlines.')->group(function () {
        Route::apiResource('/', DeadlineController::class)->parameters(['' => 'deadline']);
        Route::patch('/{deadline}/toggle', [DeadlineController::class, 'toggle'])->name('toggle');
    });

    // Notifications
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/',                              [NotificationController::class, 'index'])->name('index');
        Route::patch('/{notification}/mark-sent',   [NotificationController::class, 'markSent'])->name('mark-sent');
        Route::delete('/{notification}',             [NotificationController::class, 'destroy'])->name('destroy');
    });

    // Documents
    Route::prefix('documents')->name('documents.')->group(function () {
        Route::get('/',              [DocumentController::class, 'index'])->name('index');
        Route::post('/',             [DocumentController::class, 'store'])->name('store');
        Route::get('/{document}',    [DocumentController::class, 'show'])->name('show');
        Route::delete('/{document}', [DocumentController::class, 'destroy'])->name('destroy');

        // Summary (nested di bawah document)
        Route::get('/{document}/summary',              [SummaryController::class, 'show'])->name('summary.show');
        Route::post('/{document}/summary/generate',    [SummaryController::class, 'generate'])->name('summary.generate');
        Route::post('/{document}/summary/regenerate',  [SummaryController::class, 'regenerate'])->name('summary.regenerate');

        // Quiz generate dari document
        Route::post('/{document}/quiz/generate', [QuizController::class, 'generate'])->name('quiz.generate');
    });

    // Quizzes
    Route::prefix('quizzes')->name('quizzes.')->group(function () {
        Route::get('/',           [QuizController::class, 'index'])->name('index');
        Route::get('/{quiz}',     [QuizController::class, 'show'])->name('show');
        Route::delete('/{quiz}',  [QuizController::class, 'destroy'])->name('destroy');

        // Attempts (nested di bawah quiz)
        Route::get('/{quiz}/attempts',               [QuizAttemptController::class, 'index'])->name('attempts.index');
        Route::post('/{quiz}/attempts',              [QuizAttemptController::class, 'store'])->name('attempts.store');
        Route::get('/{quiz}/attempts/{attempt}',     [QuizAttemptController::class, 'show'])->name('attempts.show');
    });

    // Activity Logs (read-only)
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
});
