<?php

Route::middleware(['auth:' . config('admin-auth.defaults.guard')])->group(static function () {
    Route::namespace('Brackets\Media\Http\Controllers')->group(static function () {
        Route::post('upload', 'FileUploadController@upload')->name('brackets/media::upload');
        Route::get('view', 'FileViewController@view')->name('brackets/media::view');
    });
});
