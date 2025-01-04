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
                <img src="image/user/user.jpg" class="img-circle elevation-4" alt="User Image">
            </div>
            <div class="info">
                <a href="#" role="btn" class="d-block" data-toggle="modal" data-target="#logoutAdminModal">Admin</a>
            </div>
        </div>

        <?php 
            if (isset($_GET['page'])) {
                if ($_GET['page'] == "dashboard2") { $dashboard2 = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "Dispersal") { $Dispersal = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "Recording") { $Recording = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "inventory") { $inventory = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "Add_vaccine_type") { $vaccine_name = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "addclient") { $clientlist = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "addCattle") { $Cattlelist = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "Schedule") { $Schedulelist = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "reports") { $reports = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "category") { $category = "bg-primary text-bold elevation-2"; }

                else if ($_GET['page'] == "ScheduleReports") { $sched = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "InventoryReports") { $inven = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "DispersalReports") { $dispersal = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "PaymentReports") { $payment = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "AnimalReports") { $animal = "bg-primary text-bold elevation-2"; }

                else if ($_GET['page'] == "Users") { $Users = "bg-primary text-bold elevation-2"; }
                else if ($_GET['page'] == "MyAccount") { $myAccount = "bg-primary text-bold elevation-2"; }
            } else { $dashboard = "bg-primary text-bold elevation-2"; }
        ?>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column sidemenus" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="index2.php?page=dashboard2" class="nav-link <?= $dashboard2 ?>">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=clientList2" class="nav-link <?= $clientlist ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Client</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=Dispersal" class="nav-link <?= $Dispersal ?>">
                        <i class="nav-icon far fa-file-alt"></i>
                        <p>Dispersal</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=Schedule" class="nav-link <?= $Schedulelist ?>">
                        <i class="nav-icon fas fa-file-alt"></i>
                        <p>Schedule</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=Recording" class="nav-link <?= $Recording ?>">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Recording</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=inventory" class="nav-link <?= $inventory ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Inventory</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=category" class="nav-link <?= $category ?>">
                        <i class="nav-icon fas fa-file"></i>
                        <p>Category</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="index2.php?page=Users" class="nav-link <?= $Users ?>">
                        <i class="nav-icon fas fa-users"></i>
                        <p>Users</p>
                    </a>
                </li>
                <!-- Dropdown Menu for Recording -->
                <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle <?= $reports ?>" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="nav-icon far fa-calendar-alt"></i>
                        <p>Reports</p>
                    </a>
                    <div class="dropdown-menu bg-secondary text-white pl-3">
                        <a href="index2.php?page=AnimalReports" class="dropdown-item  mt-2">Animals </a>
                        <a href="index2.php?page=ScheduleReports" class="dropdown-item mt-2">Schedule </a>
                        <a href="index2.php?page=InventoryReports" class="dropdown-item  mt-2">Inventory </a>
                        <a href="index2.php?page=DispersalReports" class="dropdown-item mt-2 ">Dispersals </a>
                        <a href="index2.php?page=PaymentReports" class="dropdown-item  mt-2>">Payments </a>
                       
                    </div>
                </li>

                <!---MY PERSONAL ACCOUNT--->
                <li class="nav-item">
                    <a href="index2.php?page=MyAccount" class="nav-link <?= $myAccount ?>">
                        <i class="nav-icon fas fa-user"></i>
                        <p>My Account</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>

<!-- Include the logout modal -->
<?php include('logoutAdminModal.php'); ?>
<style>
  /* Change text color to black when hovering over dropdown items */
  .dropdown-menu .dropdown-item:hover {
      background-color:rgb(221, 223, 225); /* Darker grey background */
      color: black !important; /* Text turns black on hover */
  }
</style>