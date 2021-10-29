@extends('layouts.main')

@section('title',__('General Settings'))

@section('body')
    <x-card title="{{__('General Settings')}}" icon="icon icon-settings">
        <form method="POST" action="{{url('admin/helpers/settings')}}" enctype="multipart/form-data">
            @csrf
            @method('POST')
            {!! setting_show('site.logo', __('Site Logo'), 'image') !!}
            {!! setting_show('site.name', __('Site Name'), 'text') !!}
            {!! setting_show('site.description', __('Site Description'), 'textarea') !!}
            {!! setting_show('site.keywords', __('Site Keywords'), 'textarea') !!}
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>
            <a href="{{url('admin/settings/sitemap')}}" class="btn btn-success"><i class="fa fa-sitemap"></i> {{__('Generate Sitemap')}}</a>
        </form>
    </x-card>
@endsection
