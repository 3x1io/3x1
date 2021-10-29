@extends('layouts.master')

@section('header')
    @include('admin.layout.parts.header')
@endsection

@section('content')
    <div class="app-body" id="layout-wrapper" style="display: none">

        @if(View::exists('admin.layout.sidebar'))
            @include('admin.layout.sidebar')
        @endif
        <main class="main">
            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>
                @yield('body')
            </div>
        </main>
    </div>
@endsection

@section('footer')
    @include('admin.layout.parts.footer')
@endsection
