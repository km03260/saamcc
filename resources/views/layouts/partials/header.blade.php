<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta contentType="text/html; charset=UTF-8" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/app_logo.png') }}" type="image/x-icon">
    <title>{{ config('app.name', 'Laravel') }} @yield('title')</title>

    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/Semantic-UI-CSS-master/semantic.min.css') }}" />

    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/DataTables/DataTables-1.11.4/css/jquery.dataTables.min.css') }}" />
    <link rel="stylesheet" type="text/css"
        href="{{ asset('assets/DataTables/Scroller-2.0.5/css/scroller.dataTables.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/DataTables/FixedHeader-3.2.1/css/fixedHeader.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/jquery-confirm/master/jquery-confirm.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/Toast/dist/css/toast.min.css') }}">
    @yield('links')
    <script type="text/javascript" src="{{ asset('/assets/DataTables/jQuery-3.6.0/jquery-3.6.0.min.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('assets/modal/css/iModal.min.css') }}">
    <script src="{{ asset('assets/jquery-confirm/jquery-confirm.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/Semantic-UI-CSS-master/semantic.min.js') }}"></script>

    <link href="{{ asset('assets/css/sty1.0.4.css') }}" rel="stylesheet">
    <script type="module" src="{{ asset('/build/assets/app-eec918f2.js') }}"></script>

    {{-- @vite('resources/js/app.js') --}}
</head>

<body>
