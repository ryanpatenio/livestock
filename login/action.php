<?php
session_start();
require("../connection/connection.php");
header('Content-Type: application/json');

// Retrieve and sanitize input
$username = $_POST['USERNAME'];
$password = $_POST['PASSWORD'];

// Prepare SQL query to check user credentials and fetch account type
$query = "SELECT a.ID, a.FULL_NAME, a.USERNAME, a.PASSWORD, a.ACCOUNT_TYPE_ID, att.ACCOUNT_TYPE 
          FROM `user` a 
          JOIN `account_type` att ON a.ACCOUNT_TYPE_ID = att.ACCOUNT_TYPE_ID 
          WHERE BINARY a.USERNAME = ? AND a.PASSWORD = ?";

$stmt = $con->prepare($query);
if ($stmt === false) {
    die(json_encode(array('result' => 'Error', 'message' => 'Database error: ' . $con->error)));
}

// Bind parameters and execute statement
$stmt->bind_param('ss', $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($row = $result->fetch_assoc()) {
    // Set session variables
    $_SESSION['ID'] = $row['ID'];
    $_SESSION['FULL_NAME'] = $row['FULL_NAME'];
    $_SESSION['ACCOUNT_TYPE_ID'] = $row['ACCOUNT_TYPE_ID'];
    $_SESSION['ACCOUNT_TYPE'] = $row['ACCOUNT_TYPE'];

    // Redirect based on account type
    if ($row['ACCOUNT_TYPE_ID'] == 1) {
        $href = '../index.php?page=dashboard';  // Staff dashboard
    } else if ($row['ACCOUNT_TYPE_ID'] == 2) {
        $href = '../index2.php?page=dashboard2';  // Admin dashboard
    } else {
        // Handle other account types if needed
        $href = '../index.php';  // Default redirect
    }

    echo json_encode(array('result' => 'Success', 'href' => $href));
} else {
    // Handle login failure
    echo json_encode(array('result' => 'Failed', 'message' => 'Incorrect username or password'));
}

$stmt->close();
$con->close();
?>



