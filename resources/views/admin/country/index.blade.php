
@extends('layouts.app', [
    "module" => false,
    "table" => 'countries',
    "create" => false,
    "export" => true,
    "fields" => [
        "name",
        "code",
        "code",
        "lat",
        "lang"
    ]
])

@section('tableList')
    <td>@{{ item.id }}</td>
    <td>@{{ item.name }}</td>
    <td>@{{ item.code }}</td>
    <td>@{{ item.phone }}</td>
    <td>@{{ item.lat }}</td>
    <td>@{{ item.lang }}</td>
@endsection
