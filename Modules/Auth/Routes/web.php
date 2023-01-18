<?php

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

use Illuminate\Support\Facades\Route;

Route::get('/login', 'AuthController@login');
Route::post('/login', 'AuthController@authenticate');

Route::post('/logout', 'AuthController@logout');

Route::get('/register', 'AuthController@create');
Route::post('/register', 'AuthController@store');

Route::get('email/verify/{id}', 'EmailVerificationController@verify')->name('verification.verify');
Route::get('email/resend', 'EmailVerificationController@resend')->name('verification.resend');
