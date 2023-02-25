<x-modal title="Buy a Stamp" id="buyStamp" submit-button="Buy a Stamp">
    <form action="/shipments/stamp" method="POST">
        @csrf

        <p>Buy a USPS stamp which will produce a label that you can print directly to an A10 standard envelope
            which will contain the to/from address (USA only) and the stamp/barcode.</p>

        <p><b>NOTE:</b> We grab the first USPS carrier account and use that here for convenience, this behavior cannot
            currently be configured.</p>

        <p>You can either use an ID from a previously created address/parcel or enter them manually.</p>

        <h3>From Address</h3>

        <label for="from_address">From Address ID</label>
        <input class="form-control" name="from_address" value="{{ old('from_address') }}"
            placeholder="Use an Address ID instead of entering one manually below.">

        <hr>

        @include('partials.from-address')

        <h3>To Address</h3>

        <label for="to_address">To Address ID</label>
        <input class="form-control" name="to_address" value="{{ old('to_address') }}"
            placeholder="Use an Address ID instead of entering one manually below.">

        <hr>

        @include('partials.to-address')

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
