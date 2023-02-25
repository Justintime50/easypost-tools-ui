@extends('layouts.app')
@section('content')
    @include('modals.create-parcel')
    <div class="response-wrapper">
        <div class="response">
            <h2>Parcels</h2>
            <button class="btn btn-primary" href="#" data-bs-toggle="modal" data-bs-target="#createParcel"
                class="nav-link">Create
                Parcel</button>
        </div>
    </div>
@endsection
