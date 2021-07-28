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

Route::get('/', function () {
    return response()->json([
        "success" => true,
        "message" => __('Welcome to 3x1 APIs Framework V1.00'),
        "version" => "1.00",
        "author" => "3x1.io",
        "by" => "Fady Mondy",
        "email" => "info@3x1.io"
    ]);
});

Route::post('/login', 'AuthController@login')->name('login');
Route::post('/register', 'AuthController@register');
Route::post('/forgot', 'AuthController@forgot');
Route::post('/reset', 'AuthController@reset')->name('password.reset');
Route::post('/resend', 'AuthController@resend')->name('verification.resend');
Route::post('/email/verify', 'AuthController@verified')->name('verification.verify');

//User
Route::middleware(['auth:sanctum', 'secret'])->group(function (){
    Route::prefix('user')->name('user')->group(function (){
        Route::get('/','AuthController@user')->name('show');
        Route::post('/','AuthController@update')->name('update');
        Route::post('/password','AuthController@password')->name('password');
    });
    Route::prefix('permissions')->name('permissions')->group(function (){
        Route::get('/','PermissionsController@index')->name('index');
        Route::post('/','PermissionsController@store')->name('store');
        Route::get('/{permission}/show','PermissionsController@show')->name('show');
        Route::put('/{permission}','PermissionsController@update')->name('update');
        Route::delete('/{permission}','PermissionsController@destroy')->name('destroy');
    });
    Route::prefix('roles')->name('roles')->group(function (){
        Route::get('/','RoleController@index')->name('index');
        Route::post('/','RoleController@store')->name('store');
        Route::get('/{role}/show','RoleController@show')->name('show');
        Route::put('/{role}','RoleController@update')->name('update');
        Route::delete('/{role}','RoleController@destroy')->name('destroy');
    });
});
