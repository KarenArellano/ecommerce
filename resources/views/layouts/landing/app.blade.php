<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Stripe publicable Token -->
    <meta name="stripe-token" content="{{ env('APP_ENV') == 'local' ? env('STRIPE_PUBLICABLE_SANDBOX'): env('STRIPE_PUBLICABLE_PRODUCTION') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Fav Icon -->
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('lady-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('lady-16x16.png') }}">
    <link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <link rel="mask-icon" href="{{ asset('safari-pinned-tab.svg') }}" color="#5bbad5">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="theme-color" content="#ffffff">

    <title>{{ config('app.name', 'Lady Records') }} | @yield('title')</title>

    <!-- Facebook Pixel head -->

    @include('facebook-pixel::head')

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/landing.css') }}" rel="stylesheet">

    <!-- Custom Styles -->
    @stack('css')

    <script src="https://js.stripe.com/v3/"></script>

    <!-- ManyChat -->
    <script src="//widget.manychat.com/547530305729014.js" async="async"></script>

</head>

<body>
    <!-- Preloader -->
    <div id="preloader">
        <div class="loader"></div>
    </div>
    <!-- /Preloader -->

    <!--Facebook Pixel Body-->
    @include('facebook-pixel::body')

    <!-- Header Area Start -->
    @include('layouts.landing.partials.header')
    <!-- Header Area End -->

    <!-- Breadcrumb Area Start -->
    @yield('breadcrumb')
    <!-- Breadcrumb Area End -->

    <!-- Content Area Start -->
    @yield('content')
    <!-- Content Area End -->

    <!-- Footer Area Start -->
    @include('layouts.landing.partials.footer')
    <!-- Footer Area End -->

    <!-- Modals -->
    @stack('modals')

    <!-- Messenger Chat -->
    @include('layouts.landing.partials.messenger_chat')

    <!-- Scripts -->
    <script src="{{ asset('js/landing.js') }}"></script>
    <script src="{{ asset('js/bundle.js') }}"></script>
    <script src="https://checkout.stripe.com/checkout.js"></script>

    <!-- Custom Scripts -->
    @stack('js')
</body>

</html>