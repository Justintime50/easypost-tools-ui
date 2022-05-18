<x-modal title="Create Address" id="createAddress" submit-button="Create Address">
    <form action="/create-address" method="POST">
        @csrf

        <p>Create a one-off address, save the returned ID for future use.</p>

        <label for="street1">Street 1</label>
        <input class="form-control" name="street1" value="{{ old('street1') }}">

        <label for="street2">Street 2</label>
        <input class="form-control" name="street2" value="{{ old('street2') }}">

        <label for="city">City</label>
        <input class="form-control" name="city" value="{{ old('city') }}">

        <label for="state">State</label>
        <input class="form-control" name="state" value="{{ old('state') }}">

        <label for="zip">Zip</label>
        <input class="form-control" name="zip" value="{{ old('zip') }}">

        <label for="country">Country</label>
        <input class="form-control" name="country" value="{{ old('country') }}">

        <label for="company">Company</label>
        <input class="form-control" name="company" value="{{ old('company') }}">

        <label for="phone">Phone</label>
        <input class="form-control" name="phone" value="{{ old('phone') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
