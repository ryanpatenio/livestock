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
        <form action="" method="post" id="firstPaymentForm" enctype="multipart/form-data" novalidate>
          <div class="modal-body">
            <input type="hidden" name="dispersal_id1" id="dispersalId1">
            <input type="hidden" name="client_id" value="<?=$client_id; ?>">
            <input type="hidden" name="animal_type" id="animal-type-id">
          
            <div class="form-group">
              <label for="paymentStatus">Select Payment Status</label>
              <select class="form-control" id="paymentStatus1" name="payment_status2" required>
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
                        <input type="text" class="form-control" id="orPaymentNo" name="or" required>
                    </div>
                    <div class="col">
                        <label for="parentId">Parent ID (Animal of CLIENTS (Female) )</label>
                        <select name="ANIMAL_ID" id="animal_parent" class="form-control" required>
                          <option value="">Select...</option>
                          
                          <?php foreach ($animals ?? [] as $animal) { ?>
                            <option data-animal-type="<?=$animal['ANIMALTYPE']; ?>" data-animal-type-id = <?=$animal['category_id'] ?> value="<?=$animal['ANIMAL_ID'] ?>">
                                <?=$animal['ANIMALTYPE']." | ".$animal['ANIMAL_SEX'] ?>
                            </option>
                         <?php } ?>
                  
                  ?>
                </select>
                    </div>
                </div>
                
                
              </div>
             

              <div class="form-group">
               <div class="row">
                    <div class="col">
                        <label for="parentId">First Payment</label>
                        <input type="number" class="form-control" id="first" name="parent_id" value="1" readonly required>
                    </div>
                    <div class="col">
                        <label for="paymentDate">Date</label>
                        <input type="date" class="form-control" id="paymentDate" name="paymentDate" required >
                    </div>
               </div>
              </div>
              <div class="form-group">
                <div class="row">
                  <div class="col">
                    <label for="">Animal Type</label>
                    <input class="form-control" id="animal-type-to-give" readonly required>
                  </div>
                  <div class="col">
                    <label for="">Birth Day</label>
                    <input type="date" class="form-control" id="bday" name="bday" required>
                  </div>
                  
                </div>
              </div>

              <div class="form-group">
                <div class="row">
                  <div class="col">
                      <label for="">Animal Sex</label>
                      <select name="animalSex" id="" class="form-control" required>
                        <option value="Male">Male</option>
                        <option value="Female">Female</option>
                      </select>
                    </div>

                   
                    <div class="col">
                     <label for="">Image</label>
                     <input type="file" class="form-control" accept="image/*" name="animal_img" required>
                  </div>                    
                </div>
              
              </div>

              
              <div class="form-group">
                <label for="paid_by">Paid By</label>
                <input type="text" class="form-control" id="paid_by" name="paid_by" value="<?php echo htmlspecialchars($selectedClientName); ?>" readonly required>
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
                        <label for="paid_to">Give To: (Client)</label>
                        <select name="give_to" id="give_to" required>
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
                                <input type="text" name="FNAME" class="form-control" placeholder="Enter First Name" required>
                        
                            </div>
                            <div class="col">
                                <label>Last Name:</label>
                                <input type="text" name="LNAME" class="form-control" placeholder="Enter Last Name" required>
                            </div>
                        </div>
                       
                        <div class="row">
                            <div class="col">
                                <label>Middle Initial:</label>
                                <input type="text" name="MI" class="form-control" placeholder="Enter Middle Initial" required>
                            </div>
                            <div class="col">
                                <label>Association:</label>
                                <input type="text" name="ASSOC" class="form-control" placeholder="Enter Association" required>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col">
                                <label>Contact:</label>
                                <input type="text" name="CONTACT" class="form-control" placeholder="Enter Contact" required>
                            </div>
                            <div class="col">
                                <label>Address:</label>
                                <input type="text" name="ADDRESS" class="form-control" placeholder="Enter Address" required>
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