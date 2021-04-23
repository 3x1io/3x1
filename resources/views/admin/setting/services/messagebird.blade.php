@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('Link MessageBird'))


@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-directions"></i>
            {{__('Link MessageBird')}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/services/messagebird')}}">
                @csrf
                <img src="{{url('services/messagebird.png')}}" style="width: 20%; margin-right: auto; margin-left: auto; display: block">
                {!! setting_show('messagebird.access_key', __('MessageBird Access Key'), 'text') !!}
                {!! setting_show('messagebird.originator', __('MessageBird Originator'), 'text') !!}
                {!! setting_show('messagebird.recipients', __('MessageBird Recipients'), 'text') !!}
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
