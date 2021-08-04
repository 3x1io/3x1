<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>3x1</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

    <!-- Styles -->
    <style>
        html, body {
            background-color: #fff;
            color: #636b6f;
            font-family: 'Nunito', sans-serif;
            font-weight: 200;
            height: 100vh;
            margin: 0;
        }

        .full-height {
            height: 100vh;
        }

        .flex-center {
            align-items: center;
            display: flex;
            justify-content: center;
        }

        .position-ref {
            position: relative;
        }

        .top-right {
            position: absolute;
            right: 10px;
            top: 18px;
        }

        .content {
            text-align: center;
        }

        .title {
            font-size: 84px;
        }

        .links > a {
            color: #636b6f;
            padding: 0 25px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: .1rem;
            text-decoration: none;
            text-transform: uppercase;
        }

        .m-b-md {
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
<div class="flex-center position-ref full-height">
    @if (Route::has('login'))
        <div class="top-right links">
            @auth
                <a href="{{ url('/home') }}">Home</a>
            @else
                <a href="{{ route('login') }}">Login</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}">Register</a>
                @endif
            @endauth
        </div>
    @endif

    <div class="content">
        <div style="width: 50%; display: block; margin-left: auto; margin-right: auto">
        </div>
        <div class="title">
            <img width="200px" src="data:image/svg+xml,%0A%3Csvg version='1.1' id='Layer_1' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink' x='0px' y='0px' viewBox='0 0 89.7 82' style='enable-background:new 0 0 89.7 82;' xml:space='preserve'%3E%3Cstyle type='text/css'%3E .st0%7Bfill:%23FF007B;%7D .st1%7Bfill:%23022788;%7D%0A%3C/style%3E%3Cg%3E%3Cpolygon class='st0' points='44.9,41 38.8,51.6 0,51.6 0,30.4 38.8,30.4 '/%3E%3Cpolygon id='XMLID_85_' class='st1' points='44.9,41 38.8,51.6 34.3,59.4 21.2,82 0,82 17.5,51.6 23.7,41 17.5,30.4 0,0 21.2,0 34.3,22.6 38.8,30.4 '/%3E%3Cpolygon class='st0' points='68.5,0 47.3,36.9 36.6,18.5 47.3,0 '/%3E%3Cpolygon class='st0' points='68.5,82 47.3,82 36.6,63.5 47.3,45.1 '/%3E%3Crect id='XMLID_48_' x='68.5' y='0' class='st1' width='21.2' height='82'/%3E%3C/g%3E%3C/svg%3E"/>
            <br>
            3x1 Framework With Controllers
        </div>
        <p>Full Stack Web Framework Build in Laravel & Craftable</p>
    </div>
</div>
</body>
</html>
