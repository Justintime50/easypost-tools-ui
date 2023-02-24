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
                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#addressCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse"><i
                        class="fas fa-address-book"></i>&nbsp;&nbsp;Addresses</a>
                <div class="collapse" id="addressCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createAddress" class="nav-link">Create
                        Address</a>
                    <a href="/addresses" class="nav-link">List All Addresses</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#carriersCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse"><i
                        class="fas fa-truck"></i>&nbsp;&nbsp;Carriers</a>
                <div class="collapse" id="carriersCollapse">
                    <a href="/carriers" class="nav-link">List All Carriers</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#insuranceCollapse" role="button" aria-expanded="false" aria-controls="insuranceCollapse"><i
                        class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Insurance</a>
                <div class="collapse" id="insuranceCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createInsurance" class="nav-link">Create
                        Insurance</a>
                    <a href="/insurances" class="nav-link">List All Insurances</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#parcelCollapse" role="button" aria-expanded="false" aria-controls="parcelCollapse"><i
                        class="fas fa-box-open"></i>&nbsp;&nbsp;Parcels</a>
                <div class="collapse" id="parcelCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createParcel" class="nav-link">Create
                        Parcel</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#reportsCollapse" role="button" aria-expanded="false" aria-controls="reportsCollapse"><i
                        class="fas fa-receipt"></i>&nbsp;&nbsp;Reports</a>
                <div class="collapse" id="reportsCollapse">
                    <a href="https://easypost.com/account/reports" class="nav-link" target="_blank">Visit the
                        EasyPost
                        Dashboard</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#shipmentCollapse" role="button" aria-expanded="false" aria-controls="shipmentCollapse"><i
                        class="fas fa-truck-loading"></i>&nbsp;&nbsp;Shipments</a>
                <div class="collapse" id="shipmentCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createShipment" class="nav-link">Create
                        Shipment</a>
                    <a href="/shipments" class="nav-link">List All Shipments</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#buyShipment" class="nav-link">Buy a
                        Shipment</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createRefund" class="nav-link">Refund
                        Shipment</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#buyStamp" class="nav-link">Buy a
                        Stamp</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#trackerCollapse" role="button" aria-expanded="false" aria-controls="trackerCollapse"><i
                        class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;Trackers</a>
                <div class="collapse" id="trackerCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createTracker" class="nav-link">Create
                        Tracker</a>
                    <a href="/trackers" class="nav-link">List All Trackers</a>
                </div>

                <a href="#" data-bs-toggle="modal" data-bs-target="#search" class="nav-link">Search EasyPost
                    Object ID</a>
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
                                <form id="frm-logout" action="{{ route('logout') }}" method="POST"
                                    class="display-none">
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
                <!-- Import all modals -->
                @include('modals.buy-shipment')
                @include('modals.buy-stamp')
                @include('modals.create-address')
                @include('modals.create-insurance')
                @include('modals.create-parcel')
                @include('modals.create-refund')
                @include('modals.create-shipment')
                @include('modals.create-tracker')
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
