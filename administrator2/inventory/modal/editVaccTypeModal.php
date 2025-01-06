<div class="modal fade" id="editVaccTypeModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">UPDATE Vaccine Type</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="updateVaccTypeForm" method="POST">
            <input class="" type="hidden" name="vaccine_type_id" id="vaccine-type-id">

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Vaccine Name</label>
                <input type="text" name="vaccine_type_name"  id="vaccine-type-name" class="form-control" required>
            </div>
            <div class="form-group">
                <label for="" class="col-form-label">Description</label>
               <textarea name="description" id="edit-description" class="form-control">
                  
               </textarea>
            </div>
            
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary">UPDATE</button>
        </div>
      </form>
    </div>
  </div>
</div>