<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;


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


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin', 'dev'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('helpers')->name('helpers/')->group(static function() {
            Route::post('/settings',                                             'HelperController@settings')->name('settings');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin', 'dev'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/settings',                                             'HelperController@setting')->name('setting');
        Route::get('/payment',                                             'HelperController@payment')->name('payment');
        Route::post('/payment',                                             'HelperController@savePayment')->name('save-payment');
        Route::get('/email',                                             'HelperController@email')->name('email');
        Route::post('/email',                                             'HelperController@saveEmail')->name('save-email');
        Route::get('/services',                                             'HelperController@services')->name('services');
        Route::get('/services/pusher',                                             'HelperController@pusher')->name('pusher');
        Route::post('/services/pusher',                                             'HelperController@savePusher')->name('save-pusher');
        Route::get('/services/messagebird',                                             'HelperController@messagebird')->name('messagebird');
        Route::post('/services/messagebird',                                             'HelperController@saveMessagebird')->name('save-messagebird');
        Route::get('/collector/olx',                                             'HelperController@collectorOLX')->name('collector-olx');
        Route::get('/collector/haraj',                                             'HelperController@collectorHaraj')->name('collector-haraj');
    });
});





