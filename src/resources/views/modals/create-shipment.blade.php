<x-modal title="Create Shipment" id="createShipment" submit-button="Create Shipment">
    <form action="/shipments" method="POST">
        @csrf

        <p>Create a shipment which will produce a label. Submitting this form will bill your account based on the rate
            you select on the next screen.</p>

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

        <h3>Parcel</h3>

        <p>Parcels may only have a parcel ID, predefined parcel, or be created manually. They cannot have 2 or 3 of
            those defined here.</p>

        <label for="parcel">Parcel ID</label>
        <input class="form-control" name="parcel" value="{{ old('parcel') }}"
            placeholder="Use a Pacel ID instead of entering one manually below.">

        <p>You can also specify a predefined_package for your pacel, found <a
                href="https://www.easypost.com/docs/api/php#predefined-packages">here</a>.</p>

        <label for="predefined_package">Predefined Parcel</label>
        <input class="form-control" name="predefined_package" value="{{ old('predefined_package') }}"
            placeholder="Use a predefined parcel instead of entering one manually below.">

        <hr>

        <p>Input accepts decimals, conveyed in inches and ounces.</p>

        <label for="length">Length</label>
        <input class="form-control" name="length" value="{{ old('length') }}">

        <label for="width">Width</label>
        <input class="form-control" name="width" value="{{ old('width') }}">

        <label for="height">Height</label>
        <input class="form-control" name="height" value="{{ old('height') }}">

        <label for="weight">Weight</label>
        <input class="form-control" name="weight" value="{{ old('weight') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
