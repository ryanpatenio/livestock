
<!-- Modal for New Schedule Request -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Update Category</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form action="" id="updateCategoryForm" method="POST">
       <input type="hidden" id="cat-id" name="cat_id">
        <div class="modal-body">
          <!-- Event Name -->
          <div class="form-group">
            <label for="event_name">Category Name:</label>
            <input type="text" name="category_name" id="category-name" class="form-control" required>
          </div>
        
          
        </div>
        <div class="modal-footer">
          <button type="submit" name="" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>