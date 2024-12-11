<?php
// Update Client Data
require("../connection/connection.php");

if (isset($_POST['btn-updateclient'])) {
    // Retrieve form data
    $client_id = $_GET['client_id'];  // Assuming client_id is passed in the URL
    $first_name = $_POST['FNAME'];
    $last_name = $_POST['LNAME'];
    $middle_initial = $_POST['MIDINITIAL'];
    $association = $_POST['ASSOCIATION'];
    $contact_no = $_POST['CONTACT_NO'];
    $address = $_POST['ADDRESS'];
    $date_registered = $_POST['DATE_REGISTERED'];

    // Prepare the update query
    $stmt = $con->prepare("UPDATE client SET FNAME = ?, LNAME = ?, MIDINITIAL = ?, ASSOCIATION = ?, CONTACT_NO = ?, ADDRESS = ?, DATE_REGISTERED = ? WHERE CLIENT_ID = ?");
    $stmt->bind_param('sssssssi', $first_name, $last_name, $middle_initial, $association, $contact_no, $address, $date_registered, $client_id);

    // Execute the query
    if ($stmt->execute()) {
        // Redirect back to the client list page
        header("Location: index.php?page=Clientlist");
        exit;
    } else {
        // If an error occurred, display the error
        echo "Error updating record: " . $stmt->error;
    }
}
?>