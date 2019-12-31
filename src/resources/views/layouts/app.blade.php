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
        <h1 class="sidebar-heading"><a href="/">EasyPost UI</a></h1>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#addressCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse">Addresses&nbsp;&nbsp;<i class="fas fa-address-book"></i></a>
            <div class="collapse" id="addressCollapse">
                <a href="#" data-toggle="modal" data-target="#createAddress" class="nav-link">Create Address</a>
                <a href="#" data-toggle="modal" data-target="#retrieveAddress" class="nav-link">Retrieve Address</a>
                <form action="/retrieve-addresses" method="POST" id="retrieveAddresses">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveAddresses').submit();" class="nav-link">Retrieve all Addresses</a>
                </form>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#carriersCollapse" role="button" aria-expanded="false" aria-controls="addressCollapse">Carriers&nbsp;&nbsp;<i class="fas fa-truck"></i></a>
            <div class="collapse" id="carriersCollapse">
                <form action="/retrieve-carriers" method="POST" id="retrieveCarriers">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveCarriers').submit();" class="nav-link">Retrieve Supported Carriers</a>
                </form>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#insuranceCollapse" role="button" aria-expanded="false" aria-controls="insuranceCollapse">Insurance&nbsp;&nbsp;<i class="fas fa-receipt"></i></a>
            <div class="collapse" id="insuranceCollapse">
                <a href="#" data-toggle="modal" data-target="#retrieveInsurance" class="nav-link">Retrieve Insurance</a>
                <form action="/retrieve-insurances" method="POST" id="retrieveInsurances">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveInsurances').submit();" class="nav-link">Retrieve all Insurance</a>
                </form>      
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#parcelCollapse" role="button" aria-expanded="false" aria-controls="parcelCollapse">Parcels&nbsp;&nbsp;<i class="fas fa-box-open"></i></a>
            <div class="collapse" id="parcelCollapse">
                <a href="#" data-toggle="modal" data-target="#createParcel" class="nav-link">Create Parcel</a>
                <a href="#" data-toggle="modal" data-target="#retrieveParcel" class="nav-link">Retrieve Parcel</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#shipmentCollapse" role="button" aria-expanded="false" aria-controls="shipmentCollapse">Shipments&nbsp;&nbsp;<i class="fas fa-truck-loading"></i></a>
            <div class="collapse" id="shipmentCollapse">
                <a href="#" data-toggle="modal" data-target="#createShipment" class="nav-link">Create Shipment</a>
                <a href="#" data-toggle="modal" data-target="#retrieveShipment" class="nav-link">Retrieve Shipment</a>
                <form action="/retrieve-shipments" method="POST" id="retrieveShipments">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveShipments').submit();" class="nav-link">Retrieve all Shipments</a>
                </form>
                <a href="#" data-toggle="modal" data-target="#createRefund" class="nav-link">Refund</a>
            </div>

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#trackerCollapse" role="button" aria-expanded="false" aria-controls="trackerCollapse">Trackers&nbsp;&nbsp;<i class="fas fa-map-marker-alt"></i></a>
            <div class="collapse" id="trackerCollapse">
                <a href="#" data-toggle="modal" data-target="#createTracker" class="nav-link">Create Tracker</a>
                <a href="#" data-toggle="modal" data-target="#retrieveTracker" class="nav-link">Retrieve Tracker</a>
                <form action="/retrieve-trackers" method="POST" id="retrieveTrackers">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveTrackers').submit();" class="nav-link">Retrieve all Trackers</a>
                </form>  
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
                    <a class="nav-link" href="{{ url('/account') }}">Account</a>
                    <a class="nav-link" href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                    <a class="nav-link" href="https://github.com/Justintime50/easypost-ui" target="_blank">GitHub</a>
                @else
                    <a class="nav-link" href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                    <a class="nav-link" href="https://github.com/Justintime50/easypost-ui" target="_blank">GitHub</a>
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    @if (Route::has('register'))
                        <a class="nav-link" href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            </ul>
        </div>
    </nav>

    <main>
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
