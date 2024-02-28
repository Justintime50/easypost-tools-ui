@extends('layouts.app')
@section('content')
    @include('modals.create-address')
    <div class="response-wrapper">
        <div class="response">
            <h2>Addresses</h2>
            <button class="btn btn-primary mb-3" href="#" data-bs-toggle="modal" data-bs-target="#createAddress"
                class="nav-link">Create an
                Address</button>
            <div class="table-responsive">
                <table class="table">
                    <th>ID</th>
                    <th>Created At</th>
                    <th>Street1</th>
                    <th>Street2</th>
                    <th>City</th>
                    <th>State</th>
                    <th>Zip</th>
                    <th>Country</th>
                    @foreach ($json->addresses as $address)
                        <tr>
                            <td>
                                <a href="/addresses/{{ $address->id }}"><button
                                        class="btn btn-primary btn-sm btn-table">{{ substr($address->id, 0, 10) }}...</button></a>
                            </td>
                            <td>{{ $address->created_at }}</td>
                            <td>{{ $address->street1 }}</td>
                            <td>{{ $address->street2 }}</td>
                            <td>{{ $address->city }}</td>
                            <td>{{ $address->state }}</td>
                            <td>{{ $address->zip }}</td>
                            <td>{{ $address->country }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
