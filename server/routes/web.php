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

Auth::routes();

Route::get('/', 'HomeController@index')->middleware('auth');
Route::get('/home', 'HomeController@index')->name('home')->middleware('auth');

Route::get('/page/allotments', 'PageController@index')->name('page_allotments')->middleware('auth', 'needRole:distribution');
Route::get('/admin', 'PageController@index')->name('admin')->middleware('auth');
Route::get('/page/hi_discipline/{id}', 'PageController@index')->name('page_hi_discipline')->middleware('auth', 'needRole:distribution');

Route::get('/allotments', 'AllotmentController@getAllotments')->name('allotments')->middleware('auth');
Route::post('/allotments', 'AllotmentController@addAllotment')->name('create_allotment')->middleware('auth', 'needRole:distribution');
Route::post('/allotments/edit', 'AllotmentController@editAllotment')->name('edit_allotment')->middleware('auth', 'needRole:distribution');
Route::post('/allotments/remove', 'AllotmentController@removeAllotment')->name('remove_allotment')->middleware('auth', 'needRole:distribution');
Route::get('/allotments/get_allotment', 'AllotmentController@getAllotment')->name('get_allotment')->middleware('auth');
Route::post('/allotments/load_allotment', 'AllotmentController@parseFile')->name('load_allotment')->middleware('auth', 'needRole:distribution');
Route::post('/allotments/download_allotment', 'AllotmentController@downloadFile')->name('download_allotment')->middleware('auth', 'needRole:distribution');
Route::get('/allotments/automatic', 'AutomaticDistributionController@distribution')->name('automatic_distribution')->middleware('auth', 'needRole:distribution');
Route::get('/allotments/check', 'AutomaticDistributionController@checkAllotment')->name('check_allotment')->middleware('auth', 'needRole:distribution');

Route::get('/workers/get_workers', 'WorkersController@getWorkers')->name('get_workers')->middleware('auth');

Route::get('/hi_discipline/get_disciplines', 'HiDisciplineController@getDisciplines')->middleware('auth', 'needRole:distribution');
Route::get('/hi_discipline/get_groups', 'HiDisciplineController@getGroups')->middleware('auth', 'needRole:distribution');
Route::get('/hi_discipline/get_load_elements', 'HiDisciplineController@getLoadElements')->middleware('auth', 'needRole:distribution');
Route::get('/hi_discipline/get_load_element', 'HiDisciplineController@getLoadElement')->middleware('auth', 'needRole:distribution');
Route::post('/hi_discipline/set_worker_group', 'HiDisciplineController@setWorkerGroup')->middleware('auth', 'needRole:distribution');
Route::post('/hi_discipline/set_worker_discipline', 'HiDisciplineController@setWorkerDiscipline')->middleware('auth', 'needRole:distribution');

Route::get('/flows/get_flows', 'FlowsController@getFlows')->name('get_flows')->middleware('auth');

Route::get('/classrooms/get_classrooms', 'ClassroomsController@getClassrooms')->name('get_classrooms')->middleware('auth');

Route::post('/load_elements/set_load_element', 'LoadElementController@setLoadElement')->name('set_load_element')->middleware('auth', 'needRole:distribution');
Route::post('/load_elements/set_worker', 'LoadElementController@setWorker')->name('set_worker')->middleware('auth', 'needRole:distribution');

Route::get('/admin/user', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/building', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/classroom', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/worker', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/discipline', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/faculty', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/flow', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/group', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/position', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/qualification', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/requirement_fgos', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/roles', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/specialty', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/type_class', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/degrees_worker', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/position_worker', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/rate_worker', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/staff_worker', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/trained_worker', 'PageController@index')->middleware('auth', 'needRole:admin');
Route::get('/admin/coef', 'PageController@index')->middleware('auth', 'needRole:admin');

Route::get('/admin/roles/get', 'AdminController@getRoles')->middleware('auth', 'needRole:admin');
Route::post('/admin/roles/create', 'AdminController@createRole')->middleware('auth', 'needRole:admin');
Route::post('/admin/roles/edit', 'AdminController@editRole')->middleware('auth', 'needRole:admin');
Route::post('/admin/roles/remove', 'AdminController@removeRole')->middleware('auth', 'needRole:admin');

Route::get('/admin/type_class/get', 'AdminController@getTypeClass')->middleware('auth', 'needRole:admin');
Route::post('/admin/type_class/create', 'AdminController@createTypeClass')->middleware('auth', 'needRole:admin');
Route::post('/admin/type_class/edit', 'AdminController@editTypeClass')->middleware('auth', 'needRole:admin');
Route::post('/admin/type_class/remove', 'AdminController@removeTypeClass')->middleware('auth', 'needRole:admin');

Route::get('/admin/qualification/get', 'AdminController@getQualification')->middleware('auth', 'needRole:admin');
Route::post('/admin/qualification/create', 'AdminController@createQualification')->middleware('auth', 'needRole:admin');
Route::post('/admin/qualification/edit', 'AdminController@editQualification')->middleware('auth', 'needRole:admin');
Route::post('/admin/qualification/remove', 'AdminController@removeQualification')->middleware('auth', 'needRole:admin');

Route::get('/admin/position/get', 'AdminController@getPosition')->middleware('auth', 'needRole:admin');
Route::post('/admin/position/create', 'AdminController@createPosition')->middleware('auth', 'needRole:admin');
Route::post('/admin/position/edit', 'AdminController@editPosition')->middleware('auth', 'needRole:admin');
Route::post('/admin/position/remove', 'AdminController@removePosition')->middleware('auth', 'needRole:admin');

Route::get('/admin/faculty/get', 'AdminController@getFaculty')->middleware('auth', 'needRole:admin');
Route::post('/admin/faculty/create', 'AdminController@createFaculty')->middleware('auth', 'needRole:admin');
Route::post('/admin/faculty/edit', 'AdminController@editFaculty')->middleware('auth', 'needRole:admin');
Route::post('/admin/faculty/remove', 'AdminController@removeFaculty')->middleware('auth', 'needRole:admin');

Route::get('/admin/discipline/get', 'AdminController@getDiscipline')->middleware('auth', 'needRole:admin');
Route::post('/admin/discipline/create', 'AdminController@createDiscipline')->middleware('auth', 'needRole:admin');
Route::post('/admin/discipline/edit', 'AdminController@editDiscipline')->middleware('auth', 'needRole:admin');
Route::post('/admin/discipline/remove', 'AdminController@removeDiscipline')->middleware('auth', 'needRole:admin');

Route::get('/admin/building/get', 'AdminController@getBuilding')->middleware('auth', 'needRole:admin');
Route::post('/admin/building/create', 'AdminController@createBuilding')->middleware('auth', 'needRole:admin');
Route::post('/admin/building/edit', 'AdminController@editBuilding')->middleware('auth', 'needRole:admin');
Route::post('/admin/building/remove', 'AdminController@removeBuilding')->middleware('auth', 'needRole:admin');

Route::get('/admin/classroom/get', 'AdminController@getClassroom')->middleware('auth', 'needRole:admin');
Route::post('/admin/classroom/create', 'AdminController@createClassroom')->middleware('auth', 'needRole:admin');
Route::post('/admin/classroom/edit', 'AdminController@editClassroom')->middleware('auth', 'needRole:admin');
Route::post('/admin/classroom/remove', 'AdminController@removeClassroom')->middleware('auth', 'needRole:admin');

Route::get('/admin/specialty/get', 'AdminController@getSpecialty')->middleware('auth', 'needRole:admin');
Route::post('/admin/specialty/create', 'AdminController@createSpecialty')->middleware('auth', 'needRole:admin');
Route::post('/admin/specialty/edit', 'AdminController@editSpecialty')->middleware('auth', 'needRole:admin');
Route::post('/admin/specialty/remove', 'AdminController@removeSpecialty')->middleware('auth', 'needRole:admin');

Route::get('/admin/requirement_fgos/get', 'AdminController@getRequirementFgos')->middleware('auth', 'needRole:admin');
Route::post('/admin/requirement_fgos/create', 'AdminController@createRequirementFgos')->middleware('auth', 'needRole:admin');
Route::post('/admin/requirement_fgos/edit', 'AdminController@editRequirementFgos')->middleware('auth', 'needRole:admin');
Route::post('/admin/requirement_fgos/remove', 'AdminController@removeRequirementFgos')->middleware('auth', 'needRole:admin');

Route::get('/admin/group/get', 'AdminController@getGroup')->middleware('auth', 'needRole:admin');
Route::post('/admin/group/create', 'AdminController@createGroup')->middleware('auth', 'needRole:admin');
Route::post('/admin/group/edit', 'AdminController@editGroup')->middleware('auth', 'needRole:admin');
Route::post('/admin/group/remove', 'AdminController@removeGroup')->middleware('auth', 'needRole:admin');

Route::get('/admin/flow/get', 'AdminController@getFlow')->middleware('auth', 'needRole:admin');
Route::post('/admin/flow/create', 'AdminController@createFlow')->middleware('auth', 'needRole:admin');
Route::post('/admin/flow/edit', 'AdminController@editFlow')->middleware('auth', 'needRole:admin');
Route::post('/admin/flow/remove', 'AdminController@removeFlow')->middleware('auth', 'needRole:admin');

Route::get('/admin/user/get', 'AdminController@getUser')->middleware('auth', 'needRole:admin');
Route::post('/admin/user/edit', 'AdminController@editUser')->middleware('auth', 'needRole:admin');

Route::get('/admin/worker/get', 'AdminController@getWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/worker/create', 'AdminController@createWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/worker/edit', 'AdminController@editWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/worker/remove', 'AdminController@removeWorker')->middleware('auth', 'needRole:admin');

Route::get('/admin/degrees_worker/get', 'AdminController@getDegreesWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/degrees_worker/edit', 'AdminController@editDegreesWorker')->middleware('auth', 'needRole:admin');

Route::get('/admin/position_worker/get', 'AdminController@getPositionWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/position_worker/edit', 'AdminController@editPositionWorker')->middleware('auth', 'needRole:admin');

Route::get('/admin/rate_worker/get', 'AdminController@getRateWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/rate_worker/edit', 'AdminController@editRateWorker')->middleware('auth', 'needRole:admin');

Route::get('/admin/staff_worker/get', 'AdminController@getStaffWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/staff_worker/edit', 'AdminController@editStaffWorker')->middleware('auth', 'needRole:admin');

Route::get('/admin/trained_worker/get', 'AdminController@getTrainedWorker')->middleware('auth', 'needRole:admin');
Route::post('/admin/trained_worker/edit', 'AdminController@editTrainedWorker')->middleware('auth', 'needRole:admin');

Route::post('/admin/coef/clear_old', 'AdminController@clearCoefOld')->middleware('auth', 'needRole:admin');
Route::post('/admin/coef/edit', 'AdminController@setCoef')->middleware('auth', 'needRole:admin');

Route::get('/info/get_workers', 'PageController@getWorkers')->middleware('auth');
Route::get('/info/get_disciplines', 'PageController@getDisciplines')->middleware('auth');
Route::get('/info/get_types_class', 'PageController@getTypesClass')->middleware('auth');
Route::get('/info/get_specialities', 'PageController@getSpecialities')->middleware('auth');
Route::get('/info/get_coef', 'PageController@getCoef')->middleware('auth');

Route::get('/reports/department', 'ReportsController@getDepartmentReport')->middleware('auth');
