<x-modal title="Buy a Shipment" id="buyShipment" submit-button="Buy Shipment">
    <form action="/buy-shipment" method="POST">
        @csrf

        <p>Buy a shipment by supplying the shipment ID and an associated rate ID.</p>

        <label for="shipment_id">Shipment ID</label>
        <input class="form-control" name="shipment_id" value="{{old('shipment_id')}}">

        <label for="rate_id">Rate ID</label>
        <input class="form-control" name="rate_id" value="{{old('rate_id')}}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
