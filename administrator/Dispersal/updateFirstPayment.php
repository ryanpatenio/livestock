 <!-- Payment Modal -->
 <div class="modal fade" id="firstPaymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary text-white">
          <h5 class="modal-title" id="paymentModalLabel">Update Payment Status</h5>
          <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="dispersal_id1" id="dispersalId1">
            
            <div class="form-group">
              <label for="paymentStatus">Select Payment Status</label>
              <select class="form-control" id="paymentStatus1" name="payment_status2">
                <option value="">-- Select Option --</option>
               
                <option value="1">Paid</option>
              </select>
            </div>
            <div id="paymentDetails1" style="display: none;">
              <!-- Payment Details -->
              <div class="form-group">
                <div class="row">
                    <div class="col">
                        <label for="orPaymentNo">OR Payment No</label>
                        <input type="text" class="form-control" id="orPaymentNo" name="or_payment_no">
                    </div>
                    <div class="col">
                        <label for="parentId">Parent ID (Animal of CLIENTS (Female) )</label>
                        <select name="ANIMAL_ID" id="" class="form-control">
                        <?php
                        foreach ($animals as $animal) { ?>
                            <option value="<?=$animal['ANIMAL_ID'] ?>"> <?=$animal['ANIMALTYPE']." | ".$animal['ANIMAL_SEX'] ?></option>
                        <?php }
                  
                  ?>
                </select>
                    </div>
                </div>
                
                
              </div>
             

              <div class="form-group">
               <div class="row">
                    <div class="col">
                        <label for="parentId">First Payment</label>
                        <input type="number" class="form-control" id="first" name="parent_id">
                    </div>
                    <div class="col">
                        <label for="paymentDate">Date</label>
                        <input type="date" class="form-control" id="paymentDate" name="date" required>
                    </div>
               </div>
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

               
              </div>

              <!-- Client Type -->
                     <div class="form-group">
                        <label for="existingClient">Client Type</label>
                        <select name="existingClient" id="existingClient" class="form-control">
                            <option value="existing">Existing Client</option>
                            <option value="notexisting">Not Existing Client</option>
                        </select>
                    </div>

                    <div class="form-group" id="paidtToDiv">
                        <label for="paid_to">Paid To:</label>
                        <select name="paid_to" id="paid_to">
                        <?php foreach ($clients as $client) { ?>
                            <option value="<?= $client['CLIENT_ID']; ?>"><?= htmlspecialchars($client['full_name']); ?></option>
                        <?php } ?>
                        </select>
                    </div>
                    

                    <!-- Additional Client Info (Hidden by Default) -->
                     <div class="form-container" id="clientForm" style="display: none;">
                        <div class="row">
                            <div class="col">
                                <label>First Name:</label>
                                <input type="text" name="firstName" class="form-control" placeholder="Enter First Name">
                        
                            </div>
                            <div class="col">
                                <label>Last Name:</label>
                                <input type="text" name="lastName" class="form-control" placeholder="Enter Last Name">
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col">
                                <label>Middle Initial:</label>
                                <input type="text" name="middleInitial" class="form-control" placeholder="Enter Middle Initial">
                            </div>
                            <div class="col">
                                <label>Association:</label>
                                <input type="text" name="association" class="form-control" placeholder="Enter Association">
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <label>Contact:</label>
                                <input type="text" name="contact" class="form-control" placeholder="Enter Contact">
                            </div>
                            <div class="col">
                                <label>Address:</label>
                                <input type="text" name="address" class="form-control" placeholder="Enter Address">
                            </div>
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