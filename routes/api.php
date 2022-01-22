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
    Route::get('/admin/teacher/total/','AccountManage\TeacherManageController@getTotalTeacher');
    // Route::post('/admin/teacher','AccountManage\TeacherManageController@store');
    Route::put('/admin/teacher/update/{id}','AccountManage\TeacherManageController@update');
    Route::delete('/admin/teacher/{id}','AccountManage\TeacherManageController@delete');
    Route::get('/admin/teacher/{id}','AccountManage\TeacherManageController@show');
    // Route::post('/admin/teacher/multidelete', 'AccountManage\TeacherManageController@multiDelete');
    Route::post('/admin/teacher/upload/{id}/','AccountManage\TeacherManageController@upload');

    //-------------------------------------------------------------------------- Student

    Route::get('/admin/student/getall/','AccountManage\StudentManageController@getAllStudent');
    Route::get('/admin/student/total/','AccountManage\StudentManageController@getTotalStudent');
    // Route::post('/student','AccountManage\StudentManageController@store');
    Route::put('/admin/student/update/{id}','AccountManage\StudentManageController@update');
    Route::delete('/admin/student/{id}','AccountManage\StudentManageController@delete');
    Route::get('/admin/student/{id}','AccountManage\StudentManageController@show');
    // Route::post('/student/delete', 'AccountManage\StudentManageController@multiDelete');
    Route::post('/admin/student/upload/{id}/','AccountManage\StudentManageController@upload');


    //--------------------------------------------------------------------------Class $ Grade $student
    Route::get('/admin/grade/getall/','AccountManage\ClassManageController@getAllGrade');
    Route::get('/admin/class/total/','AccountManage\ClassManageController@getTotalClass');
    Route::get('/admin/total/','AccountManage\ClassManageController@getTotalAdmin');
    Route::get('/admin/grade/{id}/','AccountManage\ClassManageController@getClass');
    Route::get('/admin/grade/schoolyear/{schoolyear}/{id}/','AccountManage\ClassManageController@getClassSchoolYear'); 
    Route::post('/admin/class/upload/{id}','AccountManage\ClassManageController@store');
    Route::delete('/admin/class/delete/{id}','AccountManage\ClassManageController@delete');

    Route::get('/admin/class/{id}/','AccountManage\ClassManageController@getAllStudent');

    //--------------------------------------------------------------------------Class $ Grade $student
    Route::get('/admin/subject/getall/','AccountManage\ClassManageController@getAllSubject');
    Route::get('/admin/teacher/subject/getall/{id}/','AccountManage\ClassManageController@getAllTeacher'); // get all teacher in a subject
    //--------------------------------------------------------------------------teacher assignment
    Route::get('/admin/assign/teacher/','AccountManage\ClassManageController@getAllAssign');
    Route::get('/admin/assign/teacher/detail/{id}','AccountManage\ClassManageController@getAssignDetail');
    Route::put('/admin/assign/teacher/update/{id}','AccountManage\ClassManageController@updateAssign');
    //----------------------------------report----------------------------------
    Route::get('/admin/grade/report/{schoolyear}/{id}','AccountManage\ClassManageController@gradeReport'); // ID khoi
    Route::get('/admin/class/report/detail/{id}','AccountManage\ClassManageController@classReport');
    Route::get('/admin/subject/report/detail/{string}/{id}','AccountManage\ClassManageController@subjectReport'); //ID: 10-11-12
    Route::get('/admin/grade/conduct/report/{schoolyear}/{id}','AccountManage\ClassManageController@gradeConductReport'); //ID: khoi
    Route::get('/admin/class/conduct/report/{id}','AccountManage\ClassManageController@classConductReport');
    Route::get('/admin/class/detail/{id}','AccountManage\ClassManageController@getClassDetail');
    Route::put('/admin/class/edit/{id}','AccountManage\ClassManageController@editClass');
});

//--------------------------------------------------------------------------Mark
Route::middleware(['auth:teacher','teacherTokenValidate'])->group(function (){
    Route::get('/teacher/detail/{id}','AccountManage\TeacherManageController@teacherDetail');
    Route::put('/teacher/update/password/{id}','AccountManage\TeacherManageController@updatePassword');
    Route::get('/teacher/class/subject/getall/{id}','MarkManagement\MarkManageController@getSubjectClass');
    Route::get('/teacher/class/subject/detail/{semester}/{id}','MarkManagement\MarkManageController@getmarkDetail'); // id: subject
    Route::get('/teacher/class/{id}','MarkManagement\MarkManageController@Getclass'); //id: ID cua giao vien khi dang nhap
    Route::get('/teacher/mark/','MarkManagement\MarkManageController@GetAlllMark'); // tra ve diem hoc sinh
    Route::get('/teacher/conduct/{id}','MarkManagement\MarkManageController@GetConduct'); //id: Id cua lop hoc
    Route::get('/teacher/conduct/detail/{id}','MarkManagement\MarkManageController@getConductDetail');
    Route::put('/teacher/conduct/update/{id}','MarkManagement\MarkManageController@updateConduct');
    Route::get('/teacher/mark/detail/{id}','MarkManagement\MarkManageController@showMark');
    Route::put('/teacher/mark/update/{id}','MarkManagement\MarkManageController@updateMark'); //ID: type
    Route::get('/teacher/type/{id}','MarkManagement\MarkManageController@GetMark');
    Route::get('/head/teacher/getall/class/{id}','MarkManagement\MarkManageController@getAllClassfromHead'); // get all class from head teacher
    Route::get('/head/teacher/getall/student/{id}','MarkManagement\MarkManageController@getAllStudentfromHead'); // get all student from head teacher
    Route::get('/teacher/mark/getall/{id}/semester/{id_semester1}','AccountManage\ClassManageController@getMarkStudent1'); // semester:1
    Route::get('/teacher/mark/getall/{id}/semester/{id_semester2}','AccountManage\ClassManageController@getMarkStudent2'); // semester:2
    Route::get('teacher/student/{id}','AccountManage\StudentManageController@show');
    Route::get('/teacher/student/{id}','AccountManage\StudentManageController@show');
    Route::get('/teacher/conduct/getall/{id}','AccountManage\ClassManageController@getConductStudent');
    Route::get('/teacher/class/report/{id}','AccountManage\ClassManageController@classReport'); // ID: class
    

    
});
Route::middleware(['auth:student','studentTokenValidate'])->group(function (){
    Route::get('/student/detail/{id}','AccountManage\StudentManageController@studentDetail');
    Route::put('/student/update/password/{id}','AccountManage\StudentManageController@updatePassword');
    Route::get('/student/class/getall/{id}','AccountManage\ClassManageController@getClassStudent');
    Route::get('/student/mark/getall/{id}/semester/{id_semester1}','AccountManage\ClassManageController@getMarkStudent1'); // semester:1
    Route::get('/student/mark/getall/{id}/semester/{id_semester2}','AccountManage\ClassManageController@getMarkStudent2'); // semester:1
    Route::get('/student/conduct/getall/{id}','AccountManage\ClassManageController@getConductStudent');
});