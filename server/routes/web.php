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

Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/page/allotments', 'PageController@index')->name('page_allotments')->middleware('auth');
Route::get('/admin', 'PageController@index')->name('admin')->middleware('auth');
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

Route::get('/admin/users', 'PageController@index')->middleware('auth');
Route::get('/admin/building', 'PageController@index')->middleware('auth');
Route::get('/admin/classroom', 'PageController@index')->middleware('auth');
Route::get('/admin/worker', 'PageController@index')->middleware('auth');
Route::get('/admin/discipline', 'PageController@index')->middleware('auth');
Route::get('/admin/faculty', 'PageController@index')->middleware('auth');
Route::get('/admin/flow', 'PageController@index')->middleware('auth');
Route::get('/admin/group', 'PageController@index')->middleware('auth');
Route::get('/admin/position', 'PageController@index')->middleware('auth');
Route::get('/admin/qualification', 'PageController@index')->middleware('auth');
Route::get('/admin/requirement_fgos', 'PageController@index')->middleware('auth');
Route::get('/admin/roles', 'PageController@index')->middleware('auth');
Route::get('/admin/specialty', 'PageController@index')->middleware('auth');
Route::get('/admin/type_class', 'PageController@index')->middleware('auth');

Route::get('/admin/roles/get', 'AdminController@getRoles')->middleware('auth');
Route::post('/admin/roles/create', 'AdminController@createRole')->middleware('auth');
Route::post('/admin/roles/edit', 'AdminController@editRole')->middleware('auth');
Route::post('/admin/roles/remove', 'AdminController@removeRole')->middleware('auth');

Route::get('/admin/type_class/get', 'AdminController@getTypeClass')->middleware('auth');
Route::post('/admin/type_class/create', 'AdminController@createTypeClass')->middleware('auth');
Route::post('/admin/type_class/edit', 'AdminController@editTypeClass')->middleware('auth');
Route::post('/admin/type_class/remove', 'AdminController@removeTypeClass')->middleware('auth');

Route::get('/admin/qualification/get', 'AdminController@getQualification')->middleware('auth');
Route::post('/admin/qualification/create', 'AdminController@createQualification')->middleware('auth');
Route::post('/admin/qualification/edit', 'AdminController@editQualification')->middleware('auth');
Route::post('/admin/qualification/remove', 'AdminController@removeQualification')->middleware('auth');

Route::get('/admin/position/get', 'AdminController@getPosition')->middleware('auth');
Route::post('/admin/position/create', 'AdminController@createPosition')->middleware('auth');
Route::post('/admin/position/edit', 'AdminController@editPosition')->middleware('auth');
Route::post('/admin/position/remove', 'AdminController@removePosition')->middleware('auth');

Route::get('/admin/faculty/get', 'AdminController@getFaculty')->middleware('auth');
Route::post('/admin/faculty/create', 'AdminController@createFaculty')->middleware('auth');
Route::post('/admin/faculty/edit', 'AdminController@editFaculty')->middleware('auth');
Route::post('/admin/faculty/remove', 'AdminController@removeFaculty')->middleware('auth');

Route::get('/admin/discipline/get', 'AdminController@getDiscipline')->middleware('auth');
Route::post('/admin/discipline/create', 'AdminController@createDiscipline')->middleware('auth');
Route::post('/admin/discipline/edit', 'AdminController@editDiscipline')->middleware('auth');
Route::post('/admin/discipline/remove', 'AdminController@removeDiscipline')->middleware('auth');

Route::get('/admin/building/get', 'AdminController@getBuilding')->middleware('auth');
Route::post('/admin/building/create', 'AdminController@createBuilding')->middleware('auth');
Route::post('/admin/building/edit', 'AdminController@editBuilding')->middleware('auth');
Route::post('/admin/building/remove', 'AdminController@removeBuilding')->middleware('auth');

Route::get('/admin/classroom/get', 'AdminController@getClassroom')->middleware('auth');
Route::post('/admin/classroom/create', 'AdminController@createClassroom')->middleware('auth');
Route::post('/admin/classroom/edit', 'AdminController@editClassroom')->middleware('auth');
Route::post('/admin/classroom/remove', 'AdminController@removeClassroom')->middleware('auth');

Route::get('/admin/specialty/get', 'AdminController@getSpecialty')->middleware('auth');
Route::post('/admin/specialty/create', 'AdminController@createSpecialty')->middleware('auth');
Route::post('/admin/specialty/edit', 'AdminController@editSpecialty')->middleware('auth');
Route::post('/admin/specialty/remove', 'AdminController@removeSpecialty')->middleware('auth');