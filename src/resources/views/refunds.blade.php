@extends('layouts.app')
@section('content')
    <div class="response-wrapper">
        <div class="response">
            <h2>Refunds</h2>
            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <th>ID</th>
                        <th>Created At</th>
                        <th>Tracking Code</th>
                        <th>Confirmation Number</th>
                        <th>Status</th>
                        <th>Carrier</th>
                        <th>Shipment ID</th>
                    </thead>
                    @foreach ($json->refunds as $refund)
                        <tr>
                            <td>
                                <a href="/refunds/{{ $refund->id }}" class="btn btn-primary btn-sm btn-table">
                                    {{ substr($refund->id, 0, 10) }}...
                                </a>
                            </td>
                            <td>{{ $refund->created_at }}</td>
                            <td>{{ $refund->tracking_code }}</td>
                            <td>{{ $refund->confirmation_number }}</td>
                            <td>{{ $refund->status }}</td>
                            <td>{{ $refund->carrier }}</td>
                            <td><a href="/shipments/{{ $refund->shipment_id }}">{{ $refund->shipment_id }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
