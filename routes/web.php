<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
  return view('home');
});



Route::prefix('auth')->group(function () {
  Route::get('init', 'LoginController@init');

  Route::post('login', 'LoginController@login');
  Route::post('logout', 'LoginController@logout');
  Route::post('register', 'RegisterController@register');
  Route::post('forgot-password', 'ForgotPasswordController@forgot');
  Route::put('reset-password/{hash}', 'ResetPasswordController@reset');
  Route::post('resend-email-confirmation', 'ResendEmailController@send');
  Route::put('confirm-email/{hash}', 'ConfirmEmailController@confirm');
});

Route::middleware(['auth', 'teacher'])->group(function () {
  Route::get('/videos', 'VideoController@userVideos');
  Route::post('/videos', 'VideoController@store');
  Route::put('/videos/{id}', 'VideoController@edit');
  Route::delete('/videos/{id}', 'VideoController@destroy');

  Route::get('/users', 'UserController@index');
});

Route::get('/videos/watch', 'VideoController@index')->middleware(['auth']);
