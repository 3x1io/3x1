@extends('brackets/admin-ui::admin.layout.default')

@section('title', __('SEO & Sitemap Settings'))


@section('body')

    <div class="card">
        <div class="card-header">
            <i class="icon icon-settings"></i>
            {{__('SEO & Sitemap Settings')}}
            <div class="pull-right">
                <button class="btn btn-primary"><i class="fa fa-map"></i> {{__('Create Sitemap')}}</button>
            </div>
        </div>
        <div class="card-body">
            <form method="POST" action="{{url('admin/sitemap')}}">
                @csrf
                {!! setting_show('site.logo', __('Site Logo'), 'image') !!}
                {!! setting_show('site.name', __('Site Title'), 'text') !!}
                {!! setting_show('site.author', __('Site Author'), 'text') !!}
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
