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
        case "Recording":
            include("administrator2/recording/recordingList.php");
            break;
        case "inventory":
            include("administrator2/inventory/inventory.php");
            break;
        case "Schedule":
            include("administrator2/Schedule/Schedulelist.php");
            break;
        case "AddSchedule":
            include("administrator2/Schedule/AddSchedule.php"); // Path to AddSchedule page
            break;
    }
} else {
    header('Location: login/login.php');
    exit();
}
?>

<?php include("includes/footer.php"); ?>

