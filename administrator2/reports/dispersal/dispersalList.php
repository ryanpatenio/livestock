<!-- Content Wrapper -->
<div class="content-wrapper">
  <!-- Content Header -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-1 align-items-center">
        <div class="col-sm-6">
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Dispersal Reports</h1>
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
              <h5 class="mb-0"><i class="fas fa-list"></i> Dispersal List</h5>
             
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="pendingTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Client Name</th>
                      <th>Animal Type (Received)</th>
                      <th>Animal sex</th>
                      <th>Date Received</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                      $query = "SELECT CONCAT(c.FNAME, ' ', c.LNAME) AS 'name',a.ANIMALTYPE,a.ANIMAL_SEX,a.date_created FROM client c, animal a WHERE c.CLIENT_ID = a.CLIENT_ID ORDER BY c.FNAME ASC"; 
                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                     
                    ?>
                    
                        <?php
                        $i = 1;

                        foreach ($rows as $dis) { ?>
                          <tr>
                            <td><?=$i; ?></td>
                            <td><?=$dis['name'] ?></td>
                            <td><?=$dis['ANIMALTYPE'] ?></td>
                            <td><?=$dis['ANIMAL_SEX'] ?></td>
                            <td><?=$dis['date_created']; ?></td>
                        </tr>
                      <?php $i++;  }
                        
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



<script src="../livestock2/administrator/Addclient/client.js"></script>


