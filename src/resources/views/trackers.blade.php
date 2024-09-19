@extends('layouts.app')
@section('content')
    <div class="response-wrapper">
        <div class="response">
            <h2>Trackers</h2>
            <p>Select a tracker ID to view all details for that record.</p>
            <div class="table-responsive">
                <table class="table">
                    <th>ID</th>
                    <th>Created At</th>
                    <th>Tracking Code</th>
                    <th>Status</th>
                    <th>Details</th>
                    <th>Carrier</th>
                    @foreach ($json->trackers as $tracker)
                        <tr>
                            <td>
                                <a href="/trackers/{{ $tracker->id }}" class="btn btn-primary btn-sm btn-table">
                                    {{ substr($tracker->id, 0, 10) }}...
                                </a>
                            </td>
                            <td>{{ $tracker->created_at }}</td>
                            <td>{{ $tracker->tracking_code }}</td>
                            <td>{{ $tracker->status }}</td>
                            <td>{{ $tracker->status_detail }}</td>
                            <td>{{ $tracker->carrier }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
