<?php
   session_start();
   if (!isset($_SESSION['ACCOUNT_TYPE_ID']) || $_SESSION['ACCOUNT_TYPE_ID'] != 2) {
      header('Location: login/login.php');
   }  
   ?>

<?php include("includes/header2.php"); ?>
<?php include("includes/nav2.php"); ?>
<?php include("includes/sidemenu2.php"); ?>

<?php
if (isset($_GET['page'])) {
    $pagename = $_GET['page'];

    switch ($pagename) {
        case "dashboard2":
            include("administrator2/dashboard/dashboard2.php");
            break;
        case "clientList2":
            include("administrator2/client/clientList2.php");
            break;
        case "Dispersal":
            include("administrator2/dispersal/Dispersal_list.php");
            break;
        case "Recording":
            include("administrator2/recording/recordingList.php");
            break;
        case "inventory":
            include("administrator2/inventory/inventory.php");
            break;
        case "viewInventory":
            include("administrator2/inventory/viewInventory.php");
            break;
        case "Schedule":
            include("administrator2/Schedule/Schedulelist.php");
            break;
        case "AddSchedule":
            include("administrator2/Schedule/AddSchedule.php"); // Path to AddSchedule page
            break;

            //dashboard Breadcrumbs
        case "unpaid":
            include("administrator2/dashboard/unpaid/unpaidList.php"); // Path to AddSchedule page
            break;
        case "PartialPayments":
            include("administrator2/dashboard/partial/partial.php"); // Path to AddSchedule page
            break;
        case "FullyPaid":
            include("administrator2/dashboard/fullypaid/fully.php"); // Path to AddSchedule page
            break;
        case "confirmSchedules":
            include("administrator2/dashboard/schedules/confirm.php"); // Path to AddSchedule page
            break;
        case "pendingSchedules":
            include("administrator2/dashboard/schedules/pending.php"); // Path to AddSchedule page
            break;
        case "dashboardDispersal":
            include("administrator2/dashboard/dispersal/dispersalList.php"); // Path to AddSchedule page
            break;
            
            //reports
           
        case "AnimalReports":
            include("administrator2/reports/animals/animalList.php"); // 
            break;
        case "ScheduleReports":
            include("administrator2/reports/schedule/scheduleList.php"); // Path 
            break;
        case "InventoryReports":
            include("administrator2/reports/inventory/inventoryList.php"); // Path 
            break;
        case "DispersalReports":
            include("administrator2/reports/dispersal/dispersalList.php"); // Path 
            break;
        case "PaymentReports":
            include("administrator2/reports/payment/paymentList.php"); // Path 
            break;

        //Users
        case "Users":
            include("administrator2/users/userList.php"); // Path 
            break;

        //my Account
        case "MyAccount":
            include("administrator2/myaccount/user_account.php"); // Path 
            break;


    }
} else {
    header('Location: login/login.php');
    exit();
}
?>

<?php include("includes/footer.php"); ?>

