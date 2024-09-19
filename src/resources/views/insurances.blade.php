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
                        <th>To Street1</th>
                        <th>To City</th>
                        <th>To State</th>
                    </thead>
                    @foreach ($json->insurances as $insurance)
                        <tr>
                            <td>
                                <a href="/insurances/{{ $insurance->id }}" class="btn btn-primary btn-sm btn-table">
                                    {{ substr($insurance->id, 0, 10) }}...
                                </a>
                            </td>
                            <td>{{ $insurance->created_at }}</td>
                            <td>{{ $insurance->amount }}</td>
                            <td>{{ $insurance->provider }}</td>
                            <td>{{ isset($insurance->to_address) ? $insurance->to_address->street1 : null }}</td>
                            <td>{{ isset($insurance->to_address) ? $insurance->to_address->city : null }}</td>
                            <td>{{ isset($insurance->to_address) ? $insurance->to_address->state : null }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
