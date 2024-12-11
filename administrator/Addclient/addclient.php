
<!-- Modal -->
<div class="modal fade" id="AddclientModal" tabindex="-1" role="dialog" aria-labelledby="AddclientModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="AddclientModalLabel">Add New Client</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="includes/action.php" method="POST" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="InputFNAME">First Name</label>
                        <input type="text" name="FNAME" class="form-control" id="InputFNAME" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="InputLNAME">Last Name</label>
                        <input type="text" name="LNAME" class="form-control" id="InputLNAME" placeholder="Enter Last Name" required>
                    </div>
                    <div class="form-group">
                        <label for="InputMIDINITIAL">Middle Initial</label>
                        <input type="text" name="MIDINITIAL" class="form-control" id="InputMIDINITIAL" placeholder="Enter Middle Initial">
                    </div>
                    <div class="form-group">
                        <label for="InputASSOCIATION">Association</label>
                        <input type="text" name="ASSOCIATION" class="form-control" id="InputASSOCIATION" placeholder="Enter Association">
                    </div>
                    <div class="form-group">
                        <label for="InputCONTACT_NO">Contact Number</label>
                        <input type="number" name="CONTACT_NO" class="form-control" id="InputCONTACT_NO" placeholder="Enter Contact Number" required>
                    </div>
                    <div class="form-group">
                        <label for="InputADDRESS">Address</label>
                        <input type="text" name="ADDRESS" class="form-control" id="InputADDRESS" placeholder="Enter Address" required>
                    </div>
                    <div class="form-group">
                        <label for="InputDATE_REGISTERED">Date Registered</label>
                        <input type="date" name="DATE_REGISTERED" class="form-control" id="InputDATE_REGISTERED" placeholder="Enter Date of Registered" required>
                    </div>
                    <button type="submit" name="btn-addclient" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>