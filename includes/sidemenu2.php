
<!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-3" id="mySidebar">
    <!-- Brand Logo -->
    <div class="brand-link">
      <img src="image/user/user.jpg" alt="Espadera Logo" class="brand-image img-circle elevation-4" style="opacity: .9">
      <span class="brand-text font-weight-light">Binalbagan Dispersal</span>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <?php 
          // if ($_SESSION['USER_PHOTO'] == "") {
          //   $_SESSION['USER_PHOTO'] = "user.jpg";
          // }

           ?>
          <img src="image/user/user.jpg" class="img-circle elevation-4" alt="User Image">
        </div>
        <div class="info">
          <a href="#"role="btn" class="d-block" data-toggle="modal" data-target="#logoutAdminModal">Admin<?php //echo $_SESSION['FULLNAME'] ?></a>
        </div>
      </div>

      <?php 
        if (isset($_GET['page'])) {
          if ($_GET['page'] == "dashboard2") {
            $dashboard2 = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "Dispersal") {
            $Dispersal = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "Recording") {
            $Recording = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "inventory") {
            $inventory = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "Add_vaccine_type") {
            $vaccine_name = "bg-primary text-bold elevation-2";   
          }else if ($_GET['page'] == "addclient") {
            $clientlist = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "addCattle") {
            $Cattlelist = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "Schedule") {
            $Schedulelist = "bg-primary text-bold elevation-2";
          }else if ($_GET['page'] == "reports") {
            $reports = "bg-primary text-bold elevation-2";
          }

        }else{
           $dashboard = "bg-primary text-bold elevation-2";
        }
       ?>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column sidemenus" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item" >
            <a href="index2.php?page=dashboard2" class="nav-link <?= $dashboard2?>">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
                <!-- <i class="right fas fa-angle-left"></i> -->
              </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=Clientlist" class="nav-link <?= $clientlist?>">
              <i class="nav-icon fas fa-users"></i>
              <p>Client  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=Dispersal"  class="nav-link <?= $Dispersal?>">
              <i class="nav-icon far fa-file-alt"></i>
              <p>
                Dispersal
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=Schedule" class="nav-link <?= $Schedulelist?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Schedule  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=Cattlelist" class="nav-link <?= $Cattlelist?>">
              <i class="nav-icon fas fa-file-alt"></i>
              <p>Cattle  </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=Recording"  class="nav-link <?= $Recording?>">
              <i class="nav-icon far fa-calendar-alt"></i>
              <p>
                Recording
                </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=inventory" class="nav-link <?= $inventory?>">
              <i class="nav-icon fas fa-file"></i>
              <p>Inventory </p>
            </a>
          </li>
          <li class="nav-item">
            <a href="index2.php?page=reports" class="nav-link <?= $reports?>">
              <i class="nav-icon fas fa-file"></i>
              <p>Reports </p>
            </a>
          </li>

        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>
  <?php include('logoutAdminModal.php'); ?>

