@extends('layouts.app')
@section('content')
    <div class="container">
        <h3>Welcome, {{ Auth::user()->email }}.</h3>
        <form action="/update-api-key" method="POST">
            @csrf
            <p>You can add your test or production EasyPost API key here. API keys will be masked and cannot be retrieved
                here. Treat these keys the same way you would a password!</p>
            <p>You can access your EasyPost API keys by visiting the <a href="https://easypost.com/account"
                    target="_blank">EasyPost Dashboard</a>.</p>
            <label for="api_key">EasyPost API Key</label>
            <input type="password" class="form-control" name="api_key" value="{{ old('api_key') }}"
                placeholder="12345678900987654321">
            <button type="submit" class="btn btn-primary">Update API Key</button>
        </form>
    </div>
@endsection
