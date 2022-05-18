<x-modal title="Create Refund" id="createRefund" submit-button="Create Refund">
    <form action="/create-refund" method="POST">
        @csrf

        <p>Shipments can be refunded if they have not been scanned yet and were created in the last 30 days.</p>

        <label for="id">Shipment ID</label>
        <input class="form-control" name="id" value="{{ old('id') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
