<x-modal title="Create Tracker" id="createTracker" submit-button="Create Tracker">
    <form action="/create-tracker" method="POST">
        @csrf

        <p>Create a tracker by providing the tracking code from your carrier.</p>

        <label for="tracking_code">Tracking Code</label>
        <input class="form-control" name="tracking_code" value="{{old('tracking_code')}}">

        <label for="carrier">Carrier (optional)</label>
        <input class="form-control" name="carrier" value="{{old('carrier')}}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
