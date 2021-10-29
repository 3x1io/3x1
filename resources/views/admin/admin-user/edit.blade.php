@extends('layouts.form', [
    "module" => false,
    "table" => 'admin-users',
    "data" => $adminUser,
    "edit" => true,
    "create" => false
])

@section('options')
    :activation="!!'{{ $activation }}'"
@endsection
