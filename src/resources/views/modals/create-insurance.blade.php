<x-modal title="Create Insurance" id="createInsurance" submit-button="Create Insurance">
    <form action="/create-insurance" method="POST">
        @csrf

        <h3>From Address</h3>

        <label for="from_address">From Address ID</label>
        <input class="form-control" name="from_address" value="{{ old('from_address') }}"
            placeholder="Use an Address ID instead of entering one manually below.">

        <hr>

        <label for="from_street1">Street 1</label>
        <input class="form-control" name="from_street1" value="{{ old('from_street1') }}">

        <label for="from_street2">Street 2</label>
        <input class="form-control" name="from_street2" value="{{ old('from_street2') }}">

        <label for="from_city">City</label>
        <input class="form-control" name="from_city" value="{{ old('from_city') }}">

        <label for="from_state">State</label>
        <input class="form-control" name="from_state" value="{{ old('from_state') }}">

        <label for="from_zip">Zip</label>
        <input class="form-control" name="from_zip" value="{{ old('from_zip') }}">

        <label for="from_country">Country</label>
        <input class="form-control" name="from_country" value="{{ old('from_country') }}">

        <label for="from_company">Company</label>
        <input class="form-control" name="from_company" value="{{ old('from_company') }}">

        <label for="from_phone">Phone</label>
        <input class="form-control" name="from_phone" value="{{ old('from_phone') }}">

        <h3>To Address</h3>

        <label for="to_address">To Address ID</label>
        <input class="form-control" name="to_address" value="{{ old('to_address') }}"
            placeholder="Use an Address ID instead of entering one manually below.">

        <hr>

        <label for="to_street1">Street 1</label>
        <input class="form-control" name="to_street1" value="{{ old('to_street1') }}">

        <label for="to_street2">Street 2</label>
        <input class="form-control" name="to_street2" value="{{ old('to_street2') }}">

        <label for="to_city">City</label>
        <input class="form-control" name="to_city" value="{{ old('to_city') }}">

        <label for="to_state">State</label>
        <input class="form-control" name="to_state" value="{{ old('to_state') }}">

        <label for="to_zip">Zip</label>
        <input class="form-control" name="to_zip" value="{{ old('to_zip') }}">

        <label for="to_country">Country</label>
        <input class="form-control" name="to_country" value="{{ old('to_country') }}">

        <label for="to_company">Company</label>
        <input class="form-control" name="to_company" value="{{ old('to_company') }}">

        <label for="to_phone">Phone</label>
        <input class="form-control" name="to_phone" value="{{ old('to_phone') }}">

        <hr>

        <p>Create a insurance by providing the tracking code from your carrier.</p>

        <label for="tracking_code">Tracking Code</label>
        <input class="form-control" name="tracking_code" value="{{ old('tracking-code') }}">

        <label for="carrier">Carrier (optional)</label>
        <input class="form-control" name="carrier" value="{{ old('carrier') }}">

        <label for="amount">Amount</label>
        <input class="form-control" name="amount" value="{{ old('amount') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
