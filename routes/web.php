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

Route::get('/', function(){
    return view('welcome');
});

try {
    if(setting('themes.name')){
        $path = base_path('routes/themes') . '/' . setting('themes.name') .'.php';
        if(\Illuminate\Support\Facades\File::exists($path)){
            include $path;
        }
    }
    else {
        Route::get('/', function () {
            return view('welcome');
        });
    }
}catch(Exception $exception){}


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
        Route::get('/localization',                                             'HelperController@localization')->name('localization');
        Route::post('/localization',                                             'HelperController@saveLocalization')->name('save-localization');
        Route::get('/themes',                                             'HelperController@themes')->name('themes');
        Route::post('/themes',                                             'HelperController@saveThemes')->name('save-themes');
        Route::get('/themes/active',                                             'HelperController@themeActive')->name('theme-active');
        Route::get('/settings/sitemap',                                             'HelperController@sitemap')->name('sitemap');
        Route::get('/backups',                                             'HelperController@backups')->name('backups');
        Route::post('/backups',                                             'HelperController@saveBackups')->name('saveBackups');
    });
});


Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('admin-users')->name('admin-users/')->group(static function() {
            Route::get('/',                                             'AdminUsersController@index')->name('index');
            Route::get('/create',                                       'AdminUsersController@create')->name('create');
            Route::post('/',                                            'AdminUsersController@store')->name('store');
            Route::get('/{adminUser}/impersonal-login',                 'AdminUsersController@impersonalLogin')->name('impersonal-login');
            Route::get('/{adminUser}/edit',                             'AdminUsersController@edit')->name('edit');
            Route::post('/{adminUser}',                                 'AdminUsersController@update')->name('update');
            Route::delete('/{adminUser}',                               'AdminUsersController@destroy')->name('destroy');
            Route::get('/{adminUser}/resend-activation',                'AdminUsersController@resendActivationEmail')->name('resendActivationEmail');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::get('/profile',                                      'ProfileController@editProfile')->name('edit-profile');
        Route::post('/profile',                                     'ProfileController@updateProfile')->name('update-profile');
        Route::get('/password',                                     'ProfileController@editPassword')->name('edit-password');
        Route::post('/password',                                    'ProfileController@updatePassword')->name('update-password');
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin' ,'dev'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('settings')->name('settings/')->group(static function() {
            Route::get('/dev',                                             'SettingsController@index')->name('index');
            Route::get('/create',                                       'SettingsController@create')->name('create');
            Route::post('/',                                            'SettingsController@store')->name('store');
            Route::get('/{setting}/edit',                               'SettingsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'SettingsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{setting}',                                   'SettingsController@update')->name('update');
            Route::delete('/{setting}',                                 'SettingsController@destroy')->name('destroy');
            Route::get('/export',                                       'SettingsController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin', 'dev'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('roles')->name('roles/')->group(static function() {
            Route::get('/',                                             'RolesController@index')->name('index');
            Route::get('/create',                                       'RolesController@create')->name('create');
            Route::post('/',                                            'RolesController@store')->name('store');
            Route::get('/{role}/edit',                                  'RolesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'RolesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{role}',                                      'RolesController@update')->name('update');
            Route::delete('/{role}',                                    'RolesController@destroy')->name('destroy');
            Route::get('/export',                                       'RolesController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin', 'dev'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('permissions')->name('permissions/')->group(static function() {
            Route::get('/',                                             'PermissionsController@index')->name('index');
            Route::get('/create',                                       'PermissionsController@create')->name('create');
            Route::post('/',                                            'PermissionsController@store')->name('store');
            Route::get('/{permission}/edit',                            'PermissionsController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'PermissionsController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{permission}',                                'PermissionsController@update')->name('update');
            Route::delete('/{permission}',                              'PermissionsController@destroy')->name('destroy');
            Route::get('/export',                                       'PermissionsController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin', 'dev'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('media')->name('media/')->group(static function() {
            Route::get('/',                                             'MediaController@index')->name('index');
            Route::get('/create',                                       'MediaController@create')->name('create');
            Route::post('/',                                            'MediaController@store')->name('store');
            Route::get('/{medium}/edit',                                'MediaController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'MediaController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{medium}',                                    'MediaController@update')->name('update');
            Route::delete('/{medium}',                                  'MediaController@destroy')->name('destroy');
            Route::get('/export',                                       'MediaController@export')->name('export');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('user-notifications')->name('user-notifications/')->group(static function() {
            Route::get('/',                                             'UserNotificationsController@index')->name('index');
            Route::get('/create',                                       'UserNotificationsController@create')->name('create');
            Route::post('/',                                            'UserNotificationsController@store')->name('store');
            Route::get('/{userNotification}/show',                      'UserNotificationsController@show')->name('show');
            Route::post('/bulk-destroy',                                'UserNotificationsController@bulkDestroy')->name('bulk-destroy');
            Route::delete('/{userNotification}',                        'UserNotificationsController@destroy')->name('destroy');
            Route::get('/export',                                       'UserNotificationsController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('location')->name('location/')->group(static function() {
            Route::post('/',                                             'LocationController@index')->name('index');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('countries')->name('countries/')->group(static function() {
            Route::get('/',                                             'CountriesController@index')->name('index');
            Route::get('/create',                                       'CountriesController@create')->name('create');
            Route::post('/',                                            'CountriesController@store')->name('store');
            Route::get('/{country}/edit',                               'CountriesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CountriesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{country}',                                   'CountriesController@update')->name('update');
            Route::delete('/{country}',                                 'CountriesController@destroy')->name('destroy');
            Route::get('/export',                                       'CountriesController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('cities')->name('cities/')->group(static function() {
            Route::get('/',                                             'CitiesController@index')->name('index');
            Route::get('/create',                                       'CitiesController@create')->name('create');
            Route::post('/',                                            'CitiesController@store')->name('store');
            Route::get('/{city}/edit',                                  'CitiesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'CitiesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{city}',                                      'CitiesController@update')->name('update');
            Route::delete('/{city}',                                    'CitiesController@destroy')->name('destroy');
            Route::get('/export',                                       'CitiesController@export')->name('export');
        });
    });
});

/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('areas')->name('areas/')->group(static function() {
            Route::get('/',                                             'AreasController@index')->name('index');
            Route::get('/create',                                       'AreasController@create')->name('create');
            Route::post('/',                                            'AreasController@store')->name('store');
            Route::get('/{area}/edit',                                  'AreasController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'AreasController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{area}',                                      'AreasController@update')->name('update');
            Route::delete('/{area}',                                    'AreasController@destroy')->name('destroy');
            Route::get('/export',                                       'AreasController@export')->name('export');
        });
    });
});


/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('languages')->name('languages/')->group(static function() {
            Route::get('/',                                             'LanguagesController@index')->name('index');
            Route::get('/create',                                       'LanguagesController@create')->name('create');
            Route::post('/',                                            'LanguagesController@store')->name('store');
            Route::get('/{language}/edit',                              'LanguagesController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'LanguagesController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{language}',                                  'LanguagesController@update')->name('update');
            Route::delete('/{language}',                                'LanguagesController@destroy')->name('destroy');
            Route::get('/export',                                       'LanguagesController@export')->name('export');
        });
    });
});







/* Auto-generated admin routes */
Route::middleware(['auth:' . config('admin-auth.defaults.guard'), 'admin'])->group(static function () {
    Route::prefix('admin')->namespace('App\Http\Controllers\Admin')->name('admin/')->group(static function() {
        Route::prefix('blocks')->name('blocks/')->group(static function() {
            Route::get('/',                                             'BlocksController@index')->name('index');
            Route::get('/create',                                       'BlocksController@create')->name('create');
            Route::post('/',                                            'BlocksController@store')->name('store');
            Route::get('/{block}/edit',                                 'BlocksController@edit')->name('edit');
            Route::post('/bulk-destroy',                                'BlocksController@bulkDestroy')->name('bulk-destroy');
            Route::post('/{block}',                                     'BlocksController@update')->name('update');
            Route::delete('/{block}',                                   'BlocksController@destroy')->name('destroy');
            Route::get('/export',                                       'BlocksController@export')->name('export');
        });
    });
});
