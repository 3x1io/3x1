@extends('layouts.app', [
    "module" => false,
    "table" => 'roles',
    "create" => true,
    "fields" => [
        "name",
        "guard_name",
    ]
])


@section('tableList')
    <td>@{{ item.id }}</td>
    <td>@{{ item.name }}</td>
    <td>@{{ item.guard_name }}</td>
@endsection
