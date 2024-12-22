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
          <input type="text" name="schedule_id" id="approveScheduleId">
          <div class="form-group">
            <label for="approveEventDateLabel">Event Date</label>
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