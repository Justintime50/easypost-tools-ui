<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EasyPost Tools') }}</title>

    <link rel="stylesheet" href="https://fonts.bunny.net/css?family=Poppins">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex" id="wrapper">
        {{-- Left sidebar --}}
        <div class="bg-light border-right" id="sidebar-wrapper">
            <h1 class="sidebar-heading"><a href="/">{{ config('app.name') }}</a></h1>
            <div class="list-group list-group-flush">
                <a class="list-group-item list-group-item-action bg-light" href="/addresses"><i
                       class="bi bi-book"></i>&nbsp;&nbsp;Addresses</a>
                <a class="list-group-item list-group-item-action bg-light" href="/carriers"><i
                       class="bi bi-truck"></i>&nbsp;&nbsp;Carriers</a>
                <a class="list-group-item list-group-item-action bg-light" href="/insurances"><i
                       class="bi bi-currency-dollar"></i>&nbsp;&nbsp;Insurances</a>
                <a class="list-group-item list-group-item-action bg-light" href="/parcels"><i
                       class="bi bi-box"></i>&nbsp;&nbsp;Parcels</a>
                <a class="list-group-item list-group-item-action bg-light" href="/refunds"><i
                       class="bi bi-currency-dollar"></i>&nbsp;&nbsp;Refunds</a>
                <a class="list-group-item list-group-item-action bg-light" href="/shipments"><i
                       class="bi bi-truck"></i>&nbsp;&nbsp;Shipments</a>
                <a class="list-group-item list-group-item-action bg-light" href="/trackers"><i
                       class="bi bi-pin-map"></i>&nbsp;&nbsp;Trackers</a>
                <a class="list-group-item list-group-item-action bg-light"
                   data-bs-toggle="modal"
                   data-bs-target="#search"
                   href="#">Search by EasyPost Object ID</a>
            </div>
        </div>

        <div id="page-content-wrapper">
            {{-- Top navbar --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary"
                            id="menu-toggle"
                            onclick="toggleSidebar()">
                        Toggle Sidebar&nbsp;&nbsp;<i class="bi bi-toggle-on"></i>
                    </button>

                    <button class="navbar-toggler"
                            data-bs-toggle="collapse"
                            data-bs-target="#navbarSupportedContent"
                            type="button"
                            aria-controls="navbarSupportedContent"
                            aria-expanded="false"
                            aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @auth
                                <a class="nav-link"
                                   href="https://www.easypost.com/docs/api"
                                   target="_blank">EasyPost
                                    API Docs</a>
                                <a class="nav-link"
                                   href="mailto:support@easypost.com"
                                   target="_blank">EasyPost
                                    Support</a>
                                <a class="nav-link"
                                   href="https://github.com/Justintime50/easypost-tools-ui"
                                   target="_blank">GitHub</a>
                                <a class="nav-link" href="{{ url('/account') }}">Account</a>
                                <a class="nav-link"
                                   href="{{ route('logout') }}"
                                   onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                                <form class="display-none"
                                      id="frm-logout"
                                      action="{{ route('logout') }}"
                                      method="POST">
                                    @csrf
                                </form>
                            @else
                                <a class="nav-link"
                                   href="https://www.easypost.com/docs/api"
                                   target="_blank">API
                                    Docs</a>
                                <a class="nav-link"
                                   href="https://github.com/Justintime50/easypost-tools-ui"
                                   target="_blank">GitHub</a>
                                <a class="nav-link" href="{{ route('login') }}">Login</a>
                                @if (Route::has('register'))
                                    <a class="nav-link" href="{{ route('register') }}">Register</a>
                                @endif
                            @endauth
                        </ul>
                    </div>
                </div>
            </nav>

            <main>
                @include('modals.search')
                @include('partials.flash-messages')
                @yield('content')
            </main>
        </div>
    </div>
</body>

<!-- Scripts -->
<script src="https://kit.fontawesome.com/0dd4ecd465.js" crossorigin="anonymous"></script>
<script>
    function toggleSidebar() {
        const menuWrapper = document.getElementById("wrapper")
        menuWrapper.classList.toggle("toggled");
    }
</script>

</html>
