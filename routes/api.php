<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


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

Route::post('/student/register','Authentication\StudentController@register');
Route::middleware(['auth:student','studentTokenValidate'])->group(function () {
    Route::get('/student/logout','Authentication\StudentController@logout');
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
    Route::post('/admin/class/upload/{id}','AccountManage\ClassManageController@store');
    Route::delete('/admin/class/delete/{id}','AccountManage\ClassManageController@delete');

    Route::get('/admin/class/{id}/','AccountManage\ClassManageController@getAllStudent');

    //--------------------------------------------------------------------------Class $ Grade $student
    Route::get('/admin/subject/getall/','AccountManage\ClassManageController@getAllSubject');
    Route::get('/admin/teacher/subject/getall/{id}/','AccountManage\ClassManageController@getAllTeacher'); // get all teacher in a subject
    //--------------------------------------------------------------------------teacher assignment
    Route::get('/admin/assign/teacher/','AccountManage\ClassManageController@getAllAssign');
    Route::get('/admin/assign/teacher/getall','AccountManage\ClassManageController@getAllAssign');
});

//--------------------------------------------------------------------------Mark
Route::middleware(['auth:teacher','teacherTokenValidate'])->group(function (){
    Route::get('/teacher/class/subject/getall/{id}','MarkManagement\MarkManageController@getSubjectClass');
    Route::get('/teacher/class/subject/detail/{id}','MarkManagement\MarkManageController@getmarkDetail'); // id: Lop
    Route::get('/head/teacher/class/{id}','MarkManagement\MarkManageController@Getclass'); //id: ID cua giao vien khi dang nhap
    Route::get('/head/teacher/mark/','MarkManagement\MarkManageController@GetAlllMark'); // tra ve diem hoc sinh
    Route::get('/teacher/conduct/{id}','MarkManagement\MarkManageController@GetConduct'); //id: Id cua lop hoc
    Route::get('/teacher/conduct/detail/{id}','MarkManagement\MarkManageController@getConductDetail');
    Route::put('/teacher/conduct/update/{id}','MarkManagement\MarkManageController@updateConduct');
    Route::get('/teacher/mark/detail/{id}','MarkManagement\MarkManageController@showMark');
    Route::put('/teacher/mark/update/{id}','MarkManagement\MarkManageController@updateMark'); //ID: type
    Route::get('/head/teacher/type/{id}','MarkManagement\MarkManageController@GetMark');

});