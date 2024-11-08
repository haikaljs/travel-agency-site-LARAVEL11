<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\Front\FrontController;
use App\Http\Controllers\Admin\AdminAuthController;
use App\Http\Controllers\Admin\AdminSliderController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminWelcomeItemController;



// User (auth)

Route::get('/',[FrontController::class,'home'])->name('home');

Route::get('/about',[FrontController::class,'about'])->name('about');

Route::get('/registration',[FrontController::class,'registration'])->name('registration');

Route::post('/registration',[FrontController::class,'registration_submit'])->name('registration_submit');

Route::get('/registration-verify-email/{email}/{token}',[FrontController::class,'registration_verify'])->name('registration_verify');

Route::get('/login',[FrontController::class,'login'])->name('login');

Route::post('/login',[FrontController::class,'login_submit'])->name('login_submit');
Route::get('/forget-password',[FrontController::class,'forget_password'])->name('forget_password');

Route::post('/forget-password',[FrontController::class,'forget_password_submit'])->name('forget_password_submit');

Route::get('/reset-password/{token}/{email}',[FrontController::class,'reset_password'])->name('reset_password');

Route::post('/reset-password/{token}/{email}',[FrontController::class,'reset_password_submit'])->name('reset_password_submit');


// User

Route::middleware('auth')->prefix('user')->group(function () {

    Route::get('/dashboard',[UserController::class,'dashboard'])->name('user_dashboard');

    Route::get('/logout',[FrontController::class,'logout'])->name('logout');
    Route::get('/profile',[UserController::class,'profile'])->name('user_profile');
    Route::post('/profile',[UserController::class,'profile_submit'])->name('user_profile_submit');
});



// Admin

Route::middleware('admin')->prefix('admin')->group(function () {
    
    Route::get('/dashboard',[AdminDashboardController::class,'dashboard'])->name('admin_dashboard');
    Route::get('/profile',[AdminAuthController::class,'profile'])->name('admin_profile');
    Route::post('/profile',[AdminAuthController::class,'profile_submit'])->name('admin_profile_submit');

    Route::get('/slider/index',[AdminSliderController::class,'index'])->name('admin_slider_index');
    Route::get('/slider/create',[AdminSliderController::class,'create'])->name('admin_slider_create');
    Route::post('/slider/store',[AdminSliderController::class,'store'])->name('admin_slider_store');
    Route::get('/slider/edit/{id}',[AdminSliderController::class,'edit'])->name('admin_slider_edit');
    Route::post('/slider/update/{id}',[AdminSliderController::class,'update'])->name('admin_slider_update');
    Route::get('/slider/delete/{id}',[AdminSliderController::class,'delete'])->name('admin_slider_delete');


    Route::get('/welcome-item/index',[AdminWelcomeItemController::class,'index'])->name('admin_welcome_item_index');

    Route::post('/welcome-item/update/{id}',[AdminWelcomeItemController::class,'update'])->name('admin_welcome_item_update');




    Route::get('logout',[AdminAuthController::class,'logout'])->name('admin_logout');


});

// Admin (auth)

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


