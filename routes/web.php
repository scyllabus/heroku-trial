<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/
Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');

//Account routes...
Route::get('/account/{user}', 'AccountController@index');

//Instructor routes...

//Instructor classrooms...
Route::get('/instructor/{user}/classrooms','InstructorClassroomsController@index');
Route::post('/instructor/{user}/classrooms','InstructorClassroomsController@store');
Route::get('/instructor/{user}/classrooms/{classroom}', 'InstructorClassroomsController@show');
Route::patch('/instructor/{user}/classrooms/{classroom}', 'InstructorClassroomsController@update');
Route::patch('/instructor/{user}/classrooms/{classroom}/students/{student}', 'InstructorClassroomStudentsController@update');
Route::delete('/instructor/{user}/classrooms/{classroom}/students/{student}', 'InstructorClassroomStudentsController@destroy');


//Instructor courses...
Route::get('/instructor/{user}/courses','InstructorCoursesController@index');
Route::post('/instructor/{user}/courses','InstructorCoursesController@store');
Route::patch('/instructor/{user}/courses/{course}', 'InstructorCoursesController@update');

//Instructor lessons...
Route::get('/instructor/{user}/courses/{course}/lessons', 'InstructorCourseLessonsController@index');
Route::post('/instructor/{user}/courses/{course}/lessons', 'InstructorCourseLessonsController@store');
Route::get('/instructor/{user}/courses/{course}/lessons/{lesson}', 'InstructorCourseLessonsController@show');
Route::patch('/instructor/{user}/courses/{course}/lessons/{lesson}', 'InstructorCourseLessonsController@update');

Route::get('/instructor/{user}/courses/{course}/lessons/{lesson}/activity', 'InstructorLessonActivityController@index');
Route::patch('/instructor/{user}/courses/{course}/lessons/{lesson}/activity', 'InstructorLessonActivityController@update');
Route::post('/instructor/{user}/courses/{course}/lessons/{lesson}/activity/sections', 'InstructorLessonActivityController@store');
Route::delete('/instructor/{user}/courses/{course}/lessons/{lesson}/activity/sections/{section}', 'InstructorLessonActivityController@destroy');

Route::post('/instructor/activitysectionitems','InstructorActivitySectionItemsController@store');
Route::delete('/instructor/activitysectionitems/{{item}}','InstructorActivitySectionItemsController@destroy');
	
//Instructor lesson activity...
//Route::get('/instructor/{user}/courses/{course}/lessons/{lesson}', 'InstructorLessonActivityController@show');

//Sortable route...
Route::post('/sort', '\Rutorika\Sortable\SortableController@sort');
