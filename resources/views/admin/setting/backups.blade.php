
@extends('layouts.main')

@section('title',__('Email Settings'))

@section('body')
    <x-card title="{{__('Backups [Under Development]')}}" icon="icon  icon-cloud-download">
        <x-slot name="left">
            <form method="POST" action="{{url('admin/backups')}}">
                @csrf
                @method('POST')
                <button class="btn btn-primary"><i class="fa fa-play"></i> {{__('Run Backup')}}</button>
            </form>
        </x-slot>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>{{__('Path')}}</th>
                <th>{{__('Action')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($backups as $key=>$backup)
                <tr>
                    <td>{{$key+1}}</td>
                    <td>{{str_replace(storage_path('app/Laravel') .'/', '', $backup)}}</td>
                    <td>
                        <form method="POST" target="_blank" action="{{url('admin/backups')}}">
                            @csrf
                            @method('POST')
                            <input type="hidden" name="path" value="{{$backup}}">
                            <button type="submit" class="btn btn-primary"><i class="fa fa-download"></i> {{__('Download')}}</button>
                        </form>

                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </x-card>
@endsection
