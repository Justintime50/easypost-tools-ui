<x-modal title="Search for an EasyPost Object" id="search" submit-button="Find">
    <form action="/search" method="POST">
        @csrf

        <label for="id">EasyPost Object ID</label>
        <input class="form-control" name="id" value="{{ old('id') }}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
