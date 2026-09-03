<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\User\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboard;
use App\Http\Controllers\Employer\JobController as EmployerJob;
use App\Http\Controllers\JobSeeker\DashboardController as CandidateDashboard;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobSeeker\JobController as JobSeekerJobController;
use App\Http\Controllers\JobSeeker\EmployersController as JobSeekerEmployerController;

// Public routes
Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/swift-ai-recruit', [HomeController::class, 'Landing'])->name('user.landing');
Route::get('/pricing', [HomeController::class, 'Pricing'])->name('user.pricing');
Route::post('subscribe', [HomeController::class, 'subscribe'])->name('user.subscribe');
Route::get('checkout/{plan}', [HomeController::class, 'checkout'])->name('user.checkout');
Route::get('/about-us', [HomeController::class, 'about'])->name('user.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('user.contact');
Route::get('/jobs/listings', [HomeController::class, 'JobListings'])->name('user.job.listings');
Route::get('/job/details/{id}', [HomeController::class, 'JobDetails'])->name('user.job.details');

// Auth routes (web)
Route::prefix('auth')->name('auth.')->group(function () {
    Route::get('register', [AuthController::class, 'registerview'])->name('user.register');
    Route::post('register/validate', [AuthController::class, 'register'])->name('user.validate');
    Route::get('login', [AuthController::class, 'loginview'])->name('user.login');
    Route::post('login/validate', [AuthController::class, 'login'])->name('user.login.validate');
    Route::get('logout', [AuthController::class, 'logout'])->name('user.logout');
});

Route::get('login', function() {
    return redirect()->route('auth.user.login');
})->name('login');

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
    // Soft Delete Routes
    Route::patch('jobs/{id}/restore', [JobController::class, 'restore'])->name('jobs.restore');
    Route::delete('jobs/{id}/force-delete', [JobController::class, 'forceDelete'])->name('jobs.force-delete');
    Route::patch('jobs/{id}/toggle-status', [JobController::class, 'toggleStatus'])->name('jobs.toggle-status');
    Route::post('jobs/{id}/duplicate', [JobController::class, 'duplicate'])->name('jobs.duplicate');

    // Bulk Routes
    Route::post('jobs/bulk-delete', [JobController::class, 'bulkDelete'])->name('jobs.bulk-delete');
    Route::post('jobs/bulk-restore', [JobController::class, 'bulkRestore'])->name('jobs.bulk-restore');
    Route::post('jobs/bulk-force-delete', [JobController::class, 'bulkForceDelete'])->name('jobs.bulk-force-delete');
    Route::post('jobs/bulk-status-update', [JobController::class, 'bulkStatusUpdate'])->name('jobs.bulk-status-update');


    Route::resource('subscription-plans', SubscriptionController::class);

    // Additional Routes
    Route::patch('subscription-plans/{id}/toggle-status', [SubscriptionController::class, 'toggleStatus'])->name('subscription-plans.toggle-status');
    Route::post('subscription-plans/{id}/duplicate', [SubscriptionController::class, 'duplicate'])->name('subscription-plans.duplicate');
    Route::post('subscription-plans/bulk-delete', [SubscriptionController::class, 'bulkDelete'])->name('subscription-plans.bulk-delete');
    Route::post('subscription-plans/bulk-status', [SubscriptionController::class, 'bulkStatusUpdate'])->name('subscription-plans.bulk-status');

    // ===== USER SUBSCRIPTIONS =====
    Route::get('subscriptions', [SubscriptionController::class, 'subscriptions'])
        ->name('subscriptions.index');
    Route::get('subscriptions/{id}', [SubscriptionController::class, 'showSubscription'])
        ->name('subscriptions.show');
    Route::put('subscriptions/{id}', [SubscriptionController::class, 'updateSubscription'])
        ->name('subscriptions.update');
    Route::post('subscriptions/{id}/cancel', [SubscriptionController::class, 'cancelSubscription'])
        ->name('subscriptions.cancel');
    Route::post('subscriptions/{id}/activate', [SubscriptionController::class, 'activateSubscription'])
        ->name('subscriptions.activate');
    Route::post('subscriptions/{id}/extend', [SubscriptionController::class, 'extendSubscription'])
        ->name('subscriptions.extend');
    Route::post('subscriptions/bulk-update', [SubscriptionController::class, 'bulkSubscriptionUpdate'])
        ->name('subscriptions.bulk-update');
});

// Employer routes (protected)
Route::middleware(['auth:sanctum'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('/dashboard', [EmployerDashboard::class, 'dashboard'])->name('dashboard');
    Route::resource('jobs', EmployerJob::class);
    
    // Soft Delete Routes
    Route::patch('jobs/{id}/restore', [EmployerJob::class, 'restore'])->name('jobs.restore');
    Route::delete('jobs/{id}/force-delete', [EmployerJob::class, 'forceDelete'])->name('jobs.force-delete');
    Route::patch('jobs/{id}/toggle-status', [EmployerJob::class, 'toggleStatus'])->name('jobs.toggle-status');
    Route::post('jobs/{id}/duplicate', [EmployerJob::class, 'duplicate'])->name('jobs.duplicate');
    
    // Bulk Routes
    Route::post('jobs/bulk-delete', [EmployerJob::class, 'bulkDelete'])->name('jobs.bulk-delete');
    Route::post('jobs/bulk-restore', [EmployerJob::class, 'bulkRestore'])->name('jobs.bulk-restore');
    Route::post('jobs/bulk-force-delete', [EmployerJob::class, 'bulkForceDelete'])->name('jobs.bulk-force-delete');
    Route::post('jobs/bulk-status-update', [EmployerJob::class, 'bulkStatusUpdate'])->name('jobs.bulk-status-update');
});

// Job Seeker routes (protected)
Route::middleware(['auth:sanctum'])->prefix('candidate')->name('candidate.')->group(function () {
    Route::get('/dashboard', [CandidateDashboard::class, 'dashboard'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'EditProfile'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'UpdateProfile'])->name('profile.update');
    // Education Routes
    Route::post('/education', [ProfileController::class, 'storeEducation'])->name('education.store');
    Route::put('/education/{id}', [ProfileController::class, 'updateEducation'])->name('education.update');
    Route::delete('/education/{id}', [ProfileController::class, 'destroyEducation'])->name('education.destroy');
    
    // Experience Routes
    Route::post('/experience', [ProfileController::class, 'storeExperience'])->name('experience.store');
    Route::put('/experience/{id}', [ProfileController::class, 'updateExperience'])->name('experience.update');
    Route::delete('/experience/{id}', [ProfileController::class, 'destroyExperience'])->name('experience.destroy');
    
    // Certificate Routes
    Route::post('/certificate', [ProfileController::class, 'storeCertificate'])->name('certificate.store');
    Route::put('/certificate/{id}', [ProfileController::class, 'updateCertificate'])->name('certificate.update');
    Route::delete('/certificate/{id}', [ProfileController::class, 'destroyCertificate'])->name('certificate.destroy');

    // Job Listings
    Route::get('/jobs', [JobSeekerJobController::class, 'JobPosts'])->name('jobs.listings');
    Route::get('/job/{id}/details', [JobSeekerJobController::class, 'getJobDetails'])->name('job.details');

    // Saved Jobs Routes
    Route::get('/saved-jobs', [JobSeekerJobController::class, 'getSavedJobs'])->name('saved-jobs.index');
    Route::post('/jobs/save', [JobSeekerJobController::class, 'saveJob'])->name('jobs.save');
    Route::delete('/jobs/unsave/{id}', [JobSeekerJobController::class, 'unsaveJob'])->name('jobs.unsave');
    Route::post('/jobs/toggle-save', [JobSeekerJobController::class, 'toggleSave'])->name('jobs.toggle-save');
    Route::put('/saved-jobs/{id}', [JobSeekerJobController::class, 'updateSavedJob'])->name('saved-jobs.update');
    Route::get('/jobs/saved-status/{jobPostId}', [JobSeekerJobController::class, 'checkSavedStatus'])->name('jobs.saved-status');

    // Apply Job Routes
    Route::get('/job/{id}/apply', [JobSeekerJobController::class, 'showApplyForm'])->name('job.apply.form');
    Route::post('/job/apply', [JobSeekerJobController::class, 'applyJob'])->name('job.apply');
    Route::post('/job/quick-apply', [JobSeekerJobController::class, 'quickApply'])->name('job.quick-apply');
    Route::get('/my-applications', [JobSeekerJobController::class, 'getMyApplications'])->name('my-applications');
    Route::post('/application/{id}/withdraw', [JobSeekerJobController::class, 'withdrawApplication'])->name('application.withdraw');
    Route::get('/application/status/{jobPostId}', [JobSeekerJobController::class, 'getApplicationStatus'])->name('application.status');

    // Employer Routes
    Route::get('/employers', [JobSeekerEmployerController::class, 'index'])->name('employers.index');
    Route::get('/employers/{id}', [JobSeekerEmployerController::class, 'show'])->name('employers.show');
    Route::get('/employers/featured', [JobSeekerEmployerController::class, 'featured'])->name('employers.featured');
    Route::get('/employers/{id}/jobs', [JobSeekerEmployerController::class, 'employerJobs'])->name('employers.jobs');
    
});
