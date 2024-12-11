<?php //require 'connection/connection.php' ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper bg-white">
  <!-- Content Header (Page header) -->
  <div class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1 class="m-0 text-dark">Dashboard</h1>
        </div><!-- /.col -->
        <div class="col-sm-6">
          <ol class="breadcrumb float-sm-right">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active">Dashboard</li>
          </ol>
        </div><!-- /.col -->
      </div><!-- /.row -->
    </div><!-- /.container-fluid -->
  </div>
  <!-- /.content-header -->

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <!-- Summary Cards -->
      <div class="row">
        <!-- Dispersal Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-info elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as dispersal_count FROM dispersal";
                $result = mysqli_query($con, $query);
                $dispersal_count = ($row = mysqli_fetch_assoc($result)) ? $row['dispersal_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $dispersal_count ?></h3>
              <p>Dispersal</p>
            </div>
            <div class="icon">
              <i class="fas fa-users"></i>
            </div>
            <a href="index.php?page=Dispersal" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Confirmed Schedules Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-primary elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as confirmed_count FROM schedule WHERE STATUS = 1";
                $result = mysqli_query($con, $query);
                $confirmed_count = ($row = mysqli_fetch_assoc($result)) ? $row['confirmed_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $confirmed_count ?></h3>
              <p>Confirmed Schedule Requests</p>
            </div>
            <div class="icon">
              <i class="fas fa-calendar-check"></i>
            </div>
            <a href="index.php?page=Schedules" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Pending Schedules Count -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-warning elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as pending_count FROM schedule WHERE STATUS = 0";
                $result = mysqli_query($con, $query);
                $pending_count = ($row = mysqli_fetch_assoc($result)) ? $row['pending_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $pending_count ?></h3>
              <p>Pending Schedule Requests</p>
            </div>
            <div class="icon">
              <i class="fas fa-clock"></i>
            </div>
            <a href="index.php?page=Schedules" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Unpaid Dispersal -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-danger elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as unpaid_count FROM dispersal WHERE 1ST_PAYMENT_ID = 0 AND 2ND_PAYMENT_ID = 0";
                $result = mysqli_query($con, $query);
                $unpaid_count = ($row = mysqli_fetch_assoc($result)) ? $row['unpaid_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $unpaid_count ?></h3>
              <p>Unpaid</p>
            </div>
            <div class="icon">
              <i class="fas fa-times-circle"></i>
            </div>
            <a href="index.php?page=Unpaid" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>

      <!-- Payment Row -->
      <div class="row">
        <!-- Partially Paid -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-warning elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as partial_count FROM dispersal WHERE STATUS = 'Partially Paid'";
                $result = mysqli_query($con, $query);
                $partial_count = ($row = mysqli_fetch_assoc($result)) ? $row['partial_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $partial_count ?></h3>
              <p>Partially Paid</p>
            </div>
            <div class="icon">
              <i class="fas fa-hourglass-half"></i>
            </div>
            <a href="index.php?page=PartialPayments" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Fully Paid -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-success elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as full_count FROM dispersal WHERE STATUS = 'Completed'";
                $result = mysqli_query($con, $query);
                $full_count = ($row = mysqli_fetch_assoc($result)) ? $row['full_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $full_count ?></h3>
              <p>Fully Paid</p>
            </div>
            <div class="icon">
              <i class="fas fa-check-circle"></i>
            </div>
            <a href="index.php?page=FullyPaid" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>

        <!-- Clients -->
        <div class="col-lg-3 col-md-6 col-sm-12 mb-4">
          <div class="small-box bg-secondary elevation-4">
            <div class="inner text-center">
              <?php 
                require("connection/connection.php");
                $query = "SELECT COUNT(*) as client_count FROM client";
                $result = mysqli_query($con, $query);
                $client_count = ($row = mysqli_fetch_assoc($result)) ? $row['client_count'] : 0;
                mysqli_close($con);
              ?>
              <h3><?= $client_count ?></h3>
              <p>Clients</p>
            </div>
            <div class="icon">
              <i class="fas fa-user-friends"></i>
            </div>
            <a href="index.php?page=Clientlist" class="small-box-footer">
              More info <i class="fas fa-arrow-circle-right"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </section>
  <!-- /.content -->
</div>
