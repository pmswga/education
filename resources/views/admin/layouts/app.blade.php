<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title')</title>
    <link rel="stylesheet" type="text/css" href="{{ asset('bootstrap/css/bootstrap.css') }}">
</head>
<body>
    @auth('admin')
    @include('admin/layouts/navbar')
    @endauth

    @if(\Illuminate\Support\Facades\Session::has('success'))
        <div class="container-fluid">
            <div class="alert alert-success" role="alert">
                <h4 class="alert-heading">Успешно!</h4>
                <p>{{ \Illuminate\Support\Facades\Session::get('success') }}</p>
            </div>
        </div>
    @endif

    @if(\Illuminate\Support\Facades\Session::has('error'))
        <div class="container-fluid">
            <div class="alert alert-danger" role="alert">
                <h4 class="alert-heading">Ошибка!</h4>
                <p>{{ \Illuminate\Support\Facades\Session::get('error') }}</p>
            </div>
        </div>
    @endif

    <div class="container-fluid">
        @yield('content')
    </div>

    <script type="text/javascript" src="{{ asset('bootstrap/js/bootstrap.js') }}"></script>
    <script type="text/javascript" src="{{ asset('bootstrap/js/bootstrap.bundle.js') }}"></script>
</body>
</html>
