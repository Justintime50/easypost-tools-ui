<div class="modal fade" id="buyShipment" tabindex="-1" role="dialog" aria-labelledby="buyShipmentLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="buyShipmentLabel">Buy a Shipment</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/buy-shipment" method="POST">
          @csrf

          <p>Buy a shipment by supplying the shipment ID and an associated rate ID.</p>

          <label for="shipment_id">Shipment ID</label>
          <input class="form-control" name="shipment_id" value="{{old('shipment_id')}}">

          <label for="rate_id">Rate ID</label>
          <input class="form-control" name="rate_id" value="{{old('rate_id')}}">

          <button type="submit" class="btn btn-primary">Buy Shipment</button>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
