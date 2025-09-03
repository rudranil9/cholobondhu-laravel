<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Module Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', 'HomeController@index')->name('home');
Route::get('/tours', 'TourController@index')->name('tours.index');
Route::get('/tours/{id}', 'TourController@show')->name('tours.show');
Route::get('/about', 'PageController@about')->name('about');
Route::get('/contact', 'FrontendController@contact')->name('contact');
Route::post('/contact', 'ContactController@store')->name('contact.store');


// Login redirect handler
Route::get('/login-redirect', 'FrontendController@loginRedirect')->name('frontend.login.redirect')->middleware('auth');

