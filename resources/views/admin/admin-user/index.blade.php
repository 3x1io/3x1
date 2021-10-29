@extends('layouts.app', [
    "module" => false,
    "table" => 'admin-users',
    "create" => true,
    "fields" => [
        "first_name",
        "last_name",
        "email",
        "activated",
        "forbidden",
        "language",
        "last_login_at",
    ]
])

@section('listing-urls')
    @if($activation)
        :activation="{{$activation}}"
    @else
        :activation="false"
    @endif

@endsection

@section('tableList')
    <td >@{{ item.id }}</td>
    <td >@{{ item.first_name }}</td>
    <td >@{{ item.last_name }}</td>
    <td>{!! list_fn('email', 'email') !!}</td>
    <td>
        <span v-if="activation">
            {!! list_fn('action', 'activated') !!}
        </span>
        <span>
            {{trans('g.dashboard.not_active')}}
        </span>
    </td>
    <td >
        {!! list_fn('action', 'forbidden', ["bg"=> "danger"]) !!}
    </td>
    <td >@{{ item.language }}</td>
    <td >{!! list_fn('date', 'last_login_at', ["type" => "datetime"]) !!}</td>
@endsection
