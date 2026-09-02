<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\User\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboard;
use App\Http\Controllers\Employer\JobController as EmployerJob;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/swift-ai-recruit', [HomeController::class, 'Landing'])->name('user.landing');
Route::get('/pricing', [HomeController::class, 'Pricing'])->name('user.pricing');
Route::get('/about-us', [HomeController::class, 'about'])->name('user.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('user.contact');
Route::get('/jobs/listings', [HomeController::class, 'JobListings'])->name('user.job.listings');
Route::get('/job/details', [HomeController::class, 'JobDetails'])->name('user.job.details');

// Auth routes (web)
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('user/register', [AuthController::class, 'registerview'])->name('user.register');
    Route::post('user/register/validate', [AuthController::class, 'register'])->name('user.validate');
    Route::get('user/login', [AuthController::class, 'loginview'])->name('user.login');
    Route::post('user/login/validate', [AuthController::class, 'login'])->name('user.login.validate');
    Route::get('user/logout', [AuthController::class, 'logout'])->name('user.logout');
});

// Admin routes (protected)
Route::middleware(['auth:sanctum'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::resource('employers', EmployersController::class);
    Route::post('employers/{id}/restore', [EmployersController::class, 'restore'])->name('employers.restore');
    Route::delete('employers/{id}/force-delete', [EmployersController::class, 'forceDelete'])->name('employers.force-delete');
    Route::post('employers/bulk-delete', [EmployersController::class, 'bulkDelete'])->name('employers.bulk-delete');
    Route::get('employers/statistics', [EmployersController::class, 'statistics'])->name('employers.statistics');
    Route::get('employers/export', [EmployersController::class, 'export'])->name('employers.export');

    Route::resource('users', UsersController::class);
    Route::post('users/{id}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UsersController::class, 'forceDelete'])->name('users.force-delete');
    Route::post('users/bulk-delete', [UsersController::class, 'bulkDelete'])->name('users.bulk-delete');
    Route::post('users/bulk-status', [UsersController::class, 'bulkStatusUpdate'])->name('users.bulk-status');
    Route::get('users/statistics', [UsersController::class, 'statistics'])->name('users.statistics');
    Route::get('users/export', [UsersController::class, 'export'])->name('users.export');
    Route::post('users/{id}/verify-email', [UsersController::class, 'verifyEmail'])->name('users.verify-email');

    Route::resource('jobs', JobController::class);
    Route::post('jobs/bulk-delete', [JobController::class, 'bulkDelete'])->name('jobs.bulk-delete');
    Route::post('jobs/bulk-status', [JobController::class, 'bulkStatusUpdate'])->name('jobs.bulk-status');
    Route::get('jobs/statistics', [JobController::class, 'statistics'])->name('jobs.statistics');
    Route::get('jobs/export', [JobController::class, 'export'])->name('jobs.export');
    Route::post('jobs/{id}/toggle-status', [JobController::class, 'toggleStatus'])->name('jobs.toggle-status');
    Route::post('jobs/{id}/toggle-visibility', [JobController::class, 'toggleVisibility'])->name('jobs.toggle-visibility');
    Route::post('jobs/{id}/duplicate', [JobController::class, 'duplicate'])->name('jobs.duplicate');
});

// Employer routes (protected)
Route::middleware(['auth:sanctum'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboard::class, 'dashboard'])->name('dashboard');
    Route::resource('jobs', EmployerJob::class);
});
