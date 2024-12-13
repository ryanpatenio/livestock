<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">UPDATE QUANTITY</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <form id="quantityForm" method="POST">
            <input class="" type="hidden" name="vaccine_id" id="vaccine_id">

            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Vaccine Name</label>
                <input type="text"  id="vaccine-name" class="form-control"readonly>
            </div>
            <div class="form-group">
                <label for="recipient-name" class="col-form-label">Quantity</label>
                <input type="number" min="1" name="quantity" id="quantity" class="form-control" required>
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