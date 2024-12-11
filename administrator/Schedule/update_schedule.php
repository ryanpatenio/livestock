<?php
$host = "localhost";
$username = "root";
$password = ""; 
$database = "dispersal_db"; 

$con = new mysqli($host, $username, $password, $database);

// Check the Connection
if ($con->connect_error) {
    die("Connection Failed: " . $con->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $schedule_id = $_POST['schedule_id'];
    $first_requirement = $_POST['1st_requirement'];
    $second_requirement = $_POST['2nd_requirement'];

    if (isset($schedule_id, $first_requirement, $second_requirement)) {
        $query = "UPDATE schedule SET 1ST_REQUIREMENT = ?, 2ND_REQUIREMENT = ? WHERE SCHEDULE_ID = ?";

        // Use prepared statements to execute the query
        if ($stmt = $con->prepare($query)) { // Replace $conn with $con
            $stmt->bind_param("iii", $first_requirement, $second_requirement, $schedule_id);

            if ($stmt->execute()) {
                header("Location:../../index.php?page=Schedule");
                exit;
            } else {
                header("Location: ../../index.php?page=Schedule");
                exit;
            }
        } else {
            echo "Error preparing query: " . $con->error; // Replace $conn with $con
        }
    } else {
        echo "Invalid form data.";
    }
} else {
    echo "Invalid request method.";
}
?>
