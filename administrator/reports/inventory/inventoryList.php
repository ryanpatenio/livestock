<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-1 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Inventory Reports</h1>
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right bg-light p-2 rounded">
            <li class="breadcrumb-item text-dark"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Staff</li>
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
              <h5 class="mb-0"><i class="fas fa-list"></i> Animal List</h5>
             
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="pendingTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Vaccine Type</th>
                      <th>Description</th>
                      <th>Quantity</th>
                      <th>Expiration Date</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                      $query = "SELECT vt.VACCINE_NAME,vt.`DESCRIPTION`,v.QUANTITY,v.EXPIRY_DATE  FROM vaccine v, vaccine_type vt WHERE v.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID ORDER BY vt.VACCINE_NAME  ASC"; 
                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                     
                    ?>
                    <?php
                        $i = 1;
                        foreach ($rows as $inv) { ?>
                        <tr>
                            <td><?=$i; ?></td>
                            <td><?=$inv['VACCINE_NAME'] ?></td>
                            <td><?=$inv['DESCRIPTION'] ?></td>
                            <td><?=$inv['QUANTITY'] ?></td>
                            <td><?=$inv['EXPIRY_DATE'] ?></td>
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



<!-- <script src="../livestock2/administrator/Addclient/client.js"></script> -->


