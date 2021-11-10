<div class="modal fade" id="retrieveAddresses" tabindex="-1" role="dialog" aria-labelledby="retrieveAddressesLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="retrieveAddressesLabel">Retrieve a list of Addresses</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form action="/retrieve-addresses" method="POST">
          @csrf

          <label for="id">EasyPost API Key</label>
          <input class="form-control" name="api_key" type="password">

          <button type="submit" class="btn btn-primary">Retrieve Addresses</button>

        </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
