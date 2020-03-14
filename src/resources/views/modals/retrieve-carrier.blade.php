<div class="modal fade" id="retrieveCarrier" tabindex="-1" role="dialog" aria-labelledby="retrieveCarrierLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="retrieveCarrierLabel">Retrieve a Carrier</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/retrieve-carrier" method="POST">
          @csrf

          <label for="id">Carrier ID</label>
          <input class="form-control" name="id" value="{{old('id')}}">

          <button type="submit" class="btn btn-primary">Retrieve Carrier</button>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
