@extends('layouts.form', [
    "module" => false,
    "table" => 'roles',
    "edit" => false,
    "create" => true
])

@section('options')
    :permissions="{{$permissions->toJson()}}"
@endsection
