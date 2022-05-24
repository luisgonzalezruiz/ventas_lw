<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no">
        <!-- CSRF Token -->
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'SISTEMA LWPOS') }}</title>

        <!-- Styles -->
        @include('layouts.theme.styles')

        <!-- Scripts -->
        @include('layouts.theme.scripts')

        <!-- Fonts -->
        <link rel="dns-prefetch" href="//fonts.gstatic.com">
        <link href="https://fonts.googleapis.com/css?family=Quicksand:400,500,600,700&display=swap" rel="stylesheet">
        <link href="{{ asset('vendor/fontawesome/css/all.css') }}" rel="stylesheet">
    </head>

    <body class="dashboard-analytics">
        <div id="load_screen">
            <div class="loader">
                <div class="loader-content">
                    <div class="spinner-grow align-self-center"></div>
                </div>
            </div>
        </div>

        @include('layouts.theme.header')

        <main class="main-container" id="container">

            <div class="overlay"></div>
            <div class="search-overlay"></div>

            @include('layouts.theme.sidebar')

            <div id="content" class="main-content">
                <div class="layout-px-spacing">
                    @yield('content')
                </div>
            </div>

            @include('layouts.theme.footer')
        </main>

        @livewireScripts

    </body>
</html>
