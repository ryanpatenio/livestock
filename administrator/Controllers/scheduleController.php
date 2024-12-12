<?php

require("../connection/connection.php");
require_once('../includes/initialize.php');

// Use the Infobip API classes
use Infobip\Configuration;
use Infobip\Api\SmsApi;
use Infobip\Model\SmsDestination;
use Infobip\Model\SmsTextualMessage;
use Infobip\Model\SmsAdvancedTextualRequest;

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
                 
                   return $this->helper->message("Error inserting data", 400,1); // Return error message with 400 status
               }
           
               // If insertion is successful, return a success message
               return $this->helper->message('Data successfully inserted', 200,0); // Return success message with 200 status
           
               exit; // Ensure no other output is sent
    }

    public function update(){
        extract($_POST);

        $schedule_id;
        $event_date;

        //check the extracted DATA
        if($schedule_id == "" || $schedule_id == null || $event_date == "" || $event_date == null){
            //return error
            $this->helper->message("error while getting the DATA.. SCE",200,1);
            return;
        }

        //get the Client Contact Number Event Date and Event Name
        $query = " SELECT client.CONTACT_NO, schedule.EVENT_NAME, schedule.EVENT_DATE 
            FROM schedule 
            JOIN client ON schedule.CLIENT_ID = client.CLIENT_ID 
            WHERE schedule.SCHEDULE_ID = ?";
        $param = [$schedule_id];

        $result = $this->helper->regularQuery($query,$param);

        if(empty($result)){
            //return error
            $this->helper->message("error while getting the DATA..",200,1);
            return;
        }

        //prepare DATA to send

       // $contactNumber = "+" . preg_replace('/[^0-9]/', '', $result[0]['CONTACT_NO']);
        $contactNumber = $result[0]['CONTACT_NO'];
        $eventName = $result[0]['EVENT_NAME'];
        $eventDate = $result[0]['EVENT_DATE'];

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
            //update event if success

            $updateQuery = "UPDATE schedule SET STATUS = 1 WHERE SCHEDULE_ID = ?";
            $params = [$schedule_id];
            $results = $this->helper->regularQuery($updateQuery,$params);
            
            // if(!$results){
            //     return $this->helper->message("error while updating...",200,1);
            // }

            $data = $this->getRequestQty($schedule_id);
            if(!is_object($data)){
                //return error
                return $this->helper->message("error qty",200,1);
            }
            //get DATA
            $qty = $data['qty'];
            $vaccine_id = $data['vaccine_id'];
            


            if ($response) {              
                return $this->helper->message("Schedule approved and SMS sent successfully",200,0,$response);
            } else {
               
                return $this->helper->message("Schedule approved but failed to send SMS",200,0,$response);
            }
        } catch (Exception $e) {
            $err = [
                'err_msg' =>  $this->helper->message("success",200,1,$e->$e->getMessage()),
                'err_desc' =>$this->helper->message("success",200,1,$e->getTraceAsString())
                
            ];
            return $err;
        }
        
     //   return $this->helper->message("success",200,0,$result[0]['CONTACT_NO']);


    }

    public function updatRequirements(){
        extract($_POST);

        $first = $first_requirement;
        $second = $second_requirement;

        if($schedule_id == null || $schedule_id == ""){
             //return error
             return $this->helper->message("Error missing some parameters...",200,1);
        }

        $query = "UPDATE schedule SET 1ST_REQUIREMENT = ? , 2ND_REQUIREMENT = ? WHERE SCHEDULE_ID = ?";
        $param = [$first,$second,$schedule_id];

        $update = $this->helper->regularQuery($query,$param);

        if(!$update){
            //return error
            return $this->helper->message("Error while updating...",200,1);
        }

        return $this->helper->message("Schedule Requirements updated successfully!",200,0);

    }

    public function getScheduleDate(){
        extract($_POST);

        if($schedule_id == "" || $schedule_id == null){
            return $this->helper->message("Error some parameters missing...",200,1);
        }

        $query = "SELECT * FROM schedule WHERE SCHEDULE_ID = ?";
        $param = [$schedule_id];

        $result = $this->helper->regularQuery($query,$param);
        
        if(!$result){
            //return error
            return $this->helper->message("Error while processing your request...",200,1);
        }

         return $this->helper->message("success",200,0,$result[0]['EVENT_DATE']);
    }

    function getRequestQty($schedule_id){
        $query = "SELECT * FROM schedule WHERE SCHEDULE_ID = ? LIMIT 1";
        $param = [$schedule_id];

        $result = $this->helper->regular($query,$param);

        if($result){
            return $data = [
                'qty' => $result[0]['QUANTITY'],
                'vaccine_id' => $result[0]['VACCINE_ID']
            ];
        }
        return 0;
    }
}