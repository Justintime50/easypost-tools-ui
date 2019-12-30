<div class="modal fade" id="createTracker" tabindex="-1" role="dialog" aria-labelledby="createTrackerLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="createTrackerLabel">Create Tracker</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
            <form action="/create-tracker" method="POST">
                @csrf
                
                <p>Create a tracker by providing the tracking code from your carrier.</p>

                <label for="tracking_code">Tracking Code</label>
                <input class="form-control" name="tracking_code" value="{{old('tracking-code')}}">

                <button type="submit" class="btn btn-primary">Create Tracker</button>

            </form>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>
