

@extends('layouts.app', [
    "module" => false,
    "table" => 'permissions',
    "create" => true,
    "fields" => [
        "name",
        "guard_name",
    ],
    "export" => true,
])


@section('tableList')
    <td>@{{ item.id }}</td>
    <td>@{{ item.name }}</td>
    <td>@{{ item.guard_name }}</td>
@endsection
