@extends('layouts.main')

@section('title',__('Payments Settings'))

@section('body')
    <x-card title="{{__('Payments Settings')}}" icon="icon icon-directions">
        @if($check)
            <div class="alert alert-success"><i class="fa fa-check"></i> {{__('Paytabs Connected Success')}}</div>
        @else
            <div class="alert alert-danger"><i class="fa fa-close"></i> {{__('Email Or KEY not Correct Please Try again')}}</div>
        @endif
        <img src="{{url('payments/paytabs.png')}}" style="width: 20%; margin-right: auto; margin-left: auto; display: block">
        <form method="POST" action="{{url('admin/payment')}}">
            @csrf
            {!! setting_show('paytabs.merchant_email', __('Paytabs Email'), 'text') !!}
            {!! setting_show('paytabs.secret_key', __('Paytabs Key'), 'text') !!}
            <button class="btn btn-primary"><i class="fa fa-save"></i> {{__('Save')}}</button>
        </form>
    </x-card>
@endsection
