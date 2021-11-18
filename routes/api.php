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
Route::post('/user/login','Authentication\UserController@login');
Route::post('/user/register','Authentication\UserController@register');
Route::middleware(['auth:user','userTokenValidate'])->group(function () {
    Route::get('/user/logout','Authentication\UserController@logout');
});

