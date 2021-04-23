<?php

Route::middleware(['auth:' . config('admin-auth.defaults.guard')])->group(static function () {
    Route::namespace('Brackets\AdminTranslations\Http\Controllers\Admin')->group(static function () {
        Route::get('/admin/translations', 'TranslationsController@index');
        Route::get('/admin/translations/export', 'TranslationsController@export')->name('admin/translations/export');
        Route::post('/admin/translations/import', 'TranslationsController@import')->name('admin/translations/import');
        Route::post('/admin/translations/import/conflicts', 'TranslationsController@importResolvedConflicts')->name('admin/translations/import/conflicts');
        Route::post('/admin/translations/rescan', 'RescanTranslationsController@rescan');

        Route::post('/admin/translations/{translation}', 'TranslationsController@update');
    });
});