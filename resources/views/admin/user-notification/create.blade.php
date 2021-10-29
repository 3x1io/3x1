@extends('layouts.form', [
    "module" => false,
    "table" => 'user-notifications',
    "edit" => false,
    "create" => true,
    "hasMedia" => true,
    "modalName" => App\Models\UserNotification::class,
    "collection" => "image"
])
