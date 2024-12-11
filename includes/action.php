<?php 
session_start();
require("../connection/connection.php");

if (isset($_POST['logOutBtnStoreUser'])) {
    session_destroy();
    header("Location: ../login/login.php");
}


// ============ START ADD client BTN ============ //
if (isset($_POST['btn-addclient'])) {
    $first_name = $_POST['FNAME'];
    $last_name = $_POST['LNAME'];
    $middle_initial = $_POST['MIDINITIAL'];
    $association = $_POST['ASSOCIATION'];
    $contact_no = $_POST['CONTACT_NO'];
    $address = $_POST['ADDRESS'];
    $date_registered = $_POST['DATE_REGISTERED'];

    // QUERY FOR INSERTING NEW CLIENT
    $stmt = $con->prepare("INSERT INTO `client` (`FNAME`, `LNAME`, `MIDINITIAL`, `ASSOCIATION`, `CONTACT_NO`, `ADDRESS`, `DATE_REGISTERED`) VALUES (?,?,?,?,?,?,?)");
    $stmt->bind_param('sssssss', $first_name, $last_name, $middle_initial, $association, $contact_no, $address, $date_registered);

    if ($stmt->execute()) {
        header("Location: ../index.php?page=Clientlist");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
// ============ END ADD Client BTN ============ //

// ============ START ADD Vaccine type BTN ============ //
if (isset($_POST['btn-addvaccinetype'])) {
    $vaccine_name = $_POST['VACCINE_NAME'] ?? '';

    if (!empty($vaccine_name)) {
        // QUERY FOR INSERTING NEW VACCINE TYPE
        $stmt = $con->prepare("INSERT INTO `vaccine_type` (`VACCINE_NAME`) VALUES (?)");
        $stmt->bind_param('s', $vaccine_name);

        if ($stmt->execute()) {
            header("Location: ../index2.php?page=Dispersal");
            exit();
        } else {
            echo "Error executing SQL query: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Vaccine name cannot be empty.";
    }
}
// ============ END ADD vaccine BTN ============ //if (isset($_POST['btn-add-vaccine'])) {
if (isset($_POST['btn-add-vaccine'])) {
    $VACCINE_TYPE_ID = $_POST['VACCINE_TYPE_ID'];
    $DESCRIPTION = $_POST['DESCRIPTION'];
    $QUANTITY = $_POST['QUANTITY'];
    $EXPIRY_DATE = $_POST['EXPIRY_DATE'];

    // QUERY FOR INSERTING NEW CLIENT
    $stmt = $con->prepare("INSERT INTO `vaccine` (`VACCINE_TYPE_ID`, `DESCRIPTION`, `QUANTITY`,`EXPIRY_DATE`) VALUES (?,?,?,?)");
    $stmt->bind_param('isis', $VACCINE_TYPE_ID, $DESCRIPTION, $QUANTITY, $EXPIRY_DATE);

    if ($stmt->execute()) {
        header("Location: ../index.php?page=Inventory");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}


if (isset($_POST['btn-add-vaccine-card'])) {
    $animal_id = $_POST['ANIMAL_ID'];
    $vaccine_id = $_POST['VACCINE_ID'];
    $date = $_POST['DATE'];

    try {
        // Start transaction
        $pdo->beginTransaction();

        // Insert into vaccine_card
        $stmt = $pdo->prepare("INSERT INTO vaccine_card (VACCINE_ID, ANIMAL_ID, DATE) VALUES (?, ?, ?)");
        $stmt->bindParam(1, $vaccine_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $animal_id, PDO::PARAM_INT);
        $stmt->bindParam(3, $date, PDO::PARAM_STR);
        $stmt->execute();

        // Update vaccine quantity
        $updateStmt = $pdo->prepare("UPDATE vaccine SET QUANTITY = QUANTITY - 1 WHERE VACCINE_ID = ? AND QUANTITY > 0");
        $updateStmt->bindParam(1, $vaccine_id, PDO::PARAM_INT);
        $updateStmt->execute();

        // Commit transaction
        $pdo->commit();

        header("Location: add_vaccine_card.php");
        exit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error: " . $e->getMessage());
    }
}


// ============ END btn-add-vaccine-card============ //

// ============ START ADD dispersal BTN ============ //

if (isset($_POST['btn-dispersal'])) {
    $client = $_POST['CLIENT_ID'];
    $first_pay  = $_POST['1ST_PAYMENT_ID'];
    $second_pay = isset($_POST['2ND_PAYMENT_ID']) && !empty($_POST['2ND_PAYMENT_ID']) ? $_POST['2ND_PAYMENT_ID'] : 0; // Default to 0 if not provided
    $Status = $_POST['STATUS'];

    $stmt = $con->prepare("INSERT INTO `dispersal` (`CLIENT_ID`, `1ST_PAYMENT_ID`, `2ND_PAYMENT_ID`, `STATUS`) VALUES (?,?,?,?)");
    $stmt->bind_param('iiis', $client,  $first_pay, $second_pay, $Status);

    if ($stmt->execute()) {
        header("Location: ../index.php?page=Dispersal");
        exit();
    } else {
        echo "Error executing SQL query: " . $stmt->error;
    }
    $stmt->close();
}

// ============ END ADD dispersal BTN ============ //

// ============ START ADD CATTLE BTN ============ //
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['btn-Cattle'])) {
    $client_id = $_POST['CLIENT_ID'];
    $birthdate = $_POST['BIRTHDATE'];
    $animalType = $_POST['ANIMALTYPE'];
    $animalSex = $_POST['ANIMAL_SEX'];
    $status = $_POST['STATUS'];
    $vaccineCardId = $_POST['VACCINE_CARD_ID'];
    $image = $_FILES['IMAGE_PATH'];

    $uploadDirectory = "path_to_images/"; // Folder to save uploaded images
    if (!is_dir($uploadDirectory)) {
        mkdir($uploadDirectory, 0755, true); // Create folder if it doesn't exist
    }

    $imagePath = $uploadDirectory . basename($image['name']);
    if (move_uploaded_file($image['tmp_name'], $imagePath)) {
        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, ANIMALTYPE, ANIMAL_SEX, STATUS, VACCINE_CARD_ID, IMAGE_PATH) 
                        VALUES (?, ?, ?, ?, ?, ?, ?)";
        if ($stmt = mysqli_prepare($con, $insertQuery)) {
            mysqli_stmt_bind_param($stmt, 'issssis', $client_id, $birthdate, $animalType, $animalSex, $status, $vaccineCardId, $imagePath);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            header("Location: ../index.php?page=Recording&client_id=$client_id");
            exit();
        } else {
            echo "Error: " . mysqli_error($con);
        }
    } else {
        echo "Error uploading file.";
    }
}

mysqli_close($con);
// ============ END ADD CATTLE BTN ============ //

// ============ START ADD PAYMENT BTN ============ //
if (isset($_POST['btn-addPayment'])) {
  // Step 1: Retrieve form inputs
    $client_id = $_POST['CLIENT_ID'];
    $or_payment_no = $_POST['OR_PAYMENT_NO'];
    $payment_date = $_POST['DATE'];
    $paid_by = $client_id;
    $paid_to = $_POST['PAID_TO'];
    $dispersal_id = $_POST['dispersal_id'];
    $payment_type = $_POST['payment_type']; // 1ST_PAYMENT_ID or 2ND_PAYMENT_ID
    $animal_id = $_POST['ANIMAL_ID'];

    // Step 2: Insert payment into the `payment` table
    $paymentQuery = "INSERT INTO payment (DISPERSAL_ID, OR_PAYMENT_NO, DATE, PAID_BY, PAID_TO) 
                 VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $paymentQuery);
    mysqli_stmt_bind_param($stmt, 'iissi', $dispersal_id, $or_payment_no, $payment_date, $paid_by, $paid_to);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "Failed to record payment: " . mysqli_error($con);
        header("Location: ../index.php?page=Dispersal");
        exit();
    }

    // Step 3: Retrieve the newly inserted payment ID
    $payment_id = mysqli_insert_id($con);

    // Step 4: Update the `dispersal` table
    $paymentColumn = ($payment_type === '1ST_PAYMENT_ID') ? '1ST_PAYMENT_ID' : '2ND_PAYMENT_ID';
    $updateQuery = "UPDATE dispersal SET $paymentColumn = ? WHERE DISPERSAL_ID = ?";
    $stmt = mysqli_prepare($con, $updateQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $payment_id, $dispersal_id);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "Failed to update dispersal: " . mysqli_error($con);
        header("Location: ../index.php?page=Dispersal");
        exit();
    }

    // Step 5: Check if the parent record already exists
    $checkQuery = "SELECT PARENT_ID FROM parent WHERE CLIENT_ID = ? AND ANIMAL_ID = ?";
    $stmt = mysqli_prepare($con, $checkQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $client_id, $animal_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        // Step 6: Insert into the `parent` table if no record exists
        $insertParentQuery = "INSERT INTO parent (CLIENT_ID, ANIMAL_ID) VALUES (?, ?)";
        $stmt = mysqli_prepare($con, $insertParentQuery);
        mysqli_stmt_bind_param($stmt, 'ii', $client_id, $animal_id);

        if (!mysqli_stmt_execute($stmt)) {
            $_SESSION['error'] = "Failed to update parent table: " . mysqli_error($con);
            header("Location: ../index.php?page=Dispersal");
            exit();
        }
    }

    // Step 7: Update the status of the dispersal
    $statusQuery = "SELECT 1ST_PAYMENT_ID, 2ND_PAYMENT_ID FROM dispersal WHERE DISPERSAL_ID = ?";
    $stmt = mysqli_prepare($con, $statusQuery);
    mysqli_stmt_bind_param($stmt, 'i', $dispersal_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if ($row = mysqli_fetch_assoc($result)) {
        $firstPaid = !empty($row['1ST_PAYMENT_ID']);
        $secondPaid = !empty($row['2ND_PAYMENT_ID']);
        $newStatus = ($firstPaid && $secondPaid) ? "Completed" : "Partially Paid";

        $updateStatusQuery = "UPDATE dispersal SET STATUS = ? WHERE DISPERSAL_ID = ?";
        $stmt = mysqli_prepare($con, $updateStatusQuery);
        mysqli_stmt_bind_param($stmt, 'si', $newStatus, $dispersal_id);
        mysqli_stmt_execute($stmt);
    }

    // Redirect on success
    $_SESSION['success'] = "Payment recorded and parent table updated!";
    header("Location: ../index.php?page=Dispersal");
    exit();
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: ../index.php?page=Dispersal");
    exit();
}
$con->close();
/*END*/
//============ START ADD Vaccine card BTN ============ //
if (isset($_POST['btn-addVaccineCard'])) {
    // Step 1: Retrieve form inputs
    $vaccine_id = $_POST['vaccine_id'];
    $animal_id = $_POST['animal_id'];
    $vaccine_card_date = $_POST['date'];

    // Database connection
    require 'db_connection.php'; // Assume this includes your $con variable for DB connection

    // Step 2: Insert a record into the `vaccine_card` table
    $vaccineCardQuery = "INSERT INTO vaccine_card (VACCINE_ID, ANIMAL_ID, DATE) 
                         VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($con, $vaccineCardQuery);
    mysqli_stmt_bind_param($stmt, 'iis', $vaccine_id, $animal_id, $vaccine_card_date);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "Failed to add vaccine card: " . mysqli_error($con);
        header("Location: ../index.php?page=VaccineCard");
        exit();
    }

    // Step 3: Retrieve the newly inserted vaccine card ID
    $vaccine_card_id = mysqli_insert_id($con);

    // Step 4: Update the `animal` table with the new `VACCINE_CARD_ID`
    $updateAnimalQuery = "UPDATE animal SET VACCINE_CARD_ID = ? WHERE ANIMAL_ID = ?";
    $stmt = mysqli_prepare($con, $updateAnimalQuery);
    mysqli_stmt_bind_param($stmt, 'ii', $vaccine_card_id, $animal_id);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "Failed to update animal record: " . mysqli_error($con);
        header("Location: ../index.php?page=VaccineCard");
        exit();
    }

    // Step 5: Check if the vaccine exists in the `vaccine` table
    $checkVaccineQuery = "SELECT v.VACCINE_ID, vt.VACCINE_NAME, v.DESCRIPTION, v.QUANTITY 
                          FROM vaccine v 
                          JOIN vaccine_type vt ON v.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID 
                          WHERE v.VACCINE_ID = ?";
    $stmt = mysqli_prepare($con, $checkVaccineQuery);
    mysqli_stmt_bind_param($stmt, 'i', $vaccine_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) == 0) {
        $_SESSION['error'] = "Invalid Vaccine ID provided!";
        header("Location: ../index.php?page=VaccineCard");
        exit();
    }

    // Step 6: Fetch vaccine details and reduce stock
    $vaccine = mysqli_fetch_assoc($result);
    $quantity = $vaccine['QUANTITY'];

    $updateVaccineQuery = "UPDATE vaccine SET QUANTITY = QUANTITY - 1 WHERE VACCINE_ID = ?";
    $stmt = mysqli_prepare($con, $updateVaccineQuery);
    mysqli_stmt_bind_param($stmt, 'i', $vaccine_id);

    if (!mysqli_stmt_execute($stmt)) {
        $_SESSION['error'] = "Failed to update vaccine stock: " . mysqli_error($con);
        header("Location: ../index.php?page=VaccineCard");
        exit();
    }

    // Step 7: Handle out-of-stock notifications
    if ($quantity - 1 <= 0) {
        $_SESSION['warning'] = "Vaccine is now out of stock!";
    }

    // Redirect on success
    $_SESSION['success'] = "Vaccine card added and animal updated!";
    header("Location: ../index.php?page=VaccineCard");
    exit();
} else {
    $_SESSION['error'] = "Invalid request!";
    header("Location: ../index.php?page=VaccineCard");
    exit();
}


//============ End ADD Vaccine card BTN ============ //


// Start Send SMS Code Action //
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;
require __DIR__ . '/../vendor/autoload.php';

// Check if the form is submitted and inputs are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_number'], $_POST['message_text'])) {

    // Retrieve contact number and custom message from form
    $contactNumber = $_POST['contact_number'];
    $messageText = $_POST['message_text'];

    // Check if contact number exists in the database
    $sql = "SELECT CLIENT_ID FROM client WHERE CONTACT_NO = ?";
    $stmt = $con->prepare($sql); // Change `$conn` to `$con`
    $stmt->bind_param("s", $contactNumber);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user) {
        // Infobip API setup
        $base_url = "m3x86w.api.infobip.com"; // Replace with your actual Infobip base URL
        $api_key = "373148a73c596b524eb18caf150c2e13-14f58a45-8f07-4d7b-9b26-f358d51daedd"; // Replace with your actual Infobip API key

        $configuration = new Configuration(host: $base_url, apiKey: $api_key);
        $api = new SmsApi(config: $configuration);

        // Prepare SMS destination and message
        $destination = new SmsDestination(to: $contactNumber);
        $message = new SmsTextualMessage(
            destinations: [$destination],
            text: $messageText,
            from: "daveh"
        );

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        // Send SMS
        $response = $api->sendSmsMessage($request);

        if ($response) {
            echo "Message sent successfully via SMS.";
        } else {
            echo "Failed to send SMS.";
        }
    } else {
        echo "Contact number not found in our records.";
    }

    $stmt->close();
} else {
    echo "Please provide both a contact number and a message.";
}
// End Send SMS Code Action //


//addSchedule
