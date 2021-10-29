@extends('layouts.form', [
    "module" => false,
    "table" => 'roles',
    "data" => $role,
    "edit" => true,
    "create" => false
])

@section('options')
    :permissions="{{$permissions->toJson()}}"
@endsection
