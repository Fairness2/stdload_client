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
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/page/allotments', 'PageController@index')->name('page_allotments')->middleware('auth');

Route::get('/allotments', 'AllotmentController@getAllotments')->name('allotments')->middleware('auth');
Route::post('/allotments', 'AllotmentController@addAllotment')->name('create_allotment')->middleware('auth');
Route::post('/allotments/edit', 'AllotmentController@editAllotment')->name('edit_allotment')->middleware('auth');
Route::post('/allotments/remove', 'AllotmentController@removeAllotment')->name('remove_allotment')->middleware('auth');