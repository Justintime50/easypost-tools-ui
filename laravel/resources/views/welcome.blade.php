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

    <body>
        <div class="flex-center position-ref full-height">
        @include('partials.nav')

            <div class="content">

                <div class="links actions">
                    <h1>API Actions</h1>

                    <div class="box">
                        <h3>Create</h3>
                        <a href="#" data-toggle="modal" data-target="#createAddress">Create Address</a>
                        <a href="#" data-toggle="modal" data-target="#createParcel">Create Parcel</a>
                        <a href="#" data-toggle="modal" data-target="#createShipment">Create Shipment</a>
                    </div>

                    <div class="box">
                        <h3>Read</h3>
                        <a href="#" data-toggle="modal" data-target="#retrieveAddress">Retrieve Address</a>
                        <a href="#" data-toggle="modal" data-target="#retrieveParcel">Retrieve Parcel</a>
                        <a href="#" data-toggle="modal" data-target="#retrieveShipment">Retrieve Shipment</a>
                    </div>
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
                    <?php if (!isset($response))
                        {
                            echo "Run an action to return a response.";
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
