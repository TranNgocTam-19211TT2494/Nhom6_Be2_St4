<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="Ogani Template">
    <meta name="keywords" content="Ogani, unica, creative, html">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Organi Shop') }}</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@200;300;400;600;900&display=swap" rel="stylesheet">

    <!-- Css Styles -->
    <link rel="stylesheet" href="{{url('/css/bootstrap.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/css/elegant-icons.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/css/nice-select.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/css/jquery-ui.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/css/owl.carousel.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/css/slicknav.min.css')}}" type="text/css">
    <link rel="stylesheet" href="{{url('/css/style.css')}}" type="text/css">
    @stack('styles')
</head>
<!-- Page Preloder -->
<div id="preloder">
    <div class="loader"></div>
</div>
@include('partial.header')
@yield('product')
@yield('blog')
@yield('content')
@include('partial.footer')

<body>

</body>

</html>