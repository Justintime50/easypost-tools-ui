@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p>Welcome {{ Auth::user()->email }}.</p>

                    <form action="/update-api-key" method="POST">
                        @csrf

                        <input type="password" class="form-control" name="api_key" value="{{old('api_key')}}">
                        <button class="btn btn-primary">
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
