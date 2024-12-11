<?php

use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

require __DIR__ . "/vendor/autoload.php";
require("connection/connection.php");
// Check if the form is submitted and inputs are set
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['contact_number'], $_POST['message_text'])) {

    // Retrieve contact number and custom message from form
    $contactNumber = $_POST['CONTACT_NO'];
    $messageText = $_POST['message_text'];

    // Check if contact number exists in the database
    $sql = "SELECT CLIENT_ID FROM client WHERE CONTACT_NO = ?";
    $stmt = $conn->prepare($sql);
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
            text: $messageText, // Use the custom message entered by the user
            from: "daveh" // Replace with your Infobip sender ID
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
        // No user found with that contact number
        echo "Contact number not found in our records.";
    }

    $stmt->close();
    $conn->close();

} else {
    echo "Please provide both a contact number and a message.";
}

?>
