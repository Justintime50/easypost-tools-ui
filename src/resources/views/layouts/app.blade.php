<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
        <script src="https://kit.fontawesome.com/0dd4ecd465.js" crossorigin="anonymous"></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>

    <body>

    <div class="d-flex" id="wrapper">

    <div class="bg-light border-right" id="sidebar-wrapper">
        <h1 class="sidebar-heading"><a href="/">{{ config('app.name') }}</a></h1>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#addressCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse"><i class="fas fa-address-book"></i>&nbsp;&nbsp;Addresses</a>
            <div class="collapse" id="addressCollapse">
                <a href="#" data-toggle="modal" data-target="#createAddress" class="nav-link">Create Address</a>
                <a href="#" data-toggle="modal" data-target="#retrieveAddress" class="nav-link">Retrieve Address</a>
                <form action="/retrieve-addresses" method="POST" id="retrieveAddresses">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveAddresses').submit();" class="nav-link">Retrieve all Addresses</a>
                </form>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#batchesCollapse" role="button" aria-expanded="false" aria-controls="batchesCollapse"><i class="fas fa-layer-group"></i>&nbsp;&nbsp;Batches</a>
            <div class="collapse" id="batchesCollapse">
                <a href="#" class="nav-link">Not Currently Supported via UI</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#carriersCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse"><i class="fas fa-truck"></i>&nbsp;&nbsp;Carriers</a>
            <div class="collapse" id="carriersCollapse">
                <form action="/retrieve-carriers" method="POST" id="retrieveCarriers">
                    @csrf
                    <a href="#" data-toggle="modal" data-target="#retrieveCarrier" class="nav-link">Retrieve Carrier Account</a>
                    <a href="#" onclick="document.getElementById('retrieveCarriers').submit();" class="nav-link">Retrieve Carrier Accounts</a>
                </form>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#insuranceCollapse" role="button" aria-expanded="false" aria-controls="insuranceCollapse"><i class="fas fa-dollar-sign"></i>&nbsp;&nbsp;Insurance</a>
            <div class="collapse" id="insuranceCollapse">
                <a href="#" data-toggle="modal" data-target="#createInsurance" class="nav-link">Create Insurance</a>
                <a href="#" data-toggle="modal" data-target="#retrieveInsurance" class="nav-link">Retrieve Insurance</a>
                <form action="/retrieve-insurances" method="POST" id="retrieveInsurances">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveInsurances').submit();" class="nav-link">Retrieve all Insurance</a>
                </form>      
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#ordersCollapse" role="button" aria-expanded="false" aria-controls="ordersCollapse"><i class="fas fa-layer-group"></i>&nbsp;&nbsp;Orders</a>
            <div class="collapse" id="ordersCollapse">
                <a href="#" class="nav-link">Not Currently Supported via UI</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#parcelCollapse" role="button" aria-expanded="false" aria-controls="parcelCollapse"><i class="fas fa-box-open"></i>&nbsp;&nbsp;Parcels</a>
            <div class="collapse" id="parcelCollapse">
                <a href="#" data-toggle="modal" data-target="#createParcel" class="nav-link">Create Parcel</a>
                <a href="#" data-toggle="modal" data-target="#retrieveParcel" class="nav-link">Retrieve Parcel</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#pickupsCollapse" role="button" aria-expanded="false" aria-controls="pickupsCollapse"><i class="fas fa-layer-group"></i>&nbsp;&nbsp;Pickups</a>
            <div class="collapse" id="pickupsCollapse">
                <a href="#" class="nav-link">Not Currently Supported via UI</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#reportsCollapse" role="button" aria-expanded="false" aria-controls="reportsCollapse"><i class="fas fa-receipt"></i>&nbsp;&nbsp;Reports</a>
            <div class="collapse" id="reportsCollapse">
                <a href="https://easypost.com/account/reports" class="nav-link" target="_blank">Visit the EasyPost Dashboard</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#scanformsCollapse" role="button" aria-expanded="false" aria-controls="scanformsCollapse"><i class="fas fa-layer-group"></i>&nbsp;&nbsp;Scanforms/Manifest</a>
            <div class="collapse" id="scanformsCollapse">
                <a href="#" class="nav-link">Not Currently Supported via UI</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#shipmentCollapse" role="button" aria-expanded="false" aria-controls="shipmentCollapse"><i class="fas fa-truck-loading"></i>&nbsp;&nbsp;Shipments</a>
            <div class="collapse" id="shipmentCollapse">
                <a href="#" data-toggle="modal" data-target="#createShipment" class="nav-link">Create Shipment</a>
                <a href="#" data-toggle="modal" data-target="#retrieveShipment" class="nav-link">Retrieve Shipment</a>
                <form action="/retrieve-shipments" method="POST" id="retrieveShipments">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveShipments').submit();" class="nav-link">Retrieve all Shipments</a>
                </form>
                <a href="#" data-toggle="modal" data-target="#buyShipment" class="nav-link">Buy Shipment</a>
                <a href="#" data-toggle="modal" data-target="#createRefund" class="nav-link">Refund Shipment</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#trackerCollapse" role="button" aria-expanded="false" aria-controls="trackerCollapse"><i class="fas fa-map-marker-alt"></i>&nbsp;&nbsp;Trackers</a>
            <div class="collapse" id="trackerCollapse">
                <a href="#" data-toggle="modal" data-target="#createTracker" class="nav-link">Create Tracker</a>
                <a href="#" data-toggle="modal" data-target="#retrieveTracker" class="nav-link">Retrieve Tracker</a>
                <form action="/retrieve-trackers" method="POST" id="retrieveTrackers">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveTrackers').submit();" class="nav-link">Retrieve all Trackers</a>
                </form>  
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#webhooksCollapse" role="button" aria-expanded="false" aria-controls="webhooksCollapse"><i class="fas fa-calendar-alt"></i>&nbsp;&nbsp;Webhooks</a>
            <div class="collapse" id="webhooksCollapse">
                <a href="https://www.easypost.com/account/webhooks-and-events" class="nav-link" target="_blank">Visit the EasyPost Dashboard</a>
            </div>

        </div>
    </div>

    <div id="page-content-wrapper">

    <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
        <button class="btn btn-primary" id="menu-toggle">Toggle Sidebar&nbsp;&nbsp;<i class="fas fa-toggle-on"></i></button>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto mt-2 mt-lg-0">
                @auth
                    <a class="nav-link" href="https://www.easypost.com/docs/api" target="_blank">EasyPost API Docs</a>
                    <a class="nav-link" href="mailto:support@easypost.com" target="_blank">EasyPost Support</a>
                    <a class="nav-link" href="https://github.com/Justintime50/easypost-tools-ui" target="_blank">GitHub</a>
                    <a class="nav-link" href="{{ url('/account') }}">Account</a>
                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('frm-logout').submit();">Logout</a>
                        <form id="frm-logout" action="{{ route('logout') }}" method="POST" class="display-none">
                            {{ csrf_field() }}
                        </form>
                @else
                    <a class="nav-link" href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                    <a class="nav-link" href="https://github.com/Justintime50/easypost-tools-ui" target="_blank">GitHub</a>
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </ul>
        </div>
    </nav>

    <main>
        <!-- Import all modals -->
        @include('modals.create-address')
        @include('modals.retrieve-address')
        @include('modals.create-parcel')
        @include('modals.retrieve-parcel')
        @include('modals.create-shipment')
        @include('modals.retrieve-shipment')
        @include('modals.create-tracker')
        @include('modals.retrieve-tracker')
        @include('modals.retrieve-insurance')
        @include('modals.create-refund')
        @include('modals.buy-shipment')
        @include('modals.retrieve-carrier')

        <!-- LARAVEL ERRORS -->
        <div class="container-fluid padding-0">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session()->has('message'))
                <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
            @endif

            @if(session()->has('error'))
                <p class="alert alert-danger {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('error') }}</p>
            @endif
        </div>
        <!-- Inject content -->
        @yield('content')
    </main>

    <script>
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>

    </div>
</body>
</html>
