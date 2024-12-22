<?php

// Include the database connection file
require("connection/connection.php");


// Fetch clients for the dropdown menu (assuming clients are already in the database)
$clientQuery = "SELECT CLIENT_ID, CONCAT(FNAME, ' ', LNAME) AS full_name FROM client";
$clientResult = mysqli_query($con, $clientQuery);
$clients = mysqli_fetch_all($clientResult, MYSQLI_ASSOC);

$query = "select * from vaccine_type";
$result = mysqli_query($con, $query);
$vaccineData = mysqli_fetch_all($result, MYSQLI_ASSOC);

?>


<style>
  @media print {
    #print-btn {
      display: none;
    }
    #add-btn{
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
          <h1 class="m-0 text-primary"><i class="fas fa-users"></i> Pending Schedules</h1>
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
            <h5 class="mb-0 mr-auto">
                <i class="fas fa-list"></i> Pending Schedule List
            </h5>
            <div class="d-flex justify-content-end">
                <a href="#" class="btn btn-dark btn-sm mr-2" id="add-btn" data-toggle="modal" data-target="#Add_scheduleModal">
                <i class="fas fa-plus"></i> New Request
                </a>
                <a href="#" class="btn btn-success btn-sm" onclick="printReport()" id="print-btn">
                <i class="fas fa-print"></i> Print
                </a>
            </div>
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
                    <th>Action</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                  require("connection/connection.php");
                  $query = "SELECT 
                        s.SCHEDULE_ID,
                        CONCAT(c.FNAME, ' ', c.LNAME) AS `name`,
                        s.EVENT_NAME,
                        s.EVENT_DATE,
                        s.1ST_REQUIREMENT,
                        s.2ND_REQUIREMENT,
                        CASE 
                            WHEN s.isCompleted = '1' THEN 'Approved Schedule'
                            WHEN s.1ST_REQUIREMENT = '1' and s.2ND_REQUIREMENT = '1' 
                            THEN 'Waiting for approval by Admin'
                            ELSE 'Pending'
                        END AS `sched_status`
                    FROM schedule s
                    JOIN client c ON s.CLIENT_ID = c.CLIENT_ID
                    WHERE s.`STATUS` = '0'
                    ORDER BY s.EVENT_DATE;"; 
                  $result = mysqli_query($con, $query);
                  $rows = mysqli_fetch_all($result, MYSQLI_ASSOC);

                  $i = 1;
                  foreach ($rows as $sched) { ?>
                  <tr>
                    <td><?=$i; ?></td>
                    <td><?=$sched['name']; ?></td>
                    <td><?=$sched['EVENT_NAME']; ?></td>
                    <td><?=$sched['EVENT_DATE']; ?></td>
                    <td class="<?= $sched['sched_status'] == 'Pending' || $sched['sched_status'] == 'Waiting for approval by Admin' ? 'text-danger' : 'text-success'; ?>">
                          <?= htmlspecialchars($sched['sched_status']); ?>
                    </td>
                    <td>
                      <button class="btn btn-sm btn-warning edit-btn" 
                              data-id="<?= $sched['SCHEDULE_ID']; ?>" 
                              data-1st="<?= $sched['1ST_REQUIREMENT']; ?>" 
                              data-2nd="<?= $sched['2ND_REQUIREMENT']; ?>" 
                              data-toggle="modal" 
                              data-target="#editRequirementsModal">
                      Edit
                      </button>
                      </td>
                  </tr>
                  <?php $i++; } ?>
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
include('editModal.php');
include('addModal.php');
  ?>

<script>
  document.addEventListener('DOMContentLoaded', function () {
      document.querySelectorAll('.edit-btn').forEach(function (button) {
          button.addEventListener('click', function () {
              const scheduleId = this.getAttribute('data-id');
              const firstRequirement = this.getAttribute('data-1st');
              const secondRequirement = this.getAttribute('data-2nd');

              document.getElementById('scheduleId').value = scheduleId;
              document.getElementById('firstRequirement').value = firstRequirement;
              document.getElementById('secondRequirement').value = secondRequirement;
          });
      });
  });
  </script>

<script src="../livestock2/administrator/dashboard/schedules/sched.js"></script>
<script>
  $(document).ready(function(){
  $('#scheduleTBL').dataTable({

  });

});
  function printReport() {
    window.print();
  }
</script>

