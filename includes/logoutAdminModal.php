  <!-- Logout Modal-->
  <div class="modal fade" id="logoutAdminModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h4 class="modal-title" id="exampleModalLabel">Ready to Leave?</h4>
          <button class="close text-white" type="button" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">×</span>
          </button>
        </div>
        <div class="modal-body h5">Select <b>"Log Out"</b> below if you are ready to end your current session.</div>
        <form method="post" action="includes/action.php" ><hr>
          <div class="row">
            <div class="col d-flex mb-2" >
              <button class="btn btn-secondary elevation-2 ml-auto mr-2" type="button" data-dismiss="modal">Cancel</button>
              <button class="btn btn-success elevation-2 mr-2" type="submit" name="logOutBtnStoreUser">Log Out</button></div>
          </div>
        </form>
        <div class="modal-footer bg-primary">

        </div>
      </div>
    </div>
  </div>
