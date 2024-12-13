
<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="AddclientModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddclientModalLabel">UPDATE CLIENT</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" method="POST" id="updateForm" enctype="multipart/form-data">
                   <input type="hidden" id="hid_client_id" value="" name="client_id">

                    <div class="form-group">
                        <label for="InputFNAME">First Name</label>
                        <input type="text" name="FNAME" class="form-control" id="edit-fname" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="InputLNAME">Last Name</label>
                        <input type="text" name="LNAME" class="form-control" id="edit-lname" placeholder="Enter Last Name" required>
                    </div>
                    <div class="form-group">
                        <label for="InputMIDINITIAL">Middle Initial</label>
                        <input type="text" name="MI" class="form-control" id="edit-mi" placeholder="Enter Middle Initial">
                    </div>
                    <div class="form-group">
                        <label for="InputASSOCIATION">Association</label>
                        <input type="text" name="ASSOC" class="form-control" id="edit-assoc" placeholder="Enter Association">
                    </div>
                    <div class="form-group">
                        <label for="InputCONTACT_NO">Contact Number</label>
                        <input type="number" name="CONTACT" class="form-control" id="edit-contact" placeholder="Enter Contact Number" required>
                    </div>
                    <div class="form-group">
                        <label for="InputADDRESS">Address</label>
                        <input type="text" name="ADDRESS" class="form-control" id="edit-address" placeholder="Enter Address" required>
                    </div>
                    <div class="form-group">
                        <label for="InputDATE_REGISTERED">Date Registered</label>
                        <input type="date" name="DATE_REGISTERED" class="form-control" id="edit-reg" placeholder="Enter Date of Registered" required>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">UPDATE</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</div>