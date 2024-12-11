<!-- Button to trigger modal -->

<!-- Modal -->
<div class="modal fade" id="Add_vaccine_typeModal" tabindex="-1" role="dialog" aria-labelledby="Add_vaccine_typeLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="Add_vaccine_typelLabel">Add New Vaccine Type</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="includes/action.php" method="POST" enctype="multipart/form-data">
                     <div class="form-group">
    <section class="content">
        <div class="container-fluid p-2">
            <!-- Small boxes (Stat box) -->
            <div class="row">
                <div class="col-md">
                    <form action="includes/action.php" method="POST" enctype="multipart/form-data">
                        <div class="card-body">
                            <div class="form-group">
                              <div id="preview">
                                  <img src="#" alt="Preview" id="imagePreview" style="display: none;">
                              </div>

                            <div class="form-group">
                                <label for="InputVACCINE_NAME">Vaccine Name</label>
                                <input type="text" name="VACCINE_NAME" class="form-control" id="InputVACCINE_NAME" placeholder="Enter Vaccine Name">
                            </div>
                    <button type="submit" name="btn-addvaccinetype" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
