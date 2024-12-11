<?php

require("../connection/connection.php");
require_once('../includes/initialize.php');

class scheduleController {

    
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }

    public function store(){
               // Extract POST data
               extract($_POST);
    
               // Prepare the query for inserting data into the client table
               $query = "INSERT INTO schedule (VACCINE_ID, QTY_USED, EVENT_NAME, EVENT_DATE, CLIENT_ID, 1ST_REQUIREMENT, 2ND_REQUIREMENT, STATUS, CREATED_AT) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
           
               // Define the parameters to be bound to the query
             
               $param = [$vaccine_ID, $qty, $event_name, $event_date, $client_id, $first_requirement, $second_requirement, $status];
           
               // Execute the query using the helper's executeQuery method
               $result = $this->helper->regularQuery($query, $param);
           
               // Check if the result is successful
               if (!$result) {
                 
                   return $this->helper->message("Error inserting data", 400); // Return error message with 400 status
               }
           
               // If insertion is successful, return a success message
               return $this->helper->message('Data successfully inserted', 200); // Return success message with 200 status
           
               exit; // Ensure no other output is sent
    }
}