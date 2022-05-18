<x-modal title="Retrieve Tracker" id="retrieveTracker" submit-button="Retrieve Tracker">
    <form action="/retrieve-tracker" method="POST">
        @csrf

        <label for="id">Tracker ID</label>
        <input class="form-control" name="id" value="{{ old('id') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
