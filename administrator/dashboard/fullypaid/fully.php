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
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Payment Reports</h1>
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
              <h5 class="mb-0"><i class="fas fa-list"></i> List of Fulyy Paid Clients</h5>
              <a href="#" class="btn btn-success ml-auto" onclick="printReport()" id="print-btn">
                <i class="fas fa-print"></i> Print
              </a>
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="paymentTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Dispersal ID</th>
                      <th>Client Name</th>
                      <th>Animal Type</th>
                      <th>First Payment</th>
                      <th>Second Payment</th>
                      <th>Status</th>
                  
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                    //   $query = "SELECT 
                    //         d.DISPERSAL_ID, 
                    //         CONCAT(c.FNAME, ' ', c.LNAME) AS 'name',
                            
                    //         GROUP_CONCAT(DISTINCT a.ANIMALTYPE SEPARATOR ', ') AS 'animal_types',
                    //         CASE 
                    //             WHEN d.1ST_PAYMENT_ID = '1' THEN d.DATE_FIRST_PAYMENT 
                    //             ELSE '' 
                    //         END AS 'first_payment',
                    //         CASE 
                    //             WHEN d.2ND_PAYMENT_ID = '1' THEN d.DATE_SECOND_PAYMENT 
                    //             ELSE '' 
                    //         END AS 'second_payment',
                    //         CASE 
                    //             WHEN d.`STATUS` = 'PENDING' THEN 'Partial' 
                    //             ELSE 'Completed' 
                    //         END AS 'status'
                    //         FROM 
                    //         dispersal d
                    //         JOIN 
                    //         client c ON d.CLIENT_ID = c.CLIENT_ID
                    //         JOIN 
                    //         animal a ON c.CLIENT_ID = a.CLIENT_ID
                    //         GROUP BY 
                    //         d.DISPERSAL_ID, c.FNAME, c.LNAME, d.1ST_PAYMENT_ID, d.DATE_FIRST_PAYMENT, d.2ND_PAYMENT_ID, d.DATE_SECOND_PAYMENT, d.`STATUS`;
                    //         "; 
                      $query = "
                        SELECT d.DISPERSAL_ID, CONCAT(c.FNAME, ' ',c.LNAME) AS 'name',a.ANIMALTYPE,case when d.1ST_PAYMENT_ID = '1' then d.DATE_FIRST_PAYMENT ELSE '' end AS 'first_payment' , case when d.2ND_PAYMENT_ID = '1' then d.DATE_SECOND_PAYMENT ELSE '' END AS 'second_payment', case when d.STATUS = 'PENDING' then 'Partial' ELSE 'Completed' END AS 'status' FROM dispersal d,client c,animal a 
                        WHERE
                        d.CLIENT_ID = c.CLIENT_ID AND d.PARENT_ANIMAL_ID = a.ANIMAL_ID 
                        and d.1ST_PAYMENT_ID != '0' and d.2ND_PAYMENT_ID != '0'
                      ";
                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                     // foreach ($rows as $row) { 
                    ?>

                    <?php
                    $i = 1;
                    foreach ($rows as $pay) { ?>
                     <tr>
                        <td><?=$i; ?></td>
                        <td><?=$pay['DISPERSAL_ID'] ?></td>
                        <td><?=$pay['name'] ?></td>
                        <td><?=$pay['ANIMALTYPE'] ?></td>
                        <td><?=$pay['first_payment'] ?></td>
                        <td><?=$pay['second_payment'] ?></td>
                        <td class="<?=$pay['status'] == 'Partial' ? 'text-danger' : 'text-success'; ?>"><?=$pay['status'] ?></td>
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

<script>
   $(document).ready(function(){

    $('#main').css('filter', 'none');
    $('#loader').hide();
    
    $('#paymentTBL').dataTable({

    });

});
  function printReport() {
    window.print();
  }
</script>

