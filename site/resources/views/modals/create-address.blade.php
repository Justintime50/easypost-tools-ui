<div class="modal fade" id="createAddress" tabindex="-1" role="dialog" aria-labelledby="createAddressLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createAddressLabel">Create Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="/create-address" method="POST">
                @csrf

                <label for="street1">Street 1*</label>
                <input class="form-control" name="street1" value="{{old('street1')}}">

                <label for="street2">Street 2</label>
                <input class="form-control" name="street2" value="{{old('street2')}}">

                <label for="city">City*</label>
                <input class="form-control" name="city" value="{{old('city')}}">

                <label for="state">State*</label>
                <input class="form-control" name="state" value="{{old('state')}}">

                <label for="zip">Zip*</label>
                <input class="form-control" name="zip" value="{{old('zip')}}">

                <label for="country">Country</label>
                <input class="form-control" name="country" value="{{old('country')}}">

                <label for="company">Company</label>
                <input class="form-control" name="company" value="{{old('company')}}">

                <label for="phone">Phone</label>
                <input class="form-control" name="phone" value="{{old('phone')}}">

                <button type="submit" class="btn btn-primary">Save</button>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
