@extends('layouts.app', [
    "module" => false,
    "table" => 'areas',
    "create" => true,
    "export" => true,
    "fields" => [
        "name",
        "city_id",
        "lang",
        "lat",
    ]
])

@section('tableList')
    <td >@{{ item.id }}</td>
    <td>@{{ item.name }}</td>
    <td>@{{ item.city_id }}</td>
    <td>@{{ item.lang }}</td>
    <td>@{{ item.lat }}</td>
@endsection
