<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/admin/login','Authentication\AdminController@login');
Route::post('/admin/register','Authentication\AdminController@register');
Route::middleware(['auth:admin','adminTokenValidate'])->group(function () {
    Route::get('/admin/logout','Authentication\AdminController@logout');
});


Route::post('/teacher/login','Authentication\TeacherController@login');
Route::post('/teacher/register','Authentication\TeacherController@register');
Route::middleware(['auth:teacher','teacherTokenValidate'])->group(function () {
    Route::get('/teacher/logout','Authentication\TeacherController@logout');
});

Route::post('/student/login','Authentication\StudentController@login');
Route::post('/student/register','Authentication\StudentController@register');
Route::middleware(['auth:student','studentTokenValidate'])->group(function () {
    Route::get('/student/logout','Authentication\StudentController@logout');
});

Route::post('/parent/login','Authentication\PhuhuynhController@login');
Route::post('/parent/register','Authentication\PhuhuynhController@register');
Route::middleware(['auth:phuhuynh','phuhuynhTokenValidate'])->group(function () {
    Route::get('/parent/logout','Authentication\PhuhuynhController@logout');
});

Route::post('/system/login','Authentication\LoginController@login');

// -----------------------------------------07/12----------------------------------------
Route::middleware(['auth:admin','adminTokenValidate'])->group(function () {
    
    Route::get('/admin/teacher/getall/','AccountManage\TeacherManageController@getAllUser');
    // Route::get('/admin/teacher/total','AccountManage\TeacherManageController@getTotalTeacher');
    // Route::post('/admin/teacher','AccountManage\TeacherManageController@store');
    Route::put('/admin/teacher/update/{id}','AccountManage\TeacherManageController@update');
    Route::delete('/admin/teacher/{id}','AccountManage\TeacherManageController@delete');
    Route::get('/admin/teacher/{id}','AccountManage\TeacherManageController@show');
    // Route::post('/admin/teacher/multidelete', 'AccountManage\TeacherManageController@multiDelete');
    Route::post('/admin/teacher/upload/{id}/','AccountManage\TeacherManageController@upload');

    //-------------------------------------------------------------------------- Student
//    Route::get('/teacher','TeacherManageController@index');
    // Route::get('/student','AccountManage\StudentManageController@getTotalStudent');
    Route::get('/admin/student/getall/','AccountManage\StudentManageController@getAllStudent');
    // Route::post('/student','AccountManage\StudentManageController@store');
    Route::put('/admin/student/update/{id}','AccountManage\StudentManageController@update');
    Route::delete('/admin/student/{id}','AccountManage\StudentManageController@delete');
    Route::get('/admin/student/{id}','AccountManage\StudentManageController@show');
    // Route::post('/student/delete', 'AccountManage\StudentManageController@multiDelete');
    Route::post('/admin/student/upload/{id}/','AccountManage\StudentManageController@upload');


    //--------------------------------------------------------------------------Class $ Grade $student
    Route::get('/admin/grade/getall/','AccountManage\ClassManageController@getAllGrade');
    Route::get('/admin/grade/{id}/','AccountManage\ClassManageController@getClass'); 
    // Route::get('/admin/class/in/grade/getall/{id}/','AccountManage\ClassManageController@getAllClassinGrade');
    Route::post('/admin/class/upload/{id}','AccountManage\ClassManageController@store');
    Route::delete('/admin/class/delete/{id}','AccountManage\ClassManageController@delete');

    Route::get('/admin/class/{id}/','AccountManage\ClassManageController@getAllStudent');

    //--------------------------------------------------------------------------Class $ Grade $student
    Route::get('/admin/subject/getall/','AccountManage\ClassManageController@getAllSubject');
    Route::get('/admin/teacher/subject/getall/{id}/','AccountManage\ClassManageController@getAllTeacher'); // get all teacher in a subject

});