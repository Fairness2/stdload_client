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
Route::get('/page/hi_discipline/{id}', 'PageController@index')->name('page_hi_discipline')->middleware('auth');

Route::get('/allotments', 'AllotmentController@getAllotments')->name('allotments')->middleware('auth');
Route::post('/allotments', 'AllotmentController@addAllotment')->name('create_allotment')->middleware('auth');
Route::post('/allotments/edit', 'AllotmentController@editAllotment')->name('edit_allotment')->middleware('auth');
Route::post('/allotments/remove', 'AllotmentController@removeAllotment')->name('remove_allotment')->middleware('auth');
Route::get('/allotments/get_allotment', 'AllotmentController@getAllotment')->name('get_allotment')->middleware('auth');
Route::post('/allotments/load_allotment', 'AllotmentController@parseFile')->name('create_allotment')->middleware('auth');

Route::get('/workers/get_workers', 'WorkersController@getWorkers')->name('get_workers')->middleware('auth');

Route::get('/hi_discipline/get_disciplines', 'HiDisciplineController@getDisciplines')->middleware('auth');
Route::get('/hi_discipline/get_groups', 'HiDisciplineController@getGroups')->middleware('auth');
Route::get('/hi_discipline/get_load_elements', 'HiDisciplineController@getLoadElements')->middleware('auth');
Route::get('/hi_discipline/get_load_element', 'HiDisciplineController@getLoadElement')->middleware('auth');
Route::post('/hi_discipline/set_worker_group', 'HiDisciplineController@setWorkerGroup')->middleware('auth');
Route::post('/hi_discipline/set_worker_discipline', 'HiDisciplineController@setWorkerDiscipline')->middleware('auth');

Route::get('/flows/get_flows', 'FlowsController@getFlows')->name('get_flows')->middleware('auth');

Route::get('/classrooms/get_classrooms', 'ClassroomsController@getClassrooms')->name('get_classrooms')->middleware('auth');

Route::post('/load_elements/set_load_element', 'LoadElementController@setLoadElement')->name('set_load_element')->middleware('auth');
Route::post('/load_elements/set_worker', 'LoadElementController@setWorker')->name('set_worker')->middleware('auth');