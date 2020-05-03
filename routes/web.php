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

Route::get('/login', function () {
    return view('login');
});

Route::get('/voting', function () {
  return redirect('login');
});

Route::post('voting', 'VotingController@index');

Route::post('save-position-data/{voterId}', 'VotingController@savePositionData');

Route::get('the-secret-admin-page', 'AdminController@index');
