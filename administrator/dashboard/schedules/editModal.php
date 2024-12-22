<!-- Edit Modal -->
<div class="modal fade" id="editRequirementsModal" tabindex="-1" aria-labelledby="editRequirementsModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5>Edit Requirements</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="editRequirementsForm" method="post" action="">
          <div class="modal-body">
          <input type="hidden" name="schedule_id" id="scheduleId">

            <div class="form-group">
              <label for="firstRequirement">1st Requirement</label>
              <select name="first_requirement" id="firstRequirement" class="form-control">
                <option value="0">Not Submitted</option>
                <option value="1">Submitted</option>
              </select>
            </div>
            <div class="form-group">
              <label for="secondRequirement">2nd Requirement</label>
              <select name="second_requirement" id="secondRequirement" class="form-control">
                <option value="0">Not Submitted</option>
                <option value="1">Submitted</option>
              </select>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            <button type="submit" class="btn btn-primary">Update Requirements</button>
          </div>
        </form>
      </div>
    </div>
  </div>