<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">

        <title>{{ config('app.name') }}</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
            h3 {
                padding-top: 30px;
            }
        </style>
    </head>

    @include('modals.create-address')
    @include('modals.retrieve-address')
    @include('modals.create-parcel')
    @include('modals.retrieve-parcel')
    @include('modals.create-shipment')

    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                        <a href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                        <a class="nav-link" href="https://github.com/Justintime50/easypost-ui" target="_blank">GitHub</a>
                    @else
                        <a href="https://www.easypost.com/docs/api" target="_blank">API Docs</a>
                        <a href="https://github.com/Justintime50/easypost-ui" target="_blank">GitHub</a>

                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">

                <div class="title m-b-md">
                    {{ config('app.name') }}
                </div>

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

                <div class="links">
                    <h3>Create</h3>
                    <a href="#" data-toggle="modal" data-target="#createAddress">Create Address</a>
                    <a href="#" data-toggle="modal" data-target="#createParcel">Create Parcel</a>
                    <a href="#" data-toggle="modal" data-target="#createShipment">Create Shipment</a>

                    <h3>Read</h3>
                    <a href="#" data-toggle="modal" data-target="#retrieveAddress">Retrieve Address</a>
                    <a href="#" data-toggle="modal" data-target="#retrieveParcel">Retrieve Parcel</a>

                    <h3>TODO</h3>
                    <a href="/">Insurance</a>
                    <a href="/">Tracking</a>
                </div>
            </div>
        </div>
    </body>
</html>
