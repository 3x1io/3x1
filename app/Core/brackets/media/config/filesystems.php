<?php

return [
    'media' => [
        'driver' => 'local',
        'root'   => public_path().'/media',
        'url'   => env('APP_URL').'/media',
    ],

    'media_private' => [
        'driver' => 'local',
        'root'   => storage_path().'/app/media',
    ],

    'uploads' => [
        'driver' => 'local',
        'root'   => storage_path('uploads'),
    ],
];
