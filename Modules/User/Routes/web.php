<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| User Module Web Routes
|--------------------------------------------------------------------------
*/

Route::middleware('guest')->group(function () {
    Route::get('/login', 'AuthController@showLoginForm')->name('login');
    Route::post('/login', 'AuthController@login')->name('login.post');
    Route::get('/register', 'AuthController@showRegistrationForm')->name('register');
    Route::post('/register', 'AuthController@register')->name('register.post');
    Route::get('/forgot-password', 'AuthController@showForgotPasswordForm')->name('password.request');
    Route::post('/forgot-password', 'AuthController@sendResetLink')->name('password.email');
    Route::get('/reset-password/{token}', 'AuthController@showResetPasswordForm')->name('password.reset');
    Route::post('/reset-password', 'AuthController@resetPassword')->name('password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', 'AuthController@logout')->name('logout');
    Route::get('/profile', 'ProfileController@show')->name('profile.show');
    Route::put('/profile', 'ProfileController@update')->name('profile.update');
    Route::put('/password', 'ProfileController@updatePassword')->name('password.change');
});
