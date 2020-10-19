<header class="navbar navbar-header navbar-header-fixed">
    <div class="navbar-right">
        <div class="dropdown dropdown-profile">
            <a href="" class="dropdown-link" data-toggle="dropdown" data-display="static">
                <div class="avatar avatar-sm avatar-online">
                    <img src="{{ asset(auth()->user()->gravatar) }}" class="rounded-circle" alt="{{ auth()->user()->name }}">
                </div>
            </a>
            <div class="dropdown-menu dropdown-menu-right tx-13">
                <h6 class="tx-semibold mg-b-5">
                    {{ auth()->user()->name }}
                </h6>

                <p class="mg-b-10 tx-12 tx-color-03">
                    {{ auth()->user()->email }}
                </p>

                {{-- <a href="#" class="dropdown-item tx-medium">
                    <i data-feather="user"></i>
                    {{ __('Mi cuenta') }}
                </a>

                <a href="" class="dropdown-item tx-medium">
                    <i data-feather="shield"></i>
                    {{ __('Seguridad') }}
                </a>

                <a href="" class="dropdown-item tx-medium">
                    <i data-feather="settings"></i>
                    {{ __('Ajustes') }}
                </a> --}}

                <div class="dropdown-divider mb-2 mt-2"></div>

                <a class="dropdown-item tx-medium" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i data-feather="log-out"></i>
                    <span>{{ __('Logout') }}</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                      {{ csrf_field() }}
                </form>
            </div>
        </div>
    </div>
</header>
