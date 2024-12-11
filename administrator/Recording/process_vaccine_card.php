<?php
require_once 'db_connection.php'; // Your database connection script

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $animal_id = intval($_POST['animal_id']);
    $vaccine_id = intval($_POST['vaccine_id']);
    $date = $_POST['date'];

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Insert into vaccine_card
        $stmt = $pdo->prepare("INSERT INTO vaccine_card (VACCINE_ID, ANIMAL_ID, DATE) VALUES (?, ?, ?)");
        $stmt->execute([$vaccine_id, $animal_id, $date]);

        // Update vaccine quantity
        $updateStmt = $pdo->prepare("UPDATE vaccine SET QUANTITY = QUANTITY - 1 WHERE VACCINE_ID = ? AND QUANTITY > 0");
        $updateStmt->execute([$vaccine_id]);

        if ($updateStmt->rowCount() === 0) {
            // If no row was updated, rollback the transaction
            $pdo->rollBack();
            echo "Error: Not enough vaccine quantity available.";
            exit();
        }

        // Commit transaction
        $pdo->commit();
        echo "Vaccination record added successfully!";
    } catch (Exception $e) {
        $pdo->rollBack();
        echo "Error: " . $e->getMessage();
    }
}
?>