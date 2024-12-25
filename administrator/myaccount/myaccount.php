<style>
  @media print {
    #print-btn,#add-btn {
      display: none;
    }
  }
</style>

<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-1 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> My Account</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-light p-2 rounded">
            <li class="breadcrumb-item text-dark"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Admin</li>
          </ol>
        </div>
      </div>
    </div>
  </div>

  <!-- Content Section -->
  <section class="content">
    <div class="container-fluid p-3">
      <div class="row">
        <div class="col-12">
          <div class="card shadow-lg rounded">
            <!-- Card Header -->
            <div class="card-header d-flex align-items-center bg-primary text-white">
            <h5 class="mb-0 mr-auto">
                <i class="fas fa-list"></i> Personal Account
            </h5>
            <div class="d-flex justify-content-end">
                
                
            </div>
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="userTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Name</th>
                      <th>Username</th>
                                  
                      <th>Status</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                     $user_id = $_SESSION['user_id'];
                      $query = "SELECT * FROM user WHERE ID = '$user_id' LIMIT 1;
                      ";
                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                     // foreach ($rows as $row) { 
                    ?>

                    <?php
                    $i = 1;
                    foreach ($rows as $user) { ?>
                     <tr>
                        <td><?=$i; ?></td>
                        <td><?=$user['FULL_NAME'] ?></td>
                        <td><?=$user['USERNAME'] ?></td>
                       
                        <td>
                            <button class="btn btn-sm btn-warning" id="edit-btn" data-id="<?=$user['ID'] ?>"><i class=" fa fa-edit">Edit</i></button>
                        </td>
                       
                    </tr>                      
                   <?php $i++; }
                 
                    ?>
                    
                    
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <?php 

  include('modal/editModal.php');
  ?>
  <!-- <script src="../livestock2/plugins/jquery/jquery.min.js"></script> -->
<script src="../livestock2/administrator2/myaccount/myaccount.js"></script>

<script>
   $(document).ready(function(){

    $('#main').css('filter', 'none');
    $('#loader').hide();
    
    $('#userTBL').dataTable({

    });

});
  function printReport() {
    window.print();
  }
</script>

