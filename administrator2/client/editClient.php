<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="AddclientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="AddclientModalLabel">UPDATE CLIENT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateClientForm" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="InputFNAME">First Name</label>
              <input type="text" name="FNAME" class="form-control" id="InputFNAME" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputLNAME">Last Name</label>
              <input type="text" name="LNAME" class="form-control" id="InputLNAME" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputMIDINITIAL">Middle Initial</label>
              <input type="text" name="MIDINITIAL" class="form-control" id="InputMIDINITIAL">
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputASSOCIATION">Association</label>
              <input type="text" name="ASSOCIATION" class="form-control" id="InputASSOCIATION">
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputCONTACT_NO">Contact Number</label>
              <input type="text" name="CONTACT_NO" class="form-control" id="InputCONTACT_NO" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputADDRESS">Address</label>
              <input type="text" name="ADDRESS" class="form-control" id="InputADDRESS" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputDATE_REGISTERED">Date Registered</label>
              <input type="date" name="DATE_REGISTERED" class="form-control" id="InputDATE_REGISTERED" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>