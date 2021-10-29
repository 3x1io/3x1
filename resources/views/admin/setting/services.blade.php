@extends('layouts.main')

@section('title',__('Services Settings'))

@section('body')
    <x-card title="{{__('Services Settings')}}" icon="icon icon-directions">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <img src="{{url('services/messagebird.png')}}" style="height: 200px; margin-right: auto; margin-left: auto; display: block">
                        <a href="{{url('admin/services/messagebird')}}" class="btn btn-primary btn-block"><i class="fa fa-link"></i> {{__('Link')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </x-card>
@endsection
