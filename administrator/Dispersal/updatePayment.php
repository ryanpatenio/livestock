 <!-- Payment Modal -->
 <div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="paymentModalLabel">Update Payment Status</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="includes/action.php" method="post">
          <div class="modal-body">
            <input type="hidden" name="dispersal_id" id="dispersalId">
            <input type="hidden" name="payment_type" id="paymentType">
            <div class="form-group">
              <label for="paymentStatus">Select Payment Status</label>
              <select class="form-control" id="paymentStatus" name="payment_status">
                <option value="">-- Select Option --</option>
               
                <option value="1">Paid</option>
              </select>
            </div>
            <div id="paymentDetails" style="display: none;">
              <!-- Payment Details -->
              <div class="form-group">
                <label for="orPaymentNo">OR Payment No</label>
                <input type="text" class="form-control" id="orPaymentNo" name="or_payment_no">
              </div>
              <div class="form-group">
                <label for="parentId">Parent ID</label>
                <input type="number" class="form-control" id="parentId" name="parent_id">
              </div>

              <div class="form-group">
                <label for="parentId">First Payment</label>
                <input type="number" class="form-control" id="first" name="parent_id">
              </div>
              <div class="form-group">
                <label for="parentId">Second Payment</label>
                <input type="number" class="form-control" id="second" name="parent_id">
              </div>

              <div class="form-group">
                <label for="paymentDate">Date</label>
                <input type="date" class="form-control" id="paymentDate" name="date" required>
              </div>
              <div class="form-group">
                <label for="paid_by">Paid By</label>
                <input type="text" class="form-control" id="paid_by" name="paid_by" value="<?php echo htmlspecialchars($selectedClientName); ?>" readonly>
              </div>
              
              <!-- <div class="form-group">
              <label for="clientType">Select Client Type</label>
              <select class="form-control" id="clientType" name="client_type">
                <option value="existing">Existing Client</option>
                <option value="new">New Client</option>
              </select>
            </div> -->

            <!-- Existing Client Selection -->
            <div class="form-group" id="existingClientDiv">
                <label for="paid_to">Paid To:</label>
                <select name="paid_to" id="paid_to">
                  <?php foreach ($clients as $client) { ?>
                    <option value="<?= $client['CLIENT_ID']; ?>"><?= htmlspecialchars($client['full_name']); ?></option>
                  <?php } ?>
                </select>
              </div>

            <!-- New Client Input (hidden initially) -->
            <div id="newClientDiv" style="display: none;">
              <div class="form-group">
                <label for="newClientName">New Client Name</label>
                <input type="text" class="form-control" id="newClientName" name="new_client_name">
              </div>
              <div class="form-group">
                <label for="newClientContact">New Client Contact</label>
                <input type="text" class="form-control" id="newClientContact" name="new_client_contact">
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
          <button type="submit" name="btn-addPayment" class="btn btn-primary">Update</button>
        </div>
      </form>
    </div>
  </div>
</div>