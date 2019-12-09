<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/stylesheet.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>

    @include('modals.create-address')
    @include('modals.retrieve-address')
    @include('modals.create-parcel')
    @include('modals.retrieve-parcel')
    @include('modals.create-shipment')
    @include('modals.retrieve-shipment')
    @include('modals.create-tracker')
    @include('modals.retrieve-tracker')
    @include('modals.retrieve-insurance')

    <body>
        <div class="flex-center position-ref">
        @include('partials.nav')

            <div class="content">

                <div class="links actions">
                    <h1>API Actions</h1>
                    <p class="links"><a href="/">Clear Page</a></p>

                    <div class="box">
                        <h3>Create</h3>
                        <a href="#" data-toggle="modal" data-target="#createAddress">Address</a>
                        <a href="#" data-toggle="modal" data-target="#createParcel">Parcel</a>
                        <a href="#" data-toggle="modal" data-target="#createShipment">Shipment</a>
                        <a href="#" data-toggle="modal" data-target="#createTracker">Tracking</a>
                    </div>

                    <div class="box">
                        <h3>Retrieve</h3>
                        <a href="#" data-toggle="modal" data-target="#retrieveAddress">Address</a>
                        <a href="#" data-toggle="modal" data-target="#retrieveParcel">Parcel</a>
                        <a href="#" data-toggle="modal" data-target="#retrieveShipment">Shipment</a>
                        <a href="#" data-toggle="modal" data-target="#retrieveInsurance">Insurance</a>
                        <a href="#" data-toggle="modal" data-target="#retrieveTracker">Tracking</a>
                    </div>

                    <div class="box">
                        <h3>View All</h3>
                        <p>Care should be taken when retrieving all, performance issues could arise with the current configuration.</p>
                        <form action="/retrieve-addresses" method="POST" id="retrieveAddresses">
                            @csrf
                            <a href="#" onclick="document.getElementById('retrieveAddresses').submit();">Addresses</a>
                        </form>                      
                        <form action="/retrieve-shipments" method="POST" id="retrieveShipments">
                            @csrf
                            <a href="#" onclick="document.getElementById('retrieveShipments').submit();">Shipments</a>
                        </form>                        
                        <form action="/retrieve-insurances" method="POST" id="retrieveInsurances">
                            @csrf
                            <a href="#" onclick="document.getElementById('retrieveInsurances').submit();">Insurances</a>
                        </form>                        
                        <form action="/retrieve-trackers" method="POST" id="retrieveTrackers">
                            @csrf
                            <a href="#" onclick="document.getElementById('retrieveTrackers').submit();">Trackers</a>
                        </form>                    </div>
                </div>

                <hr>

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
                    <?php
                    $response = session()->get( 'response' );
                    if (!isset($response))
                        {
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
    </body>
</html>
