<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EasyPost Tools') }}</title>

    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
</head>

<body>
    <div class="d-flex" id="wrapper">
        {{-- Left sidebar --}}
        <div class="bg-light border-right" id="sidebar-wrapper">
            <h1 class="sidebar-heading"><a href="/">{{ config('app.name') }}</a></h1>
            <div class="list-group list-group-flush">
                <a href="/addresses" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-address-book"></i>&nbsp;&nbsp;Addresses</a>
                <a href="/carriers" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-truck"></i>&nbsp;&nbsp;Carriers</a>
                <a href="/insurances" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Insurances</a>
                <a href="/parcels" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-box-open"></i>&nbsp;&nbsp;Parcels</a>
                <a href="/refunds" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-dollar"></i>&nbsp;&nbsp;Refunds</a>
                <a href="/shipments" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-truck-loading"></i>&nbsp;&nbsp;Shipments</a>
                <a href="/trackers" class="list-group-item list-group-item-action bg-light"><i
                        class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;Trackers</a>
                <a href="#" data-bs-toggle="modal" data-bs-target="#search"
                    class="list-group-item list-group-item-action bg-light">Search by EasyPost Object ID</a>
            </div>
        </div>

        <div id="page-content-wrapper">
            {{-- Top navbar --}}
            <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
                <div class="container-fluid">
                    <button class="btn btn-primary" id="menu-toggle" onclick="toggleSidebar()">
                        Toggle Sidebar&nbsp;&nbsp;<i class="fas fa-toggle-on"></i>
                    </button>

                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="navbar-collapse collapse" id="navbarSupportedContent">
                        <ul class="navbar-nav ms-auto">
                            @auth
                                <a class="nav-link" href="https://www.easypost.com/docs/api" target="_blank">EasyPost
                                    API Docs</a>
                                <a class="nav-link" href="mailto:support@easypost.com" target="_blank">EasyPost
                                    Support</a>
                                <a class="nav-link" href="https://github.com/Justintime50/easypost-tools-ui"
                                    target="_blank">GitHub</a>
                                <a class="nav-link" href="{{ url('/account') }}">Account</a>
                                <a class="nav-link" href="{{ route('logout') }}"
                                    onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                                <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="display-none">
                                    @csrf
                                </form>
                            @else
                                <a class="nav-link" href="https://www.easypost.com/docs/api" target="_blank">API
                                    Docs</a>
                                <a class="nav-link" href="https://github.com/Justintime50/easypost-tools-ui"
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
