<div class="modal fade" id="createShipment" tabindex="-1" role="dialog" aria-labelledby="createShipmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createShipmentLabel">Create Shipment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="/create-shipment" method="POST">
                @csrf

                <h3>From Address</h3>
                <label for="from_street1">Street 1*</label>
                <input class="form-control" name="from_street1" value="{{old('from_street1')}}">

                <label for="from_street2">Street 2</label>
                <input class="form-control" name="from_street2" value="{{old('from_street2')}}">

                <label for="from_city">City*</label>
                <input class="form-control" name="from_city" value="{{old('from_city')}}">

                <label for="from_state">State*</label>
                <input class="form-control" name="from_state" value="{{old('from_state')}}">

                <label for="from_zip">Zip*</label>
                <input class="form-control" name="from_zip" value="{{old('from_zip')}}">

                <label for="from_country">Country</label>
                <input class="form-control" name="from_country" value="{{old('from_country')}}">

                <label for="from_company">Company</label>
                <input class="form-control" name="from_company" value="{{old('from_company')}}">

                <label for="from_phone">Phone</label>
                <input class="form-control" name="from_phone" value="{{old('from_phone')}}">


                
                <h3>To Address</h3>
                <label for="to_street1">Street 1*</label>
                <input class="form-control" name="to_street1" value="{{old('to_street1')}}">

                <label for="to_street2">Street 2</label>
                <input class="form-control" name="to_street2" value="{{old('to_street2')}}">

                <label for="to_city">City*</label>
                <input class="form-control" name="to_city" value="{{old('to_city')}}">

                <label for="to_state">State*</label>
                <input class="form-control" name="to_state" value="{{old('to_state')}}">

                <label for="to_zip">Zip*</label>
                <input class="form-control" name="to_zip" value="{{old('to_zip')}}">

                <label for="to_country">Country</label>
                <input class="form-control" name="to_country" value="{{old('to_country')}}">

                <label for="to_company">Company</label>
                <input class="form-control" name="to_company" value="{{old('to_company')}}">

                <label for="to_phone">Phone</label>
                <input class="form-control" name="to_phone" value="{{old('to_phone')}}">


                
                <h3>Parcel</h3>
                <p>Input access decimals, conveyed in inches and pounds.</p>
                
                <label for="length">Length*</label>
                <input class="form-control" name="length" value="{{old('length')}}">

                <label for="width">Width*</label>
                <input class="form-control" name="width" value="{{old('width')}}">

                <label for="height">Height*</label>
                <input class="form-control" name="height" value="{{old('height')}}">

                <label for="weight">Weight*</label>
                <input class="form-control" name="weight" value="{{old('weight')}}">

                <button type="submit" class="btn btn-primary">Create Shipment</button>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
