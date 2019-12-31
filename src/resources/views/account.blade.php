@extends('layouts.app')

@section('content')

    <div class="container">

        <!-- LARAVEL ERRORS -->
        <div class="container-fluid" style="padding:0px; margin-top:20px;">
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

        <h3>Welcome, {{ Auth::user()->email }}.</h3>

        <form action="/update-api-key" method="POST">
            @csrf

            <p>You can add a test or production API key here. API keys will be masked and cannot be retrieved here. Treat these keys the same way you would a password!</p>

            <label for="api_key">EasyPost API Key</label>
            <input type="password" class="form-control" name="api_key" value="{{old('api_key')}}" placeholder="12345678900987654321">

            <button type="submit" class="btn btn-primary">Update API Key</button>
        </form>

    </div>
@endsection
