<div class="modal fade" id="createRefund" tabindex="-1" role="dialog" aria-labelledby="createRefundLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createRefundLabel">Create a Refund</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="/create-refund" method="POST">
                @csrf

                <p>Shipments can be refunded if they have not been scanned yet and were created in the last 30 days.</p>

                <label for="id">Shipment ID</label>
                <input class="form-control" name="id" value="{{old('id')}}">

                <button type="submit" class="btn btn-primary">Create Refund</button>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
