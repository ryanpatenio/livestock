<?php
session_start();
//@note 2 = STAFF 1 = ADMIN
if (!isset($_SESSION['account_type']) || $_SESSION['account_type'] != 2) {
    header('Location: login/login.php');
    exit();
}
?>

<?php include("includes/header.php"); ?>
<?php include("includes/nav.php"); ?>
<?php include("includes/sidemenu.php"); ?>

<?php
if (isset($_GET['page'])) {
    $pagename = $_GET['page'];

    switch ($pagename) {
        case "dashboard":
            include("administrator/dashboard/dashboard.php");
            break;
        case "inventory":
            include("administrator/inventory/Inventory.php");
            break;
        case "viewInventory":
            include("administrator/inventory/viewInventory.php");
            break;
        case "Dispersal":
            include("administrator/Dispersal/Dispersal_list.php");
            break;
        case "Add_vaccine_type":
            include("administrator/Add_vaccine_type/Add_vaccine_type.php");
            break;
        case "reports":
            include("administrator/reports/reports.php");
            break;
        case "Clientlist":
            include("administrator/Addclient/Clientlist.php");
            break;
        case "Schedule":
            include("administrator/Schedule/Schedulelist.php");
            break;
        case "Schedulelist":
            include("administrator/Schedule/update_schedule.php");
            break;
        case "Recording" :
            include("administrator/Recording/Recording.php");
            break;

        //dashboard breadcrumbs
        case "dispersalDashboard":
            include("administrator/dashboard/dispersal/dispersalList.php"); // 
            break;
        case "confirmSchedules":
            include("administrator/dashboard/schedules/confirm.php"); // 
            break;
        case "pendingSchedules":
            include("administrator/dashboard/schedules/pending.php"); // 
            break;
        case "unpaid":
            include("administrator/dashboard/unpaid/unpaidList.php"); // 
            break;
        case "PartialPayments":
            include("administrator/dashboard/partial/partial.php"); // 
            break;
        case "FullyPaid":
            include("administrator/dashboard/fullypaid/fully.php"); // 
            break;


            //reports    
        case "AnimalReports":
            include("administrator/reports/animals/animalList.php"); // 
            break;
        case "ScheduleReports":
            include("administrator/reports/schedule/scheduleList.php"); // Path 
            break;
        case "InventoryReports":
            include("administrator/reports/inventory/inventoryList.php"); // Path 
            break;
        case "DispersalReports":
            include("administrator/reports/dispersal/dispersalList.php"); // Path 
            break;
        case "PaymentReports":
            include("administrator/reports/payment/paymentList.php"); // Path 
            break;

        //my Account
        case "MyAccount":
            include("administrator/myaccount/myaccount.php"); // Path 
            break;
    }
} else {
    header('Location: login/login.php');
    exit();
}
?>

<?php include("includes/footer.php"); ?>
