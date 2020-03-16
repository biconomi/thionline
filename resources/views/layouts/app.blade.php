<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>

      {{-- <link href="{{asset('adminlte/lib/fontawesome-free/css/all.css')}}" rel="stylesheet"> --}}
      <link rel="stylesheet" href="{{asset('adminlte/login/all.css')}}">
      <link rel="stylesheet" href="{{asset('adminlte/login/bracket.css')}}">
</head>
<body>
        @yield('content')
    <!-- Scripts -->
    
</body>
</html>