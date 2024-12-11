<?php
require_once 'db_connection.php'; // Your database connection script

if (isset($_GET['vaccine_type_id'])) {
    $vaccine_type_id = intval($_GET['vaccine_type_id']);

    $stmt = $pdo->prepare("SELECT * FROM vaccine WHERE VACCINE_TYPE_ID = ? AND QUANTITY > 0");
    $stmt->execute([$vaccine_type_id]);
    $vaccines = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($vaccines);
}
?>
