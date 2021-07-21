@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Services Settings'))

@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-directions"></i>
            {{__('Services Settings')}}
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{url('services/pusher.png')}}" style="height: 200px; margin-right: auto; margin-left: auto; display: block">
                            <a href="{{url('admin/services/pusher')}}" class="btn btn-primary btn-block"><i class="fa fa-link"></i> {{__('Link')}}</a>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <img src="{{url('services/messagebird.png')}}" style="height: 200px; margin-right: auto; margin-left: auto; display: block">
                            <a href="{{url('admin/services/messagebird')}}" class="btn btn-primary btn-block"><i class="fa fa-link"></i> {{__('Link')}}</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
