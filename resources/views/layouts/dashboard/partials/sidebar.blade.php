<aside class="aside aside-fixed">
    <div class="aside-header">
        <a href="{{ url('') }}" >
            <!-- {{ config('app.name') }} -->
            <img src="{{ asset('images/lowres-lady-records-logo-horizontal.png') }}" alt="{{ config('app.name') }}" style="width: 60%!important; height:auto;">
            <!-- <img src="{{ asset('images/dashboard/name-records.png') }};"   alt=""> -->
            <!-- <h6>{{ config('app.name') }}</h6> -->
        </a>
        <a href="" class="aside-menu-link">
            <i data-feather="menu"></i>
            <i data-feather="x"></i>
        </a>
    </div> 
    <div class="aside-body">
        <ul class="nav nav-aside text-capitalize">
            <li class="nav-label">
                Dashboard
            </li>
            <li class="nav-item {{ Ekko::isActive('dashboard') }}">
                <a href="{{ url('dashboard') }}" class="nav-link">
                    <i data-feather="home"></i>
                    <span>{{ __('Inicio') }}</span>
                </a>
            </li>

            <li class="nav-label mg-t-25">{{ __('Catálogo') }}</li>
            <li class="nav-item {{ Ekko::isActiveRoute('dashboard.categories.*') }}">
                <a href="{{ route('dashboard.categories.index') }}" class="nav-link">
                    <i data-feather="copy"></i>
                    <span>{{ __('Categorias') }}</span>
                </a>
            </li>
            <li class="nav-item {{ Ekko::isActiveRoute('dashboard.products.*') }}">
                <a href="{{ route('dashboard.products.index') }}" class="nav-link">
                    <i data-feather="package"></i>
                    <span>{{ __('Productos') }}</span>
                </a>
            </li>

            <li class="nav-label mg-t-25">{{ __('Tienda') }}</li>
            <li class="nav-item {{ Ekko::isActiveRoute('dashboard.orders.*') }}">
                <a href="{{ route('dashboard.orders.index') }}" class="nav-link">
                    <i data-feather="inbox"></i>
                    <span>{{ __('Ordenes') }}</span>
                </a>
            </li>

            <!-- <li class="nav-item {{ Ekko::isActiveRoute('dashboard.shippments.*') }}">
                <a href="{{ route('dashboard.shippments.index') }}" class="nav-link">
                    <i data-feather="truck"></i>
                    <span>{{ __('Envios') }}</span>
                </a>
            </li> -->

            <li class="nav-item {{ Ekko::isActiveRoute('dashboard.coupons.*') }}">
                <a href="{{ route('dashboard.coupons.index') }}" class="nav-link">
                    <i data-feather="package"></i>
                    <span>{{ __('Cupones') }}</span>
                </a>
            </li>

            <li class="nav-item {{ Ekko::isActiveRoute('dashboard.users.*') }}">
                <a href="{{ route('dashboard.users.index') }}" class="nav-link">
                    <i data-feather="users"></i>
                    <span>{{ __('Usuarios') }}</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
