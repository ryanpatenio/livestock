
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require("connection/connection.php");
if (isset($_GET['client_id'])) {
    $clientId = $_GET['client_id'];
    
    // Fetch animals linked to the client
    $stmt = $con->prepare("SELECT ANIMAL_ID, NAME FROM animal WHERE CLIENT_ID = ?");
    $stmt->bind_param("i", $clientId);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $animals = [];
    while ($row = $result->fetch_assoc()) {
        $animals[] = $row;
    }
    
    $stmt->close();
    echo json_encode($animals); // Return JSON format
}

$con->close();