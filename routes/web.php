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
  return redirect('login');
});

Route::get('/login', function () {
    return view('login');
});

Route::get('/voting', function () {
  return redirect('login');
});

Route::post('voting', 'VotingController@index');

Route::post('vote-page-poll', 'VotingController@poll');

Route::post('save-position-data/{voterId}', 'VotingController@savePositionData');

Route::get('submit-scores/{voterId}', 'VotingController@submitScores');

Route::get('highlight/{id}', 'AdminController@highlight');

Route::get('remove-highlight', 'AdminController@removeHighlight');

Route::get('reset-vote-data', 'AdminController@resetVoteData');

Route::get('reset-vote-data-confirmation-page', function () {
  return view('reset-vote-data-confirmation-page');
});

Route::get('the-secret-admin-page', 'AdminController@index');

Route::get('export', 'AdminController@export');

Route::get('generate-codes', 'AdminController@generateCodes');
