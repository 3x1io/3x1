@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Link Pusher'))

@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-directions"></i>
            {{__('Link Pusher')}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/services/pusher')}}">
                @csrf
                <img src="{{url('services/pusher.png')}}" style="width: 20%; margin-right: auto; margin-left: auto; display: block">
                {!! setting_show('pusher.app_id', __('Pusher App ID'), 'text') !!}
                {!! setting_show('pusher.key', __('Pusher Key'), 'text') !!}
                {!! setting_show('pusher.secret', __('Pusher Secret'), 'text') !!}
                {!! setting_show('pusher.cluster', __('Pusher Cluster'), 'text') !!}
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>

            </form>
        </div>
    </div>

@endsection

@section('bottom-scripts')
    @include('sweetalert::alert')
@endsection
@section('js')
    <script src="{{ mix('/js/admin.js') }}"></script>
@endsection
