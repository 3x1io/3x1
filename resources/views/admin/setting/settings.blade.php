@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('General Settings'))

@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-settings"></i>
            {{__('General Settings')}}
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/helpers/settings')}}" enctype="multipart/form-data">
                @csrf
                @method('POST')
                {!! setting_show('site.logo', __('Site Logo'), 'image') !!}
                {!! setting_show('site.name', __('Site Name'), 'text') !!}
                {!! setting_show('site.description', __('Site Description'), 'textarea') !!}
                {!! setting_show('site.keywords', __('Site Keywords'), 'textarea') !!}
                <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>
            </form>
        </div>
    </div>


@endsection

@section('bottom-scripts')
    @include('sweetalert::alert')
@endsection
