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

Route::get('/', 'HomeController@index')->name('home');

Auth::routes();

Route::get('/confirm/{userid}', 'HomeController@confirm_email')->name('confirm');

Route::post('/bid', 'HomeController@placeBid')->name('bid');

Route::get('/registered', function() {
    return redirect('/')->with('status', 'Thank you for registering.  Check your email for instructions on how to confirm your email address so that you may bid.');
});