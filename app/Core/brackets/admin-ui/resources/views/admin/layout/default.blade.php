@extends('brackets/admin-ui::admin.layout.master')

@section('header')
    @include('admin.layout.parts.header')
@endsection

@section('content')

    <div class="app-body">

        @if(View::exists('admin.layout.sidebar'))
            @include('admin.layout.sidebar')
        @endif

        <main class="main">
            <div class="d-none loading-full">
                <img width="100px" src="{{url('logo.svg')}}">
            </div>
            <div class="container-fluid" id="app" :class="{'loading': loading}">
                <div class="modals">
                    <v-dialog/>
                </div>
                <div>
                    <notifications position="bottom right" :duration="2000" />
                </div>
                <div class="loading loading-full" v-if="loading">
                    <img width="100px" src="{{url('logo.svg')}}">
                </div>
                @yield('body')
            </div>
        </main>
    </div>
@endsection

@section('footer')
    @include('admin.layout.parts.footer')
@endsection

@section('bottom-scripts')
    @parent
    <script>
        $(window).on('load', function () {
            $('#loading-full').fadeIn();
        })
    </script>
@endsection
