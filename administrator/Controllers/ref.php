<?php
 // Store method to handle the form submission or other actions
class ref {


    public function store() {
        // Assuming these are the required POST fields
        $requiredFields = ['FNAME', 'LNAME', 'MIDINITIAL'];
    
        // Initialize an array to hold error messages
        $errors = [];
    
        // Validate and sanitize each required field
        foreach ($requiredFields as $field) {
            if (!isset($_POST[$field]) || empty($_POST[$field])) {
                $errors[] = "The field $field is required.";
            } else {
                // Sanitize the input
                $_POST[$field] = htmlspecialchars(trim($_POST[$field])); // Prevent XSS
            }
        }
    
        // If there are validation errors, return them
        if (!empty($errors)) {
            // You can use the helper to return a message if there are errors
            //return $this->helper->message("Validation errors", 400, $errors);
        }
    
        // If no errors, extract the data
        extract($_POST);
    
        // Process the data here (e.g., insert into the database)
    
        // Return JSON-encoded success response with extracted data
       // $this->helper->message("Data processed successfully", 200, compact('FNAME', 'LNAME', 'MIDINITIAL'));
    
        exit; // Ensure no other output is sent
    }
}

