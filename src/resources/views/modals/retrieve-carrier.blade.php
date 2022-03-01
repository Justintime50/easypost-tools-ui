<x-modal title="Retrieve Carrier" id="retrieveCarrier" submit-button="Retrieve Carrier">
    <form action="/retrieve-carrier" method="POST">
        @csrf

        <label for="id">Carrier ID</label>
        <input class="form-control" name="id" value="{{old('id')}}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
