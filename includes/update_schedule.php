<?php
// Include Composer's autoloader
require __DIR__ . '/../vendor/autoload.php';

// Include your database connection file (adjust path if necessary)
require("../connection/connection.php");

// Use the Infobip API classes
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['schedule_id'], $_POST['event_date'])) {
    $scheduleId = intval($_POST['schedule_id']);
    $eventDate = $_POST['event_date'];

    // Debugging: Print out schedule_id and event_date
    echo "Schedule ID: " . $scheduleId . "<br>";
    echo "Event Date: " . $eventDate . "<br>";

    // Approve schedule in the database
    $updateQuery = "UPDATE schedule SET STATUS = 1 WHERE SCHEDULE_ID = ?";
    $stmt = $con->prepare($updateQuery);

    // Check if the query preparation is successful
    if (!$stmt) {
        die("Query preparation failed: " . $con->error);
    }

    $stmt->bind_param("i", $scheduleId);
    if (!$stmt->execute()) {
        die("Error executing query: " . $stmt->error);
    }

    // Debugging: Check if the query was successful
    if ($stmt->affected_rows > 0) {
        echo "Schedule updated successfully.<br>";
    } else {
        echo "Failed to approve the schedule. No rows affected.<br>";
    }

    // Fetch client contact number and event details
    $query = "
        SELECT client.CONTACT_NO, schedule.EVENT_NAME, schedule.EVENT_DATE 
        FROM schedule 
        JOIN client ON schedule.CLIENT_ID = client.CLIENT_ID 
        WHERE schedule.SCHEDULE_ID = ?";
    $stmt = $con->prepare($query);
    $stmt->bind_param("i", $scheduleId);
    $stmt->execute();
    $result = $stmt->get_result();
    $scheduleData = $result->fetch_assoc();

    // Debugging: Check if data was retrieved
    if ($scheduleData) {
        echo "Client Contact: " . $scheduleData['CONTACT_NO'] . "<br>";
        echo "Event Name: " . $scheduleData['EVENT_NAME'] . "<br>";
        echo "Event Date: " . $scheduleData['EVENT_DATE'] . "<br>";
    } else {
        echo "Failed to fetch schedule or client details.<br>";
    }

    // If the schedule data is available, proceed to send the SMS
    if ($scheduleData) {
        $contactNumber = "+" . preg_replace('/[^0-9]/', '', $scheduleData['CONTACT_NO']);
        $eventName = $scheduleData['EVENT_NAME'];
        $eventDate = $scheduleData['EVENT_DATE'];

        // Infobip SMS API configuration
        $base_url = "m3x86w.api.infobip.com";  
        $api_key = "373148a73c596b524eb18caf150c2e13-14f58a45-8f07-4d7b-9b26-f358d51daedd";  // Replace with your actual API key
        $configuration = new Configuration(host: $base_url, apiKey: $api_key);
        $api = new SmsApi(config: $configuration);

        // Prepare SMS message
        $messageText = "Your schedule for '$eventName' on $eventDate has been approved.";
        $destination = new SmsDestination(to: $contactNumber);
        $message = new SmsTextualMessage(
            destinations: [$destination],
            text: $messageText,
            from: "daveh"
        );

        $request = new SmsAdvancedTextualRequest(messages: [$message]);

        // Send SMS
        try {
            $response = $api->sendSmsMessage($request);
            echo "Response: " . json_encode($response) . "<br>";

            if ($response) {
                echo "Schedule approved and SMS sent successfully.<br>";
            } else {
                echo "Schedule approved but failed to send SMS.<br>";
            }
        } catch (Exception $e) {
            echo "Error sending SMS: " . $e->getMessage() . "<br>";
            echo "Full error: " . $e->getTraceAsString();
        }
    }

    $stmt->close();
    $con->close();
} else {
    echo "Invalid request or missing parameters.";
}
?>
