<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\ZoomController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\MatchController;
use App\Http\Controllers\Auth\User\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EmployersController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Admin\CvTemplateController;
use App\Http\Controllers\Admin\JobController as AdminJobController;
use App\Http\Controllers\Admin\SubscriptionController;
use App\Http\Controllers\Employer\DashboardController as EmployerDashboard;
use App\Http\Controllers\Employer\JobController as EmployerJob;
use App\Http\Controllers\Employer\InterviewController as EmployerInterviewed;
use App\Http\Controllers\JobSeeker\DashboardController as CandidateDashboard;
use App\Http\Controllers\JobSeeker\ProfileController;
use App\Http\Controllers\JobSeeker\CvController;
use App\Http\Controllers\JobSeeker\JobController as JobSeekerJobController;
use App\Http\Controllers\JobSeeker\EmployersController as JobSeekerEmployerController;

// ============================================================
// PUBLIC ROUTES
// ============================================================
Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/swift-ai-recruit', [HomeController::class, 'Landing'])->name('user.landing');
Route::get('/pricing', [HomeController::class, 'Pricing'])->name('user.pricing');
Route::post('subscribe', [HomeController::class, 'subscribe'])->name('user.subscribe');
Route::get('checkout/{plan}', [HomeController::class, 'checkout'])->name('user.checkout');
Route::get('/about-us', [HomeController::class, 'about'])->name('user.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('user.contact');
Route::get('/jobs/listings', [HomeController::class, 'JobListings'])->name('user.job.listings');
Route::get('/job/details/{id}', [HomeController::class, 'JobDetails'])->name('user.job.details');

// ============================================================
// AUTH ROUTES (WEB)
// ============================================================
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

// ============================================================
// ADMIN ROUTES (PROTECTED)
// ============================================================
Route::middleware(['auth:sanctum'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    // Employers Management
    Route::resource('employers', EmployersController::class);
    Route::post('employers/{id}/restore', [EmployersController::class, 'restore'])->name('employers.restore');
    Route::delete('employers/{id}/force-delete', [EmployersController::class, 'forceDelete'])->name('employers.force-delete');
    Route::post('employers/bulk-delete', [EmployersController::class, 'bulkDelete'])->name('employers.bulk-delete');
    Route::get('employers/statistics', [EmployersController::class, 'statistics'])->name('employers.statistics');
    Route::get('employers/export', [EmployersController::class, 'export'])->name('employers.export');

    // Users Management
    Route::resource('users', UsersController::class);
    Route::post('users/{id}/restore', [UsersController::class, 'restore'])->name('users.restore');
    Route::delete('users/{id}/force-delete', [UsersController::class, 'forceDelete'])->name('users.force-delete');
    Route::post('users/bulk-delete', [UsersController::class, 'bulkDelete'])->name('users.bulk-delete');
    Route::post('users/bulk-status', [UsersController::class, 'bulkStatusUpdate'])->name('users.bulk-status');
    Route::get('users/statistics', [UsersController::class, 'statistics'])->name('users.statistics');
    Route::get('users/export', [UsersController::class, 'export'])->name('users.export');
    Route::post('users/{id}/verify-email', [UsersController::class, 'verifyEmail'])->name('users.verify-email');

    // Admin Jobs Management
    Route::resource('jobs', AdminJobController::class);
    Route::post('jobs/bulk-delete', [AdminJobController::class, 'bulkDelete'])->name('jobs.bulk-delete');
    Route::post('jobs/bulk-status', [AdminJobController::class, 'bulkStatusUpdate'])->name('jobs.bulk-status');
    Route::get('jobs/statistics', [AdminJobController::class, 'statistics'])->name('jobs.statistics');
    Route::get('jobs/export', [AdminJobController::class, 'export'])->name('jobs.export');
    Route::patch('jobs/{id}/restore', [AdminJobController::class, 'restore'])->name('jobs.restore');
    Route::delete('jobs/{id}/force-delete', [AdminJobController::class, 'forceDelete'])->name('jobs.force-delete');
    Route::patch('jobs/{id}/toggle-status', [AdminJobController::class, 'toggleStatus'])->name('jobs.toggle-status');
    Route::post('jobs/{id}/duplicate', [AdminJobController::class, 'duplicate'])->name('jobs.duplicate');
    Route::post('jobs/bulk-restore', [AdminJobController::class, 'bulkRestore'])->name('jobs.bulk-restore');
    Route::post('jobs/bulk-force-delete', [AdminJobController::class, 'bulkForceDelete'])->name('jobs.bulk-force-delete');
    Route::post('jobs/bulk-status-update', [AdminJobController::class, 'bulkStatusUpdate'])->name('jobs.bulk-status-update');

    // Subscription Plans Management
    Route::resource('subscription-plans', SubscriptionController::class);
    Route::patch('subscription-plans/{id}/toggle-status', [SubscriptionController::class, 'toggleStatus'])->name('subscription-plans.toggle-status');
    Route::post('subscription-plans/{id}/duplicate', [SubscriptionController::class, 'duplicate'])->name('subscription-plans.duplicate');
    Route::post('subscription-plans/bulk-delete', [SubscriptionController::class, 'bulkDelete'])->name('subscription-plans.bulk-delete');
    Route::post('subscription-plans/bulk-status', [SubscriptionController::class, 'bulkStatusUpdate'])->name('subscription-plans.bulk-status');

    // User Subscriptions
    Route::get('subscriptions', [SubscriptionController::class, 'subscriptions'])->name('subscriptions.index');
    Route::get('subscriptions/{id}', [SubscriptionController::class, 'showSubscription'])->name('subscriptions.show');
    Route::put('subscriptions/{id}', [SubscriptionController::class, 'updateSubscription'])->name('subscriptions.update');
    Route::post('subscriptions/{id}/cancel', [SubscriptionController::class, 'cancelSubscription'])->name('subscriptions.cancel');
    Route::post('subscriptions/{id}/activate', [SubscriptionController::class, 'activateSubscription'])->name('subscriptions.activate');
    Route::post('subscriptions/{id}/extend', [SubscriptionController::class, 'extendSubscription'])->name('subscriptions.extend');
    Route::post('subscriptions/bulk-update', [SubscriptionController::class, 'bulkSubscriptionUpdate'])->name('subscriptions.bulk-update');
   
    // CV Templates
    Route::resource('cv-templates', CvTemplateController::class);
    Route::get('cv-templates/{cvTemplate}/preview', [CvTemplateController::class, 'preview'])
        ->name('cv-templates.preview');
});

// ============================================================
// EMPLOYER ROUTES (PROTECTED)
// ============================================================
Route::middleware(['auth:sanctum'])->prefix('employer')->name('employer.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [EmployerDashboard::class, 'dashboard'])->name('dashboard');

    // ============================================================
    // JOB MANAGEMENT ROUTES
    // ============================================================
    Route::prefix('jobs')->name('jobs.')->group(function () {
        // CRUD Operations
        Route::get('/', [EmployerJob::class, 'index'])->name('index');
        Route::get('/create', [EmployerJob::class, 'create'])->name('create');
        Route::post('/', [EmployerJob::class, 'store'])->name('store');
        Route::get('/{id}', [EmployerJob::class, 'show'])->name('show');
        Route::get('/{id}/edit', [EmployerJob::class, 'edit'])->name('edit');
        Route::put('/{id}', [EmployerJob::class, 'update'])->name('update');
        Route::delete('/{id}', [EmployerJob::class, 'destroy'])->name('destroy');

        // Soft Delete Operations
        Route::patch('/{id}/restore', [EmployerJob::class, 'restore'])->name('restore');
        Route::delete('/{id}/force-delete', [EmployerJob::class, 'forceDelete'])->name('force-delete');

        // Status & Visibility Operations
        Route::patch('/{id}/toggle-status', [EmployerJob::class, 'toggleStatus'])->name('toggle-status');
        Route::patch('/{id}/toggle-visibility', [EmployerJob::class, 'toggleVisibility'])->name('toggle-visibility');

        // Duplicate Operation
        Route::post('/{id}/duplicate', [EmployerJob::class, 'duplicate'])->name('duplicate');

        // Bulk Operations
        Route::post('/bulk-delete', [EmployerJob::class, 'bulkDelete'])->name('bulk-delete');
        Route::post('/bulk-restore', [EmployerJob::class, 'bulkRestore'])->name('bulk-restore');
        Route::post('/bulk-force-delete', [EmployerJob::class, 'bulkForceDelete'])->name('bulk-force-delete');
        Route::post('/bulk-status-update', [EmployerJob::class, 'bulkStatusUpdate'])->name('bulk-status-update');

        // Export & Statistics
        Route::get('/export', [EmployerJob::class, 'export'])->name('export');
        Route::get('/statistics', [EmployerJob::class, 'statistics'])->name('statistics');
    });

    // ============================================================
    // APPLICATION MANAGEMENT ROUTES
    // ============================================================
    Route::prefix('applications')->name('applications.')->group(function () {
        // Main applications listing
        Route::get('/', [EmployerJob::class, 'getEmployerApplications'])->name('index');
        Route::get('/interview', [EmployerInterviewed::class, 'Applications'])->name('interview');
        Route::post('/{applicationId}/schedule-interview', [EmployerInterviewed::class, 'scheduleInterview'])->name('schedule-interview');
        Route::get('/{applicationId}/interview-details', [EmployerInterviewed::class, 'getInterviewDetails'])->name('interview-details');
        Route::get('/{applicationId}', [EmployerJob::class, 'showApplication'])->name('show');
        Route::get('/job/{jobId}', [EmployerJob::class, 'getJobApplications'])->name('job');
        Route::put('/{applicationId}/status', [EmployerJob::class, 'updateApplicationStatus'])->name('update-status');
        Route::post('/bulk-status', [EmployerJob::class, 'bulkUpdateApplicationStatus'])->name('bulk-status');
        Route::delete('/bulk-delete', [EmployerJob::class, 'bulkDeleteApplications'])->name('bulk-delete');
        Route::delete('/{applicationId}', [EmployerJob::class, 'destroyApplication'])->name('destroy');
        Route::get('/export', [EmployerJob::class, 'exportApplications'])->name('export');
        Route::get('/stats', [EmployerJob::class, 'getApplicationStats'])->name('stats');
        Route::get('/{applicationId}/download-resume', [EmployerJob::class, 'downloadResume'])->name('download-resume');
    });

    // ============================================================
    // INTERVIEW MANAGEMENT ROUTES
    // ============================================================
    Route::prefix('interviews')->name('interviews.')->group(function () {
        Route::get('/', [EmployerInterviewed::class, 'scheduledInterviews'])->name('index');
        Route::get('/list', [EmployerInterviewed::class, 'getScheduledInterviews'])->name('list');
        Route::get('/upcoming', [EmployerInterviewed::class, 'getUpcomingInterviews'])->name('upcoming');
        Route::post('/{id}/cancel', [EmployerInterviewed::class, 'cancelInterview'])->name('cancel');
        Route::put('/{id}/reschedule', [EmployerInterviewed::class, 'rescheduleInterview'])->name('reschedule');
        Route::post('/{id}/complete', [EmployerInterviewed::class, 'completeInterview'])->name('complete');
        Route::get('/application/{applicationId}', [EmployerInterviewed::class, 'getInterviewDetails'])->name('details');
        Route::post('/send-reminders', [EmployerInterviewed::class, 'sendReminders'])->name('send-reminders');
    });

    // ============================================================
    // MATCH MANAGEMENT ROUTES - Using root MatchController (NOT Employer\MatchController)
    // ============================================================
    Route::prefix('matches')->name('matches.')->group(function () {
        Route::get('/dashboard', [MatchController::class, 'dashboard'])->name('dashboard');
        Route::get('/', [MatchController::class, 'allMatches'])->name('all');
        Route::get('/job/{jobId}', [MatchController::class, 'jobMatches'])->name('job');
        Route::get('/{matchId}', [MatchController::class, 'show'])->name('show');
        Route::get('/{matchId}/recommendations', [MatchController::class, 'getRecommendations'])->name('recommendations');
        Route::post('/{matchId}/shortlist', [MatchController::class, 'shortlist'])->name('shortlist');
        Route::post('/{matchId}/unshortlist', [MatchController::class, 'unshortlist'])->name('unshortlist');
        Route::post('/bulk-shortlist', [MatchController::class, 'bulkShortlist'])->name('bulk-shortlist');
        Route::post('/{matchId}/view', [MatchController::class, 'markAsViewed'])->name('view');
        Route::post('/{matchId}/notes', [MatchController::class, 'addNotes'])->name('add-notes');
        Route::get('/export', [MatchController::class, 'export'])->name('export');
        Route::get('/{matchId}/export', [MatchController::class, 'exportMatch'])->name('export-match');
        Route::get('/reports/hiring-pipeline', [MatchController::class, 'hiringPipeline'])->name('hiring-pipeline');
        Route::get('/reports/analytics', [MatchController::class, 'matchAnalytics'])->name('analytics');
    });

    // ============================================================
    // NOTIFICATION ROUTES (EMPLOYER)
    // ============================================================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/latest', [NotificationController::class, 'latest'])->name('latest');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/read/delete', [NotificationController::class, 'deleteRead'])->name('delete-read');
    });

    // ============================================================
    // JOB-SPECIFIC APPLICATIONS (Alternate route)
    // ============================================================
    Route::get('/jobs/{jobId}/applications', [EmployerJob::class, 'getJobApplications'])->name('jobs.applications');
});

// ============================================================
// JOB SEEKER ROUTES (PROTECTED)
// ============================================================
Route::middleware(['auth:sanctum'])->prefix('candidate')->name('candidate.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [CandidateDashboard::class, 'dashboard'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'profile'])->name('profile');
    Route::get('/profile/edit', [ProfileController::class, 'EditProfile'])->name('profile.edit');
    Route::put('/profile/update', [ProfileController::class, 'UpdateProfile'])->name('profile.update');

    // Education
    Route::post('/education', [ProfileController::class, 'storeEducation'])->name('education.store');
    Route::put('/education/{id}', [ProfileController::class, 'updateEducation'])->name('education.update');
    Route::delete('/education/{id}', [ProfileController::class, 'destroyEducation'])->name('education.destroy');

    // Experience
    Route::post('/experience', [ProfileController::class, 'storeExperience'])->name('experience.store');
    Route::put('/experience/{id}', [ProfileController::class, 'updateExperience'])->name('experience.update');
    Route::delete('/experience/{id}', [ProfileController::class, 'destroyExperience'])->name('experience.destroy');

    // Certificates
    Route::post('/certificate', [ProfileController::class, 'storeCertificate'])->name('certificate.store');
    Route::put('/certificate/{id}', [ProfileController::class, 'updateCertificate'])->name('certificate.update');
    Route::delete('/certificate/{id}', [ProfileController::class, 'destroyCertificate'])->name('certificate.destroy');

    // Job Listings
    Route::get('/jobs', [JobSeekerJobController::class, 'JobPosts'])->name('jobs.listings');
    Route::get('/job/{id}/details', [JobSeekerJobController::class, 'getJobDetails'])->name('job.details');

    // Saved Jobs
    Route::get('/saved-jobs', [JobSeekerJobController::class, 'getSavedJobs'])->name('saved-jobs.index');
    Route::post('/jobs/save', [JobSeekerJobController::class, 'saveJob'])->name('jobs.save');
    Route::delete('/jobs/unsave/{id}', [JobSeekerJobController::class, 'unsaveJob'])->name('jobs.unsave');
    Route::post('/jobs/toggle-save', [JobSeekerJobController::class, 'toggleSave'])->name('jobs.toggle-save');
    Route::put('/saved-jobs/{id}', [JobSeekerJobController::class, 'updateSavedJob'])->name('saved-jobs.update');
    Route::get('/jobs/saved-status/{jobPostId}', [JobSeekerJobController::class, 'checkSavedStatus'])->name('jobs.saved-status');

    // Job Applications
    Route::get('/job/{id}/apply', [JobSeekerJobController::class, 'showApplyForm'])->name('job.apply.form');
    Route::post('/job/apply', [JobSeekerJobController::class, 'applyJob'])->name('job.apply');
    Route::post('/job/quick-apply', [JobSeekerJobController::class, 'quickApply'])->name('job.quick-apply');
    Route::get('/my-applications', [JobSeekerJobController::class, 'getMyApplications'])->name('my-applications');
    Route::post('/application/{id}/withdraw', [JobSeekerJobController::class, 'withdrawApplication'])->name('application.withdraw');
    Route::get('/application/status/{jobPostId}', [JobSeekerJobController::class, 'getApplicationStatus'])->name('application.status');

    // Employer Profiles
    Route::get('/employers', [JobSeekerEmployerController::class, 'index'])->name('employers.index');
    Route::get('/employers/{id}', [JobSeekerEmployerController::class, 'show'])->name('employers.show');
    Route::get('/employers/featured', [JobSeekerEmployerController::class, 'featured'])->name('employers.featured');
    Route::get('/employers/{id}/jobs', [JobSeekerEmployerController::class, 'employerJobs'])->name('employers.jobs');

    // CV Management
    Route::prefix('cv')->name('cv.')->group(function () {
        Route::get('builder', [CvController::class, 'builder'])->name('builder');
        Route::post('preview', [CvController::class, 'preview'])->name('preview');
        Route::post('download', [CvController::class, 'download'])->name('download');
        Route::get('download-html/{id}', [CvController::class, 'downloadHtml'])->name('download-html');
        Route::post('save', [CvController::class, 'save'])->name('save');
        Route::get('show/{id}', [CvController::class, 'show'])->name('show');
        Route::delete('delete/{id}', [CvController::class, 'destroy'])->name('destroy');
        Route::get('templates', [CvController::class, 'getTemplates'])->name('templates');
    });

    // ============================================================
    // RESUME MANAGEMENT - Using root ResumeController
    // ============================================================
    Route::prefix('resume')->name('resume.')->group(function () {
        // ✅ DELETE route FIRST to avoid conflicts
        Route::delete('/{id}', [ResumeController::class, 'destroy'])->name('destroy');
        
        // Other routes
        Route::get('/', [ResumeController::class, 'index'])->name('index');
        Route::post('/upload', [ResumeController::class, 'upload'])->name('upload');
        Route::get('/{id}/view', [ResumeController::class, 'view'])->name('view');
        Route::get('/{id}/parse-status', [ResumeController::class, 'parseStatus'])->name('parse-status');
    });
    
    // ============================================================
    // MATCH RESULTS - Using root ResumeController
    // ============================================================
    Route::prefix('matches')->name('matches.')->group(function () {
        Route::get('/', [ResumeController::class, 'myMatches'])->name('index');
        Route::get('/{id}', [ResumeController::class, 'matchDetails'])->name('details');
        Route::get('/job/{jobId}', [ResumeController::class, 'jobMatch'])->name('job');
    });

    // ============================================================
    // NOTIFICATIONS
    // ============================================================
    Route::prefix('notifications')->name('notifications.')->group(function () {
        Route::get('/', [NotificationController::class, 'index'])->name('index');
        Route::get('/latest', [NotificationController::class, 'latest'])->name('latest');
        Route::get('/unread-count', [NotificationController::class, 'unreadCount'])->name('unread-count');
        Route::post('/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('mark-read');
        Route::post('/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('mark-all-read');
        Route::get('/{id}', [NotificationController::class, 'show'])->name('show');
        Route::delete('/{id}', [NotificationController::class, 'destroy'])->name('destroy');
        Route::delete('/read/delete', [NotificationController::class, 'deleteRead'])->name('delete-read');
    });
});

// ============================================================
// ADDITIONAL PUBLIC ROUTES
// ============================================================
Route::get('/search/jobs', [HomeController::class, 'searchJobs'])->name('jobs.search');
Route::get('/categories', [HomeController::class, 'categories'])->name('categories');
Route::get('/faq', [HomeController::class, 'faq'])->name('faq');
Route::get('/terms', [HomeController::class, 'terms'])->name('terms');
Route::get('/privacy', [HomeController::class, 'privacy'])->name('privacy');

Route::post('/zoom/meeting', [ZoomController::class, 'create']);
Route::patch('/zoom/meeting/{id}', [ZoomController::class, 'update']);
Route::delete('/zoom/meeting/{id}', [ZoomController::class, 'delete']);
Route::get('/zoom/meetings', [ZoomController::class, 'list']);