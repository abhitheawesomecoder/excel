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

Route::get('/', function () {
    //return view('welcome');
    return redirect()->route('login');
});

Auth::routes();

Route::get('/image', 'HomeController@image')->name('image');

Route::get('/home', 'HomeController@index')->name('home');

Route::post('/home', 'HomeController@filter')->name('filter');

Route::get('/upcomingjobs', 'HomeController@getUpcomingJobs')->name('dashboard.upcomingjobs');

Route::get('/completedjobs', 'HomeController@getCompletedJobs')->name('dashboard.completedjobs');

Route::get('/upcomingtasks', 'HomeController@getUpcomingTasks')->name('dashboard.upcomingtasks');
