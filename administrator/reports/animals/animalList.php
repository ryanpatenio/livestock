<style>
  @media print {
    #print-btn {
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
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Animal Reports</h1>
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
              <h5 class="mb-0"><i class="fas fa-list"></i> Animal List Reports</h5>
              <a href="#" class="btn btn-success ml-auto" onclick="printReport()" id="print-btn">
                <i class="fas fa-print"></i> Print
              </a>
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="animalTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Animal Type</th>
                      <th>Sex</th>
                      <th>Birth Day</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                      $query = "SELECT c.category_name as ANIMALTYPE, a.ANIMAL_SEX,a.BIRTHDATE, 

                      case
	                          when a.`STATUS` = 1 then 'Alive' ELSE 'Dead' END AS animal_status 
                      FROM animal a, category c 
                      WHERE a.category_id = c.category_id 
                            ORDER BY c.category_name AND a.ANIMAL_SEX ASC
                      "; 

                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                      
                    ?>

                    <?php
                    $i = 1;
                    foreach ($rows as $animal) { ?>
                       
                    <tr>
                        <td><?=$i; ?></td>
                      <td><?=$animal['ANIMALTYPE'] ?></td>
                      <td><?=$animal['ANIMAL_SEX'] ?></td>
                      <td><?=$animal['BIRTHDATE'] ?></td>
                      <td style="<?= $animal['animal_status'] == 'Dead' ? 'color: red;' : 'color:green;'; ?>">
                          <?= $animal['animal_status']; ?>
                      </td>
                    </tr>

                 <?php $i++;   }
                    
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


<!-- Add Client Modal -->
<div class="modal fade" id="AddclientModal" tabindex="-1" aria-labelledby="AddclientModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="AddclientModalLabel">Add New Client</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="addClientForm" method="POST">
        <div class="modal-body">
          <div class="row">
            <div class="col-md-6 mb-3">
              <label for="InputFNAME">First Name</label>
              <input type="text" name="FNAME" class="form-control" id="InputFNAME" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputLNAME">Last Name</label>
              <input type="text" name="LNAME" class="form-control" id="InputLNAME" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputMIDINITIAL">Middle Initial</label>
              <input type="text" name="MIDINITIAL" class="form-control" id="InputMIDINITIAL">
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputASSOCIATION">Association</label>
              <input type="text" name="ASSOCIATION" class="form-control" id="InputASSOCIATION">
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputCONTACT_NO">Contact Number</label>
              <input type="text" name="CONTACT_NO" class="form-control" id="InputCONTACT_NO" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputADDRESS">Address</label>
              <input type="text" name="ADDRESS" class="form-control" id="InputADDRESS" required>
            </div>
            <div class="col-md-6 mb-3">
              <label for="InputDATE_REGISTERED">Date Registered</label>
              <input type="date" name="DATE_REGISTERED" class="form-control" id="InputDATE_REGISTERED" required>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Save</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  $(document).ready(function(){
  $('#animalTBL').dataTable({

  });

});
  function printReport() {
    window.print();
  }
</script>

