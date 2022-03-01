<x-modal title="Retrieve Insurance" id="retrieveInsurance" submit-button="Retrieve Insurance">
    <form action="/retrieve-insurance" method="POST">
        @csrf

        <label for="id">Insurance ID</label>
        <input class="form-control" name="id" value="{{old('id')}}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
