<!-- Modal for New Schedule Request -->
<div class="modal fade" id="Add_scheduleModal" tabindex="-1" aria-labelledby="AddScheduleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Create New Schedule Request</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form action="" id="addScheduleForm" method="POST">
        <div class="modal-body">
          <!-- Event Name -->
          <div class="form-group">
            <label for="event_name">Event Name:</label>
            <input type="text" name="event_name" id="event_name" class="form-control" required>
          </div>
          <!-- Event Date -->
          <div class="form-group">
            <label for="event_date">Event Date:</label>
            <input type="date" name="event_date" id="event_date" class="form-control" required>
          </div>
          <!-- Client Selection -->
          <div class="form-group">
            <label for="client_id">Client:</label>
            <select name="client_id" id="client_id" class="form-control" required>
              <option value="">Select Client</option>
              <?php foreach ($clients as $client) { ?>
                <option value="<?= $client['CLIENT_ID']; ?>"><?= htmlspecialchars($client['full_name']); ?></option>
              <?php } ?>
            </select>
          </div>
          <!-- Requirements -->
          <div class="form-row">
            <div class="form-group col-md-6">
              <label for="first_requirement">1st Requirement:</label>
              <select name="first_requirement" id="first_requirement" class="form-control" required>
                <option value="0">Not Submitted</option>
                <option value="1">Submitted</option>
              </select>
            </div>
            <div class="form-group col-md-6">
              <label for="second_requirement">2nd Requirement:</label>
              <select name="second_requirement" id="second_requirement" class="form-control" required>
                <option value="0">Not Submitted</option>
                <option value="1">Submitted</option>
              </select>
            </div>
          </div>

          <div class="form-group">
            <label for="status">Vaccine:</label>
            <select name="vaccine_TYPE_ID" id="vacc" class="form-control" required>
              
                <?php foreach ($vaccineData as $vacc) { ?>
                  <option 
                      value="<?= $vacc['VACCINE_TYPE_ID'] ?>" 
                      <?= $vacc['QUANTITY_DISPLAY'] == 0 ? 'style="color: red;"' : '' ?>>
                      <?= $vacc['VACCINE_NAME'] . ' | ' . $vacc['DESCRIPTION'] . ' | Remaining Quantity (' . $vacc['QUANTITY_DISPLAY'] . ')' ?>
                  </option>
               <?php } ?>
              
            </select>
          </div>
          
          <div class="form-group">
            <div class="row">
              <div class="col">
                <label for="status">Qty</label>
                <input type="number" class="form-control" name="qty" required>
              </div>
              <div class="col">
                <label for="status">Status:</label>
                  <select name="status" id="status" class="form-control" required>
                    <option value="0">Pending</option>
                    <!-- <option value="1">Confirmed</option>
                    <option value="2">Cancelled</option> -->
                  </select>
              </div>
            </div>           
          </div>
         
        </div>
        <div class="modal-footer">
          <button type="submit" name="" class="btn btn-primary">Submit Schedule</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>