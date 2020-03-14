@extends("layouts.app")
@section("content")

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
                        <form action="/retrieve-tracker" method="POST">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <input type="hidden" name="id" value="{{ $tracker->id }}">
                            <td><button class="btn btn-primary btn-sm btn-table"><?php echo substr($tracker->id, 0, 10); ?>...</button></td>
                        </form>
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
