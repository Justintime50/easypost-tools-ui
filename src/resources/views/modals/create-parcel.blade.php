<x-modal title="Create Parcel" id="createParcel" submit-button="Create Parcel">
    <form action="/parcels" method="POST">
        @csrf

        <p>Create a one-off parcel. Input accepts decimals to the first decimal place (eg: 10.9). Input only accepts
            inches and ounces.</p>

        <p>You can also specify a predefined_package for your pacel, found <a
                href="https://www.easypost.com/docs/api/php#predefined-packages">here</a>.</p>

        <label for="predefined_package">Predefined Parcel</label>
        <input class="form-control" name="predefined_package" value="{{ old('predefined_package') }}"
            placeholder="Use a predefined parcel instead of entering one manually below.">

        <hr>

        <label for="length">Length</label>
        <input class="form-control" name="length" type="number" step="0.1" value="{{ old('length') }}">

        <label for="width">Width</label>
        <input class="form-control" name="width" type="number" step="0.1" value="{{ old('width') }}">

        <label for="height">Height</label>
        <input class="form-control" name="height" type="number" step="0.1" value="{{ old('height') }}">

        <label for="weight">Weight</label>
        <input class="form-control" name="weight" type="number" step="0.1" value="{{ old('weight') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
