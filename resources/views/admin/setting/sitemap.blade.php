@extends('layouts.main')

@section('title',__('SEO & Sitemap Settings'))

@section('body')
    <x-card title="{{ __('SEO & Sitemap Settings')}}" icon="icon icon-settings">
        <form method="POST" action="{{url('admin/sitemap')}}">
            @csrf
            {!! setting_show('site.logo', __('Site Logo'), 'image') !!}
            {!! setting_show('site.name', __('Site Title'), 'text') !!}
            {!! setting_show('site.author', __('Site Author'), 'text') !!}
            {!! setting_show('site.description', __('Site Description'), 'textarea') !!}
            {!! setting_show('site.keywords', __('Site Keywords'), 'textarea') !!}
            <button type="submit" class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>
        </form>
    </x-card>
@endsection
