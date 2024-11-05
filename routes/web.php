<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminDashboardController;


Route::get('/',[FrontController::class,'home'])->name('home');
Route::get('/about',[FrontController::class,'about'])->name('about');
Route::get('/registration',[FrontController::class,'registration'])->name('registration');
Route::post('/registration',[FrontController::class,'registration_submit'])->name('registration_submit');
Route::get('/registration-verify-email/{email}/{token}',[FrontController::class,'registration_verify'])->name('registration_verify');
Route::get('/login',[FrontController::class,'login'])->name('login');
Route::post('/login',[FrontController::class,'login_submit'])->name('login_submit');
Route::get('/forget-password',[FrontController::class,'forget_password'])->name('forget_password');


// User

Route::middleware('auth')->prefix('user')->group(function () {
    Route::get('/dashboard',[UserController::class,'dashboard'])->name('user_dashboard');
    Route::get('/logout',[UserController::class,'logout'])->name('logout');


});



// Admin

Route::middleware('admin')->prefix('admin')->group(function () {
    
    Route::get('/dashboard',[AdminDashboardController::class,'dashboard'])->name('admin_dashboard');
    Route::get('/profile',[AdminAuthController::class,'profile'])->name('admin_profile');
    Route::post('/profile',[AdminAuthController::class,'profile_submit'])->name('admin_profile_submit');

    Route::get('logout',[AdminAuthController::class,'logout'])->name('admin_logout');


});
Route::prefix('admin')->group(function () {
    Route::get('/', function () {return redirect('/admin/login');});
    Route::get('/login',[AdminAuthController::class,'login'])->name('admin_login');
    Route::post('/login',[AdminAuthController::class,'login_submit'])->name('admin_login_submit');
    Route::get('/logout',[AdminAuthController::class,'logout'])->name('admin_logout');
    Route::get('/forget-password',[AdminAuthController::class,'forget_password'])->name('admin_forget_password');
    Route::post('/forget_password_submit',[AdminAuthController::class,'forget_password_submit'])->name('admin_forget_password_submit');
    Route::get('/reset-password/{token}/{email}',[AdminAuthController::class,'reset_password'])->name('admin_reset_password');
    Route::post('/reset-password/{token}/{email}',[AdminAuthController::class,'reset_password_submit'])->name('admin_reset_password_submit');
});


