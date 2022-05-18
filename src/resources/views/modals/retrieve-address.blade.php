<x-modal title="Retrieve Address" id="retrieveAddress" submit-button="Retrieve Address">
    <form action="/retrieve-address" method="POST">
        @csrf

        <label for="id">Address ID</label>
        <input class="form-control" name="id" value="{{ old('id') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
