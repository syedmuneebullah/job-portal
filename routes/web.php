<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\HomeController;
use App\Http\Controllers\Auth\User\AuthController;

Route::get('/', [HomeController::class, 'index'])->name('user.home');
Route::get('/swift-ai-recruit', [HomeController::class, 'Landing'])->name('user.landing');
Route::get('/pricing', [HomeController::class, 'Pricing'])->name('user.pricing');
Route::get('/about-us', [HomeController::class, 'about'])->name('user.about');
Route::get('/contact-us', [HomeController::class, 'contact'])->name('user.contact');
Route::get('/jobs/lisitngs', [HomeController::class, 'JobListings'])->name('user.job.listings');
Route::get('/job/details', [HomeController::class, 'JobDetails'])->name('user.job.details');


Route::group(['prefix' => 'auth'],function(){
   Route::get('user/register',[AuthController::class, 'registerview'])->name('auth.user.register');
   Route::post('user/register/validate',[AuthController::class, 'register'])->name('auth.user.validate');
   Route::get('user/login',[AuthController::class, 'loginview'])->name('auth.user.login');
});
