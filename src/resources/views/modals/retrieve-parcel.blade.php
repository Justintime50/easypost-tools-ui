<x-modal title="Retrieve Parcel" id="retrieveParcel" submit-button="Retrieve Parcel">
    <form action="/retrieve-parcel" method="POST">
        @csrf

        <label for="id">Parcel ID</label>
        <input class="form-control" name="id" value="{{old('id')}}">

        {{-- We do not close the form here because we do so at the component level --}}
</x-modal>
