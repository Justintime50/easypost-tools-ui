@extends('layouts.app')

@section('content')
    <div class="response-wrapper">
        <div class="response">
            <p>Select an action to the left to interact with the EasyPost API.</p>
            @php $json = $json ?? session()->get('json') @endphp
            @if (isset($json))
                <h4>Record</h4>
            @endif

            @if (isset($json->postage_label->label_url))
                <div>
                    <a class="btn btn-primary btn-label" href="{{ $json->postage_label->label_url }}"
                        download="{{ $json->id }}" target="_blank">DOWNLOAD LABEL&nbsp;<i class="fas fa-download"></i>
                    </a>
                </div>
            @endif

            @php $response = isset($json) ? $json : "" @endphp
            <pre>{{ $response }}</pre>
        </div>
    </div>
@endsection
