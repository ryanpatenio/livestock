<?php //require 'connection/connection.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bg-white">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-1">
        <div class="col-sm-6 h3">
          Dashboard
        </div>
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item">Dashboard</li>
            <li class="breadcrumb-item active"></li>
          </ol>
        </div>
      </div>
    </div>
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Small Boxes Row -->
      <div class="row">
        <!-- Dispersal Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-info elevation-4">
            <div class="inner">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as dispersal_count FROM dispersal";
                $result = mysqli_query($con, $query);

                if ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <h3><?= $row['dispersal_count'] ?></h3>
              <?php } else { ?>
                  <h3>0</h3>
              <?php } 
                mysqli_close($con);
              ?>
              <p>Dispersal</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="index2.php?page=Dispersal" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Schedules Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-primary elevation-4">
            <div class="inner">
              <h3>0</h3>
              <p>Schedules</p>
            </div>
            <div class="icon">
              <i class="fas fa-calendar-alt"></i>
            </div>
            <a href="index2.php?page=schedules" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>


                      <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
            <div class="small-box bg-danger elevation-4">
              <div class="inner">
                <?php
                  // Connect to the database
                  require("connection/connection.php");

                  // Query to count the number of rows where no payments have been made (1ST_PAYMENT_ID and 2ND_PAYMENT_ID = 0)
                  $query = "SELECT COUNT(*) as unpaid_count 
                            FROM dispersal 
                            WHERE 1ST_PAYMENT_ID = 0 AND 2ND_PAYMENT_ID = 0";
                  $result = mysqli_query($con, $query);

                  // Check if query execution was successful
                  if ($result) {
                    $row = mysqli_fetch_assoc($result);
                    $unpaid_count = $row['unpaid_count'];
                  } else {
                    $unpaid_count = 0; // Default to 0 if the query fails
                  }

                  // Close the connection
                  mysqli_close($con);
                ?>
                <h3><?= $unpaid_count ?></h3>
                <p>Unpaid</p>
              </div>
              <div class="icon">
                <i class="fas fa-times-circle"></i>
              </div>
              <a href="index2.php?page=Unpaid" class="small-box-footer">
                More info <i class="fas fa-arrow-circle-right"></i>
              </a>
            </div>
          </div>
        <!-- Partially Paid Count -->
            <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
              <div class="small-box bg-warning elevation-4">
                <div class="inner">
                  <?php
                    // Connect to the database
                    require("connection/connection.php");

                    // Query to count the number of rows where STATUS is 'Partially Paid'
                    $query = "SELECT COUNT(*) as partial_count FROM dispersal WHERE STATUS = 'Partially Paid'";
                    $result = mysqli_query($con, $query);

                    // Check if query execution was successful
                    if ($result) {
                      $row = mysqli_fetch_assoc($result);
                      $partial_count = $row['partial_count'];
                    } else {
                      $partial_count = 0; // Default to 0 if the query fails
                    }

                    // Close the connection
                    mysqli_close($con);
                  ?>
                  <h3><?= $partial_count ?></h3>
                  <p>Partially Paid</p>
                </div>
                <div class="icon">
                  <i class="fas fa-hourglass-half"></i>
                </div>
                <a href="index2.php?page=PartialPayments" class="small-box-footer">
                  More info <i class="fas fa-arrow-circle-right"></i>
                </a>
              </div>
            </div>

        <!-- Fully Paid Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-success elevation-4">
            <div class="inner">
              <?php
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as full_count FROM dispersal WHERE STATUS = 'Completed'";
                $result = mysqli_query($con, $query);

                if ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <h3><?= $row['full_count'] ?></h3>
              <?php } else { ?>
                  <h3>0</h3>
              <?php } 
                mysqli_close($con);
              ?>
              <p>Fully Paid</p>
            </div>
            <div class="icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <a href="index2.php?page=FullyPaid" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Clients Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-secondary elevation-4">
            <div class="inner">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as client_count FROM client";
                $result = mysqli_query($con, $query);

                if ($row = mysqli_fetch_assoc($result)) {
              ?>
                  <h3><?= $row['client_count'] ?></h3>
              <?php } else { ?>
                  <h3>0</h3>
              <?php } 
                mysqli_close($con);
              ?>
              <p>Clients</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="index2.php?page=Clientlist" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>

<script>
  $(document).ready(function(){

    $('#main').css('filter', 'none');
    $('#loader').hide();
});
</script>
