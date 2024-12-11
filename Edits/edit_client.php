<?php
// Include database connection
require("../connection/connection.php");

// Check if CLIENT_ID is provided in the URL
if (isset($_GET['client_id'])) {
    $client_id = $_GET['client_id'];

    // Fetch existing client data
    $stmt = $con->prepare("SELECT * FROM client WHERE CLIENT_ID = ?");
    $stmt->bind_param("i", $client_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $client = $result->fetch_assoc();

    if (!$client) {
        echo "Client not found.";
        exit;
    }
} else {
    echo "No client selected.";
    exit;
}

// Handle form submission to update client data
if (isset($_POST['btn-updateclient'])) {
    $first_name = $_POST['FNAME'];
    $last_name = $_POST['LNAME'];
    $middle_initial = $_POST['MIDINITIAL'];
    $association = $_POST['ASSOCIATION'];
    $contact_no = $_POST['CONTACT_NO'];
    $address = $_POST['ADDRESS'];
    $date_registered = $_POST['DATE_REGISTERED'];

    // Update query
    $stmt = $con->prepare("UPDATE client SET FNAME=?, LNAME=?, MIDINITIAL=?, ASSOCIATION=?, CONTACT_NO=?, ADDRESS=?, DATE_REGISTERED=? WHERE CLIENT_ID=?");
    $stmt->bind_param('sssssssi', $first_name, $last_name, $middle_initial, $association, $contact_no, $address, $date_registered, $client_id);

    if ($stmt->execute()) {
        header("Location: ../index.php?page=Clientlist");
    } else {
        echo "Error updating record: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Client</title>
    <!-- Add Bootstrap or other CSS as needed -->
</head>
<body>
<div class="container">
    <h2>Edit Client</h2>
    <form action="" method="POST">
        <div class="form-group">
            <label for="InputFNAME">First Name</label>
            <input type="text" name="FNAME" class="form-control" id="InputFNAME" value="<?php echo $client['FNAME']; ?>" required>
        </div>
        <div class="form-group">
            <label for="InputLNAME">Last Name</label>
            <input type="text" name="LNAME" class="form-control" id="InputLNAME" value="<?php echo $client['LNAME']; ?>" required>
        </div>
        <div class="form-group">
            <label for="InputMIDINITIAL">Middle Initial</label>
            <input type="text" name="MIDINITIAL" class="form-control" id="InputMIDINITIAL" value="<?php echo $client['MIDINITIAL']; ?>">
        </div>
        <div class="form-group">
            <label for="InputASSOCIATION">Association</label>
            <input type="text" name="ASSOCIATION" class="form-control" id="InputASSOCIATION" value="<?php echo $client['ASSOCIATION']; ?>">
        </div>
        <div class="form-group">
            <label for="InputCONTACT_NO">Contact Number</label>
            <input type="text" name="CONTACT_NO" class="form-control" id="InputCONTACT_NO" value="<?php echo $client['CONTACT_NO']; ?>" required>
        </div>
        <div class="form-group">
            <label for="InputADDRESS">Address</label>
            <input type="text" name="ADDRESS" class="form-control" id="InputADDRESS" value="<?php echo $client['ADDRESS']; ?>" required>
        </div>
        <div class="form-group">
            <label for="InputDATE_REGISTERED">Date Registered</label>
            <input type="date" name="DATE_REGISTERED" class="form-control" id="InputDATE_REGISTERED" value="<?php echo $client['DATE_REGISTERED']; ?>" required>
        </div>
        <button type="submit" name="btn-updateclient" class="btn btn-primary">Update Client</button>
        <a href="index.php?page=Clientlist" class="btn btn-secondary">Cancel</a>
    </form>
</div>
</body>
</html>
<style>
.container {
    max-width: 600px;
    margin: 50px auto;
    padding: 20px;
    background-color: #f8f9fa;
    box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
    border-radius: 8px;
}

/* Page title */
.container h2 {
    text-align: center;
    font-size: 24px;
    color: #343a40;
    margin-bottom: 20px;
    font-weight: bold;
}

/* Styling form labels */
.form-group label {
    font-size: 16px;
    color: #495057;
    font-weight: 600;
}

/* Styling form input fields */
.form-group input[type="text"],
.form-group input[type="date"] {
    width: 100%;
    padding: 10px;
    font-size: 14px;
    border-radius: 5px;
    border: 1px solid #ced4da;
    box-sizing: border-box;
}

.form-group input:focus {
    border-color: #80bdff;
    outline: none;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.25);
}

/* Button styling */
.btn {
    padding: 10px 20px;
    font-size: 16px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-primary {
    background-color: #007bff;
    border: none;
    color: #fff;
}

.btn-primary:hover {
    background-color: #0056b3;
}

.btn-secondary {
    background-color: #6c757d;
    border: none;
    color: #fff;
    margin-left: 10px;
}

.btn-secondary:hover {
    background-color: #5a6268;
}

/* Margin between form elements */
.form-group {
    margin-bottom: 15px;
}

/* Responsive styling */
@media (max-width: 768px) {
    .container {
        margin: 20px;
        padding: 15px;
    }

    .btn {
        font-size: 14px;
    }
}
</style>