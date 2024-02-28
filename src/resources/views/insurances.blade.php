@extends('layouts.app')
@section('content')
    @include('modals.create-insurance')
    <div class="response-wrapper">
        <div class="response">
            <h2>Insurances</h2>
            <button class="btn btn-primary mb-3" href="#" data-bs-toggle="modal" data-bs-target="#createInsurance"
                class="nav-link">Create an
                Insurance</button>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Created At</th>
                        <th>Amount</th>
                        <th>Provider</th>
                        <th>Street1</th>
                        <th>City</th>
                        <th>State</th>
                    </thead>
                    @foreach ($json->insurances as $insurance)
                        <tr>
                            <td>
                                <a href="/insurances/{{ $insurance->id }}"><button
                                        class="btn btn-primary btn-sm btn-table"><?php echo substr($insurance->id, 0, 10); ?>...</button></a>
                            </td>
                            <td>{{ $insurance->created_at }}</td>
                            <td>{{ $insurance->amount }}</td>
                            <td>{{ $insurance->provider }}</td>
                            <td>{{ $insurance->to_address->street1 }}</td>
                            <td>{{ $insurance->to_address->city }}</td>
                            <td>{{ $insurance->to_address->state }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
