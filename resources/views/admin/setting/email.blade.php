@extends('layouts.main')

@section('title',__('Email Settings'))

@section('body')
    <x-card title="{{__('Email Settings')}}" icon="icon icon-envelope">
        @if($check)
            <div class="alert alert-success"><i class="fa fa-check"></i> {{__('Email Connected Success')}}</div>
        @else
            <div class="alert alert-danger"><i class="fa fa-close"></i> {{__('Some Date of email settings not correct')}}</div>
        @endif
        <form method="POST" action="{{url('admin/email')}}">
            @csrf
            {!! setting_show('email.host', __('Email Host'), 'text') !!}
            {!! setting_show('email.port', __('Email Port'), 'text') !!}
            {!! setting_show('email.username', __('Email Username'), 'text') !!}
            {!! setting_show('email.password', __('Email Password'), 'text') !!}
            {!! setting_show('email.encryption', __('Email Encryption'), 'text') !!}
            {!! setting_show('email.from', __('Email From'), 'text') !!}
            {!! setting_show('email.from.name', __('Email From Name'), 'text') !!}
            <button class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>
        </form>
    </x-card>
@endsection
