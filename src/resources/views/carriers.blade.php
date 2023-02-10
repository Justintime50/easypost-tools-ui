@extends('layouts.app')
@section('content')
    <div class="response-wrapper">
        <div class="response">
            <h2>Carriers</h2>
            <p>Select an carrier ID to view all details for that record.</p>
            <div class="table-responsive">
                <table class="table">
                    <th>ID</th>
                    <th>Created At</th>
                    <th>Readable Name</th>
                    <th>Type</th>
                    <th>Description</th>
                    <th>Reference</th>
                    @foreach ($json as $carrier)
                        <tr>
                            <td>
                                <a href="/carrier/{{ $carrier->id }}"><button
                                        class="btn btn-primary btn-sm btn-table"><?php echo substr($carrier->id, 0, 10); ?>...</button></a>
                            </td>
                            <td>{{ $carrier->created_at }}</td>
                            <td>{{ $carrier->readable }}</td>
                            <td>{{ $carrier->type }}</td>
                            <td>{{ $carrier->description }}</td>
                            <td>{{ $carrier->reference }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
@endsection
