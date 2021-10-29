@extends('layouts.app', [
    "module" => false,
    "table" => 'user-notifications',
    "create" => true,
    "edit" => false,
    "export" => true,
    "fields" => [
        "sender_id",
        "title",
        "icon",
        "url",
        "type",
        "user_id"
    ]
])

@section('tableList')
    <td >@{{ item.id }}</td>
    <td><span v-if="item.sender_id">@{{ item.sender_id.full_name }}</span></td>
    <td>@{{ item.title }}</td>
    <td>@{{ item.icon }}</td>
    <td><a :href="item.url" target="_blank"><i class="fa fa-link"></i> @{{ item.url }}</a> </td>
    <td>@{{ item.type }}</td>
    <td><span v-if="item.user_id">@{{ item.user_id.full_name }}</span></td>

@endsection
