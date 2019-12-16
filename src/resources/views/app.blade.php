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

    <body>

    <div class="d-flex" id="wrapper">

    <div class="bg-light border-right" id="sidebar-wrapper">
        <div class="sidebar-heading">EasyPost UI</div>
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

            <a class="list-group-item list-group-item-action bg-light" data-toggle="collapse" href="#insuranceCollapse" role="button" aria-expanded="false" aria-controls="insuranceCollapse">Insurance&nbsp;&nbsp;<i class="fas fa-receipt"></i></a>
            <div class="collapse" id="insuranceCollapse">
                <a href="#" data-toggle="modal" data-target="#retrieveInsurance" class="nav-link">Retrieve Insurance</a>
                <form action="/retrieve-insurances" method="POST" id="retrieveInsurances">
                    @csrf
                    <a href="#" onclick="document.getElementById('retrieveInsurances').submit();" class="nav-link">Retrieve all Insurance</a>
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
                <li class="nav-item">
                    <a href="https://www.easypost.com/docs/api" target="_blank" class="nav-link">API Docs</a>
                </li>
                <li class="nav-item">
                    <a href="https://github.com/Justintime50/easypost-ui" target="_blank" class="nav-link">GitHub</a>
                </li>
            </ul>
        </div>
    </nav>

    <div class="container-fluid response-wrapper">

        <div class="response">
          
            <!-- LARAVEL ERRORS -->
            <div class="container-fluid" style="padding:0px;">
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

            <pre>
            <h2>API Response</h2>
            <p class="clear-results-link"><a href="/">Clear Results</a></p>
                <?php
                $label = session()->get('label');
                $response = session()->get('response');
                if (isset($label)) {
                    echo "<div><a class='btn btn-primary btn-label' href='$label' target='_blank'>PRINT LABEL&nbsp;<i class='fas fa-mail-bulk'></i></a></div>";
                }
                if (!isset($response)) {
                    echo "<p>Run an action to return a response.</p>";
                } else {
                    $json = json_decode($response);
                    header('Content-type: text/javascript');
                    echo json_encode($json, JSON_PRETTY_PRINT);
                }
                ?>
            </pre>
        </div>
    </div>

<script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
</script>

    </body>
</html>


