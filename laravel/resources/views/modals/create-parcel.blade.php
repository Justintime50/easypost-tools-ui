<div class="modal fade" id="createParcel" tabindex="-1" role="dialog" aria-labelledby="createParcelLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createParcelLabel">Create Parcel</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="/create-parcel" method="POST">
                @csrf

                <p>Create a one-off parcel. Input accepts decimals, conveyed in inches and ounces.</p>
                
                <label for="length">Length*</label>
                <input class="form-control" name="length" value="{{old('length')}}">

                <label for="width">Width*</label>
                <input class="form-control" name="width" value="{{old('width')}}">

                <label for="height">Height*</label>
                <input class="form-control" name="height" value="{{old('height')}}">

                <label for="weight">Weight*</label>
                <input class="form-control" name="weight" value="{{old('weight')}}">

                <button type="submit" class="btn btn-primary">Create Parcel</button>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
