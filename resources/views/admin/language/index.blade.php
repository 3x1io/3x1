@extends('layouts.app', [
    "module" => false,
    "table" => 'languages',
    "create" => true,
    "export" => true,
    "fields" => [
        "name",
        "iso",
        "arabic"
    ]
])

@section('tableList')
    <td >@{{ item.id }}</td>
    <td>@{{ item.name }}</td>
    <td>@{{ item.iso }}</td>
    <td>@{{ item.arabic }}</td>
@endsection
