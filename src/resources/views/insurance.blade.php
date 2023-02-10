@extends('layouts.app')
@section('content')
    <div class="response-wrapper">
        <div class="response">
            <h2>Insurance</h2>
            <p>Select an insurance ID to view all details for that record.</p>
            <div class="table-responsive">
                <table class="table">
                    <th>ID</th>
                    <th>Created At</th>
                    <th>Amount</th>
                    <th>Provider</th>
                    <th>Street1</th>
                    <th>City</th>
                    <th>State</th>
                    @foreach ($json->insurances as $insurance)
                        <td>
                            <a href="/insurance/{{ $insurance->id }}"><button
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
