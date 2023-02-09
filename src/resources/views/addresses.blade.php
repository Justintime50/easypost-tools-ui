@extends('layouts.app')
@section('content')
    <div class="response-wrapper">
        <div class="response">
            <h2>Addresses</h2>
            <p>Select an address ID to view all details for that record.</p>
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
                                <a href="/address/{{ $address->id }}"><button
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
