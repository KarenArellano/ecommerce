<header class="header-area">
    <!-- Main Header Start -->
    <div class="main-header-area">
        <div class="classy-nav-container breakpoint-off">
            <div class="container">
                <!-- Classy Menu -->
                <nav class="classy-navbar justify-content-between" id="alimeNav">

                    <!-- Logo -->
                    <a href="{{ url('/') }}">
                        <img src="{{ asset('images/lowres-lady-records-logo-horizontal.png') }}" alt="{{ config('app.name') }}" style="width: 40%!important;">
                    </a>

                    <!-- Navbar Toggler -->
                    <div class="classy-navbar-toggler">
                        <span class="navbarToggler">
                            <span></span>
                            <span></span>
                            <span></span>
                        </span>
                    </div>

                    <!-- Menu -->
                    <div class="classy-menu">
                        <!-- Menu Close Button -->
                        <div class="classycloseIcon">
                            <div class="cross-wrap">
                                <span class="top"></span>
                                <span class="bottom"></span>
                            </div>
                        </div>
                        <!-- Nav Start -->
                        <div class="classynav">
                            <ul id="nav">
                                <!-- <li class="{{ Ekko::isActive('/') }}">
                                    <a href="{{ url('/') }}">
                                        {{ __('Inicio') }}
                                    </a>
                                </li> -->

                                <li class="{{ Ekko::isActiveRoute('landing.products.*') }}">
                                    <a href="{{ route('landing.products.index') }}">
                                        {{ __('Tienda') }}
                                    </a>
                                </li>

                                <li class="{{ Ekko::isActiveRoute('landing.about') }}">
                                    <a href="{{ route('landing.about') }}">
                                        {{ __('Acerca de') }}
                                    </a>
                                </li>
                                <li class="{{ Ekko::isActiveRoute('landing.contact') }}">
                                    <a href="{{ route('landing.contact') }}">
                                        {{ __('Contacto') }}
                                    </a>
                                </li>
                                @guest
                                <li class="{{ Ekko::isActiveRoute(['login', 'register', 'password.request', 'password.reset']) }}">
                                    <a href="{{ route('login') }}">
                                        {{ __('Iniciar sesión') }}
                                    </a>
                                </li>
                                @else
                                <li>
                                    <a href="#">{{ auth()->user()->first_name }}</a>
                                    <ul class="dropdown">
                                        @if (auth()->user()->is_administrator)
                                        <li>
                                            <a href="{{ route('dashboard.home') }}">{{ __('Dashboard') }}</a>
                                        </li>
                                        @else
                                        <li>
                                            <a href="{{ route('landing.account.index') }}">{{ __('Cuenta') }}</a>
                                        </li>
                                        @endif
                                        <li>
                                            <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                                {{ __('Logout') }}
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>
                                @endguest

                                <li class="{{ Ekko::isActiveRoute('landing.cart.*') }}">
                                    <div class="d-flex align-items-center">
                                        <a href="{{ route('landing.cart.index') }}">
                                            <span class="d-block d-sm-block d-md-none">{{ __('Carrito') }}</span>
                                            <i class="ti-shopping-cart-full" style="font-size: x-large;"></i>
                                            @if (session('cart.products_count'))
                                            <span class="badge badge-pill badge-danger" style="position:absolute;margin-left:-10px;margin-top:-5px;font-size:x-small;z-index:-1;">
                                                {{ session('cart.products_count') }}
                                            </span>
                                            @endif
                                        </a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                        <!-- Nav End -->
                    </div>
                </nav>
            </div>
        </div>
    </div>
</header>