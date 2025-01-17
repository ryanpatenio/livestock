
<!-- Modal for New Schedule Request -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="addModal" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title">Create New User</h5>
        <button type="button" class="close text-white" data-dismiss="modal">&times;</button>
      </div>
      <form action="" id="updateUserForm" method="POST">
        <input type="hidden" name="user_id" id="user-id">
        <div class="modal-body">
          <!-- Event Name -->
          <div class="form-group">
            <label for="event_name">Full Name:</label>
            <input type="text" name="fullname" id="full-name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="event_name">Username:</label>
            <input type="text" name="username" id="user-name" class="form-control" required>
          </div>
          <div class="form-group">
            <label for="event_name">Password:</label>
            <input type="password" name="password" id="pass-word" class="form-control" required>
          </div>
          <!-- account type -->
          <div class="form-group">
            <label for="account">Account Type:</label>
            <select name="account_type" id="account-type" class="form-control" required>
              <option value="" id="get-account-type"></option>
            <?php
            foreach ($rows as $acc) { ?>
               <option value="<?=$acc['ID'] ?>"><?=$acc['ACCOUNT_TYPE'] ?></option>
           <?php }
            
            ?>
            </select>
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