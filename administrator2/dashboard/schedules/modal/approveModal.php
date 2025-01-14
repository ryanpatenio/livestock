<!-- Approve Schedule Modal -->
<div class="modal fade" id="approveScheduleModal" tabindex="-1" aria-labelledby="approveScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Approve Schedule</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="approveScheduleForm" method="post" action="">
        <div class="modal-body">
          <input type="hidden" name="schedule_id" id="approveScheduleId">
          <div class="form-group">
            <label for="approveEventDateLabel">Client Name</label>
            <input type="text" name="client_name" id="client-name" class="form-control" readonly>
          </div>
          <div class="form-group">
            <label for="">Event Name</label>
            <input type="text" name="event_name" id="event-name" class="form-control" readonly>
          </div>
          <div class="form-group">
              <div class="row">
                <div class="col">
                  <label for="">Vaccine Name</label>
                  <input type="text" name="vaccine_name" id="vaccine-name" class="form-control" readonly>
                </div>
                <div class="col">
                <label for="">Request Quantity</label>
                <input type="text" name="req_qty" id="req-qty" class="form-control" readonly>
                </div>
              </div>
          </div>
          <div class="form-group">
            <label for="">Event Date</label>
            <input type="date" name="event_date" id="approveEventDate" class="form-control" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary">Approve Schedule</button>
        </div>
      </form>
    </div>
  </div>
</div>