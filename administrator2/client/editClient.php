<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="AddclientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="AddclientModalLabel">UPDATE CLIENT</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateClientForm" method="POST">
    <input type="hidden" id="hid_client_id" value="" name="client_id">


        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="InputFNAME">First Name</label>
              <input type="text" name="FNAME" class="form-control" id="FNAME" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputLNAME">Last Name</label>
              <input type="text" name="LNAME" class="form-control" id="LNAME" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputMIDINITIAL">Middle Initial</label>
              <input type="text" name="MI" class="form-control" id="MI">
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputASSOCIATION">Association</label>
              <input type="text" name="ASSOC" class="form-control" id="ASSOC">
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputCONTACT_NO">Contact Number</label>
              <input type="text" name="CONTACT" class="form-control" id="CONTACT" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputADDRESS">Address</label>
              <input type="text" name="ADDRESS" class="form-control" id="ADDRESS" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputDATE_REGISTERED">Date Registered</label>
              <input type="date" name="DATE_REGISTERED" class="form-control" id="DATE_REG" required>
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