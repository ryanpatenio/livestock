<?php


require("../connection/connection.php");
require_once('../includes/initialize.php');


// $query = "SELECT * FROM users WHERE id = ?";
// $params = [1];
// $result = $helper->executeQuery($query, $params);

 class clientController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }

    // Store method to handle the form submission or other actions
    public function store() {

        // Extract POST data
        extract($_POST);
    
        // Prepare the query for inserting data into the client table
        $query = "INSERT INTO client (FNAME, LNAME, MIDINITIAL, ASSOCIATION, CONTACT_NO, ADDRESS, DATE_REGISTERED) 
                  VALUES (?, ?, ?, ?, ?, ?, NOW())";
    
        // Define the parameters to be bound to the query
        $param = [$FNAME, $LNAME, $MIDINITIAL, $ASSOCIATION, $CONTACT_NO, $ADDRESS];
    
        // Execute the query using the helper's executeQuery method
        $result = $this->helper->regularQuery($query, $param);
    
        // Check if the result is successful
        if (!$result) {
          
            return $this->helper->message("Error inserting data", 400,1); // Return error message with 400 status
        }
    
        // If insertion is successful, return a success message
        return $this->helper->message('Data successfully inserted', 200,0); // Return success message with 200 status
    
        exit; // Ensure no other output is sent
    }
    
    public function get(){
        extract($_POST);

        $clientID = $id;

        if($clientID == null || $clientID == ''){
            return $this->helper->message("error CLIENT Missing!",200,1);
        }
        $query = "select * from client where CLIENT_ID = ?";
        $param = [$clientID];

        $result = $this->helper->regularQuery($query,$param);

        if(empty($result)){
            return $this->helper->message("Error",200,1);
        }

        return $this->helper->message("success",200,0,$result);

    }

    public function update(){
        extract($_POST);

        $client = $client_id;

        if($client == null || $client == ""){
            return $this->helper->message("error CLIENT Missing!",200,1);
        }

        $query = "UPDATE client SET FNAME = ? , LNAME = ? , MIDINITIAL = ?, ASSOCIATION = ? , CONTACT_NO = ?, ADDRESS = ?, DATE_REGISTERED = ? WHERE CLIENT_ID = ?";
        $param = [$FNAME,$LNAME,$MI, $ASSOC,$CONTACT,$ADDRESS,$DATE_REGISTERED,$client];

        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            return $this->helper->message("Error While Processing your Request!",200,1);
        }
        return $this->helper->message("Success!",200,0);


    }
    


    function test(){
        echo json_encode([
            'msg' => 'lala'
        ]);
    }
 }