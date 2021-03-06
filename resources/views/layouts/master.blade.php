<!DOCTYPE html>
<html lang="{{ config('app.locale') }}" @if(auth('admin')->user() && auth('admin')->user()->language === 'ar') dir="rtl" @endif>

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">

	{{-- TODO translatable suffix --}}
    <title>@yield('title', '3x1')</title>

	@include('partials.css')

    @stack('css')

    @yield('styles')

</head>

<body class="app header-fixed sidebar-fixed sidebar-lg-show">
    @yield('header')

    @yield('content')

    @yield('footer')

    @include('partials.js')
    @include('partials.wysiwyg-svgs')
    @yield('js')
    @include('sweetalert::alert')
</body>

</html>
