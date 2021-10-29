@extends('layouts.form', [
    "module" => false,
    "table" => 'admin-users',
    "edit" => false,
    "create" => true
])

@section('options')
    :activation="!!'{{ $activation }}'"
@endsection
