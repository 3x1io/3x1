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

Route::middleware(['web'])->group(static function () {
    Route::namespace('Brackets\AdminAuth\Http\Controllers\Auth')->group(static function () {
        Route::get('/admin/login', 'LoginController@showLoginForm')->name('brackets/admin-auth::admin/login');
        Route::post('/admin/login', 'LoginController@login');

        Route::any('/admin/logout', 'LoginController@logout')->name('brackets/admin-auth::admin/logout');

        Route::get('/admin/password-reset', 'ForgotPasswordController@showLinkRequestForm')->name('brackets/admin-auth::admin/password/showForgotForm');
        Route::post('/admin/password-reset/send', 'ForgotPasswordController@sendResetLinkEmail');
        Route::get('/admin/password-reset/{token}', 'ResetPasswordController@showResetForm')->name('brackets/admin-auth::admin/password/showResetForm');
        Route::post('/admin/password-reset/reset', 'ResetPasswordController@reset');

        Route::get('/admin/activation/{token}', 'ActivationController@activate')->name('brackets/admin-auth::admin/activation/activate');
    });
});

Route::middleware(['web', 'admin', 'auth:' . config('admin-auth.defaults.guard')])->group(static function () {
    Route::namespace('Brackets\AdminAuth\Http\Controllers')->group(static function () {
        Route::get('/admin', 'AdminHomepageController@index')->name('brackets/admin-auth::admin');
    });
});
