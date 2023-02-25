<x-modal title="Create Insurance" id="createInsurance" submit-button="Create Insurance">
    <form action="/insurances" method="POST">
        @csrf

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
