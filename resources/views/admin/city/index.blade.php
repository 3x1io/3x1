
@extends('layouts.app', [
    "module" => false,
    "table" => 'cities',
    "create" => false,
    "export" => true,
    "fields" => [
        "name",
        "price",
        "country_id",
        "lang",
        "lat"
    ]
])

@section('tableList')
    <td>@{{ item.id }}</td>
    <td>@{{ item.name }}</td>
    <td>{!! list_fn('money', 'price', ["bg" => "success"]) !!}</td>
    <td>@{{ item.country_id }}</td>
    <td>@{{ item.lang }}</td>
    <td>@{{ item.lat }}</td>
@endsection
