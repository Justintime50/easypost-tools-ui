<x-modal title="Retrieve Shipment" id="retrieveShipment" submit-button="Retrieve Shipment">
    <form action="/retrieve-shipment" method="POST">
        @csrf

        <label for="id">Shipment ID</label>
        <input class="form-control" name="id" value="{{ old('id') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
