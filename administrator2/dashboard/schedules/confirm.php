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
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i>Approved Schedule</h1>
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
              <h5 class="mb-0"><i class="fas fa-list"></i>Approved Schedule List</h5>
              <a href="#" class="btn btn-success ml-auto" onclick="printReport()" id="print-btn">
                <i class="fas fa-print"></i> Print
              </a>
            </div>

            <!-- Card Body -->
            <div class="card-body">
              <div class="table-responsive">
                <table id="scheduleTBL" class="table table-striped table-hover table-bordered">
                  <thead class="thead-dark">
                    <tr>
                      <th>#</th>
                      <th>Client Name</th>
                      <th>Event Name</th>
                      <th>Event Date</th>
                      <th>Status</th>
                      
                    </tr>
                  </thead>
                  <tbody>
                    <?php 
                     require("connection/connection.php");
                      $query = "SELECT 
                        CONCAT(c.FNAME, ' ', c.LNAME) AS `name`,
                        s.EVENT_NAME,
                        s.EVENT_DATE,
                        CASE 
                            WHEN s.STATUS = '1' THEN 'Approved Schedule'
                            ELSE 'Pending'
                        END AS `sched_status`
                    FROM schedule s
                    JOIN client c ON s.CLIENT_ID = c.CLIENT_ID
                    WHERE s.`STATUS` = '1'
                    ORDER BY s.EVENT_DATE;
                            "; 
                      $result = mysqli_query($con, $query);
                      $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
                   
                    ?>

                    <?php
                    $i = 1;
                    foreach ($rows as $sched) { ?>
                   <tr>
                      <td><?=$i; ?></td>
                      <td><?=$sched['name']; ?></td>
                      <td><?=$sched['EVENT_NAME']; ?></td>
                      <td><?=$sched['EVENT_DATE']; ?></td>
                      <td class="<?= $sched['sched_status'] == 'Pending' ? 'text-danger' : 'text-success'; ?>">
                            <?= htmlspecialchars($sched['sched_status']); ?>
                      </td>

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

<!-- <script src="../livestock2/administrator/Addclient/client.js"></script> -->
<script>
  $(document).ready(function(){
    $('#main').css('filter', 'none');
    $('#loader').hide();

  $('#scheduleTBL').dataTable({

  });

});
  function printReport() {
    window.print();
  }
</script>

