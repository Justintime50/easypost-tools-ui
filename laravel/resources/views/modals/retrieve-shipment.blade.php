<div class="modal fade" id="retrieveShipment" tabindex="-1" role="dialog" aria-labelledby="retrieveShipmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="retrieveShipmentLabel">Retrieve an Address</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="/retrieve-shipment" method="POST">
                @csrf

                <label for="id">Shipment ID</label>
                <input class="form-control" name="id" value="{{old('id')}}">

                <button type="submit" class="btn btn-primary">Retrieve Shipment</button>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
