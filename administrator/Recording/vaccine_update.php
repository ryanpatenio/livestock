<?php
require("connection/connection.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vaccine_id = $_POST['vaccine_id'];
    $updated_quantity = $_POST['updated_quantity'];

    // Update the vaccine quantity in the database
    $query = "UPDATE vaccine SET QUANTITY = ? WHERE VACCINE_ID = ?";
    if ($stmt = mysqli_prepare($con, $query)) {
        mysqli_stmt_bind_param($stmt, 'ii', $updated_quantity, $vaccine_id);
        $result = mysqli_stmt_execute($stmt);

        if ($result) {
            // Return success message
            echo json_encode(['success' => true, 'message' => 'Vaccine quantity updated.']);
        } else {
            // Return error message
            echo json_encode(['success' => false, 'message' => 'Failed to update vaccine quantity.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Database error.']);
    }
}
?>