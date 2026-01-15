<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobTypeController;
use App\Http\Controllers\SkillController;


Route::get('/phpinfo', function () {
    return phpinfo();
})->name('phpinfo');

Route::get('/cache-clear', function () {
    \Artisan::call('cache:clear');
    \Artisan::call('config:clear');
    \Artisan::call('view:clear');
    \Artisan::call('route:clear');

    return redirect()->back()->with('success', 'Cache cleared successfully');
})->name('cache.clear');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'loginCheck'])->name('loginCheck');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/forget-password', [AuthController::class, 'forget'])->name('forget');
Route::get('/new-password', [AuthController::class, 'newPassword'])->name('newpassword');
Route::get('/otp', [AuthController::class, 'otp'])->name('otp');

Route::get('/test', [HomeController::class, 'test'])->name('test');
Route::post('/seo-generator-api', [HomeController::class, 'seoGeneratorAPI'])->name('seo.generator.api');

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/jobs', [HomeController::class, 'alljobView'])->name('alljobView');
Route::get('/detail/{slug}/{job_id}', [HomeController::class, 'jobDetail'])->name('detail');
Route::post('/job-apply', [HomeController::class, 'submitJobApplication'])->name('job.apply');
Route::get('/contact', [HomeController::class, 'contactUs'])->name('contact');
Route::post('/contact', [HomeController::class, 'contactSubmit'])->name('contact.submit');

Route::middleware(['auth'])->group(function () {
    Route::get('/my-profile', [HomeController::class, 'myProfile'])->name('profile.show');
    Route::post('/my-profile', [HomeController::class, 'updateProfile'])->name('profile.update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('profile.changePassword');
});


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::resource('users', UserController::class);
    Route::resource('categories', CategoryController::class)->except(['show']);
    Route::resource('jobs', JobController::class)->except(['show']);
    Route::resource('job-types', JobTypeController::class)->except(['show']);
    Route::resource('skills', SkillController::class)->except(['show']);

});
