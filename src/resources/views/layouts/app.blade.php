<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'EasyPost Tools') }}</title>

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#retrieveAddress" class="nav-link">Retrieve
                        Address</a>
                    <a href="/addresses" class="nav-link">List All Addresses</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#batchesCollapse" role="button" aria-expanded="false" aria-controls="batchesCollapse"><i
                        class="fas fa-layer-group"></i>&nbsp;&nbsp;Batches</a>
                <div class="collapse" id="batchesCollapse">
                    <a href="#" class="nav-link">Not Currently Supported via UI</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#carriersCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse"><i
                        class="fas fa-truck"></i>&nbsp;&nbsp;Carriers</a>
                <div class="collapse" id="carriersCollapse">
                    <form action="/retrieve-carriers" method="POST" id="retrieveCarriers">
                        @csrf
                        <a href="#" data-bs-toggle="modal" data-bs-target="#retrieveCarrier" class="nav-link">
                            Retrieve Carrier Account
                        </a>
                        <a href="#" onclick="document.getElementById('retrieveCarriers').submit();"
                            class="nav-link">Retrieve Carrier Accounts</a>
                    </form>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#insuranceCollapse" role="button" aria-expanded="false" aria-controls="insuranceCollapse"><i
                        class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Insurance</a>
                <div class="collapse" id="insuranceCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createInsurance" class="nav-link">Create
                        Insurance</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#retrieveInsurance"
                        class="nav-link">Retrieve
                        Insurance</a>
                    <form action="/retrieve-insurances" method="POST" id="retrieveInsurances">
                        @csrf
                        <a href="#" onclick="document.getElementById('retrieveInsurances').submit();"
                            class="nav-link">Retrieve all Insurance</a>
                    </form>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#ordersCollapse" role="button" aria-expanded="false" aria-controls="ordersCollapse"><i
                        class="fas fa-layer-group"></i>&nbsp;&nbsp;Orders</a>
                <div class="collapse" id="ordersCollapse">
                    <a href="#" class="nav-link">Not Currently Supported via UI</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#parcelCollapse" role="button" aria-expanded="false" aria-controls="parcelCollapse"><i
                        class="fas fa-box-open"></i>&nbsp;&nbsp;Parcels</a>
                <div class="collapse" id="parcelCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createParcel" class="nav-link">Create
                        Parcel</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#retrieveParcel"
                        class="nav-link">Retrieve
                        Parcel</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#pickupsCollapse" role="button" aria-expanded="false" aria-controls="pickupsCollapse"><i
                        class="fas fa-layer-group"></i>&nbsp;&nbsp;Pickups</a>
                <div class="collapse" id="pickupsCollapse">
                    <a href="#" class="nav-link">Not Currently Supported via UI</a>
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
                    href="#scanformsCollapse" role="button" aria-expanded="false"
                    aria-controls="scanformsCollapse"><i
                        class="fas fa-layer-group"></i>&nbsp;&nbsp;Scanforms/Manifest</a>
                <div class="collapse" id="scanformsCollapse">
                    <a href="#" class="nav-link">Not Currently Supported via UI</a>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#shipmentCollapse" role="button" aria-expanded="false"
                    aria-controls="shipmentCollapse"><i class="fas fa-truck-loading"></i>&nbsp;&nbsp;Shipments</a>
                <div class="collapse" id="shipmentCollapse">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#createShipment"
                        class="nav-link">Create
                        Shipment</a>
                    <a href="#" data-bs-toggle="modal" data-bs-target="#retrieveShipment"
                        class="nav-link">Retrieve
                        Shipment</a>
                    <form action="/retrieve-shipments" method="POST" id="retrieveShipments">
                        @csrf
                        <a href="#" onclick="document.getElementById('retrieveShipments').submit();"
                            class="nav-link">Retrieve all Shipments</a>
                    </form>
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
                    <a href="#" data-bs-toggle="modal" data-bs-target="#retrieveTracker"
                        class="nav-link">Retrieve
                        Tracker</a>
                    <form action="/retrieve-trackers" method="POST" id="retrieveTrackers">
                        @csrf
                        <a href="#" onclick="document.getElementById('retrieveTrackers').submit();"
                            class="nav-link">Retrieve all Trackers</a>
                    </form>
                </div>

                <a class="list-group-item list-group-item-action bg-light" data-bs-toggle="collapse"
                    href="#webhooksCollapse" role="button" aria-expanded="false"
                    aria-controls="webhooksCollapse"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;Webhooks</a>
                <div class="collapse" id="webhooksCollapse">
                    <a href="https://www.easypost.com/account/webhooks-and-events" class="nav-link"
                        target="_blank">Visit the EasyPost Dashboard</a>
                </div>
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
                @include('modals.retrieve-address')
                @include('modals.retrieve-carrier')
                @include('modals.retrieve-insurance')
                @include('modals.retrieve-parcel')
                @include('modals.retrieve-shipment')
                @include('modals.retrieve-tracker')

                @include('partials.flash-messages')

                @yield('content')
            </main>
        </div>
    </div>
</body>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}" defer></script>
<script src="https://kit.fontawesome.com/0dd4ecd465.js" crossorigin="anonymous"></script>
<script>
    function toggleSidebar() {
        const menuWrapper = document.getElementById("wrapper")
        menuWrapper.classList.toggle("toggled");
    }
</script>

</html>
