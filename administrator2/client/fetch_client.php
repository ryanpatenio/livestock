<?php
// fetch_client.php
require("../connection/connection.php");

if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];

    // Fetch client data from the database
    $stmt = $con->prepare("SELECT * FROM client WHERE CLIENT_ID = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $client = $result->fetch_assoc();
        echo json_encode($client);
    } else {
        echo json_encode(['error' => 'Client not found.']);
    }
}
?>