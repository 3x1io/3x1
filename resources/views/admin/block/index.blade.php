@extends('layouts.app', [
    "module" => false,
    "table" => 'blocks',
    "create" => true,
    "export" => true,
    "fields" => [
        "key",
    ]
])

@section('tableList')
    <td>@{{ item.id }}</td>
    <td>@{{ item.key }}</td>
@endsection
