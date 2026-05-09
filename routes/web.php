<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\DeadlineController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\TeamController;
use Illuminate\Support\Facades\Route;

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

    Route::resource('subjects', SubjectController::class);
    Route::resource('deadlines', DeadlineController::class);
    Route::resource('documents', DocumentController::class);
    Route::resource('quizzes', QuizController::class);
    Route::resource('teams', TeamController::class);

    Route::post('/documents/{document}/summary/generate', [DocumentController::class, 'generateSummary'])->name('documents.summary.generate');
    Route::post('/documents/{document}/quiz/generate', [DocumentController::class, 'generateQuiz'])->name('documents.quiz.generate');
    Route::get('/documents/templates', [DocumentController::class, 'templates'])->name('documents.templates');
    Route::post('/quizzes/{quiz}/submit', [QuizController::class, 'submit'])->name('quizzes.submit');
    Route::post('/teams/{team}/members', [TeamController::class, 'storeMember'])->name('teams.members.store');
    Route::post('/teams/{team}/tasks', [TeamController::class, 'storeTask'])->name('teams.tasks.store');
});
