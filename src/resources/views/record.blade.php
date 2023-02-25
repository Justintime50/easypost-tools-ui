@extends('layouts.app')

@section('content')
    <div class="response-wrapper">
        <div class="response">
            @php $json = $json ?? session()->get('json') @endphp
            @if (isset($json))
                <h4>Record</h4>
            @endif

            @php $response = isset($json) ? $json : "" @endphp
            <pre>{{ $response }}</pre>
        </div>
    </div>
@endsection
