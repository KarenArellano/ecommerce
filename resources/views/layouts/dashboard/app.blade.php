<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} - @yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/dashboard.css') }}" rel="stylesheet">

    <!--Custom Styles -->
    @stack('css')
</head>

<body>
    @include('layouts.dashboard.partials.header')

    @include('layouts.dashboard.partials.sidebar')

    <div class="content content-fixed bgrdWhite">
        <div class="container-fluid pd-x-0 pd-lg-x-10 pd-xl-x-0">
            <div class="container-fluid pd-x-0">
                <div class="d-sm-flex align-items-center justify-content-between mg-b-20 mg-lg-b-25 mg-xl-b-30">
                    @yield('breadcrumb')
                </div>

                {{-- @alert @endalert --}}

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Modals -->
    @stack('modals')

    <!-- Scripts -->
    <script src="{{ asset('js/dashboard.js') }}"></script>
    <script src="{{ asset('js/modal.js') }}"></script>

    <!-- Custom Scripts -->
    @stack('js')
</body>

</html>