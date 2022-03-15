@extends("layouts.app")

@section("content")

<div class="response-wrapper">
    <div class="response">
        <p>Select an action to the left to interact with the EasyPost API.</p>
        <h4>Record</h4>
        @if (isset($json->postage_label->label_url))
        <div>
            <a class="btn btn-primary btn-label" href="{{ $json->postage_label->label_url }}" download="{{ $json->id }}"
                target="_blank">DOWNLOAD LABEL&nbsp;<i class="fas fa-download"></i>
            </a>
        </div>
        @endif
        <pre>
            <?php if (isset($json)) {
                echo $json;
            } else {
                echo "No record has been retrieved.";
            }
            ?>
        </pre>
    </div>
</div>

@endsection
