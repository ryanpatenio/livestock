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
               $query = "INSERT INTO schedule (VACCINE_TYPE_ID, QTY_USED, EVENT_NAME, EVENT_DATE, CLIENT_ID, 1ST_REQUIREMENT, 2ND_REQUIREMENT, STATUS, CREATED_AT) 
                         VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())";
           
               // Define the parameters to be bound to the query
             
               $param = [$vaccine_TYPE_ID, $qty, $event_name, $event_date, $client_id, $first_requirement, $second_requirement, $status];
           
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
            $this->helper->message("error while getting the DATA.. ",200,1);
            return;
        }

        //get the Client Contact Number Event Date and Event Name
        $query = "  SELECT schedule.SCHEDULE_ID,schedule.QTY_USED,schedule.VACCINE_TYPE_ID,client.CONTACT_NO, schedule.EVENT_NAME, schedule.EVENT_DATE 
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

          // Send SMS || then executing all CODES
        try {
            $response = $api->sendSmsMessage($request);    
            //update event if success

            /**
             * @get the Schedule Request Quantity
             * @then check if the inventory vaccine quantity is not less than to the request quantity
             */
            $qty_need_to_deduct = $result[0]['QTY_USED'];
            $vaccine_type_id = $result[0]['VACCINE_TYPE_ID'];

            $checkStock = $this->checkStock($vaccine_type_id,$qty_need_to_deduct);
            if( ! $checkStock){
                //not enough stock
                return $this->helper->message("Not enough stock available for this Vaccine", 200, 1);
            }
            
            //this method will deduct the vaccine inventory
            $deduct =  $this->deductVaccine($vaccine_type_id,$qty_need_to_deduct);
            if(! $deduct){
                return $this->helper->message('Error: while deducting your request!',200,1);
            }
            //set status = 1 approved
            $updateQuery = "UPDATE schedule SET STATUS = 1 WHERE SCHEDULE_ID = ?";
            $params = [$schedule_id];
            $results = $this->helper->regularQuery($updateQuery,$params);
            
            if(!$results){
                return $this->helper->message("error while updating...",200,1);
            }
          
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

        $query = "  SELECT schedule.SCHEDULE_ID,vaccine_type.VACCINE_NAME,CONCAT(c.FNAME,' ',c.LNAME) AS client_name,schedule.QTY_USED,schedule.VACCINE_TYPE_ID,client.CONTACT_NO, schedule.EVENT_NAME, schedule.EVENT_DATE 
            FROM schedule 
            JOIN client ON schedule.CLIENT_ID = client.CLIENT_ID
			
				JOIN vaccine_type ON schedule.VACCINE_TYPE_ID = vaccine_type.VACCINE_TYPE_ID 
				JOIN client c ON schedule.CLIENT_ID = c.CLIENT_ID
            WHERE schedule.SCHEDULE_ID = ?";
        $param = [$schedule_id];

        $result = $this->helper->regularQuery($query,$param);
        
        if(!$result){
            //return error
            return $this->helper->message("Error while processing your request...",200,1);
        }
        $data = [
            'EVENT_DATE' => $result[0]['EVENT_DATE'],
            'VACCINE_NAME' => $result[0]['VACCINE_NAME'],
            'QUANTITY_REQUEST' => $result[0]['QTY_USED'],
            'EVENT_NAME'    => $result[0]['EVENT_NAME'],
            'CLIENT_NAME'  => $result[0]['client_name']
        ];

         return $this->helper->message("success",200,0,$data);
    }

    function getRequestQty($schedule_id){
        $query = "SELECT * FROM schedule WHERE SCHEDULE_ID = ? LIMIT 1";
        $param = [$schedule_id];

        $result = $this->helper->regularQuery($query,$param);

        if($result){
            return $data = [
                'qty' => $result[0]['QTY_USED'],
                'vaccine_type_id' => $result[0]['VACCINE_TYPE_ID']
            ];
        }
        return 0;
    }


    //this method will handle deduction in vaccine stocks table
    function deductVaccine($vaccine_type_id, $usedQty) {
        $remainingQty = $usedQty;

           //Check total available stock before proceeding
            $query_check = "SELECT SUM(QUANTITY) AS total_stock FROM vaccine WHERE VACCINE_TYPE_ID = ? AND EXPIRY_DATE > NOW() AND QUANTITY > 0";
            $param_check = [$vaccine_type_id];
            $result_check = $this->helper->regularQuery($query_check, $param_check);

            if ($result_check[0]['total_stock'] < $usedQty) {
                //return $this->helper->message("Not enough stock available", 200, 1);
                return false;
            }

    
        while ($remainingQty > 0) {
            // Fetch the oldest stock that has available quantity
            $query = "SELECT VACCINE_ID, QUANTITY FROM vaccine WHERE VACCINE_TYPE_ID = ? AND EXPIRY_DATE > NOW() AND QUANTITY > 0 ORDER BY DATE_CREATED ASC LIMIT 1";
            $param = [$vaccine_type_id];
    
            $result = $this->helper->regularQuery($query, $param);
    
            if (!$result) {
                // No available stock found
                //return $this->helper->message("Not enough stock available", 200, 1);
                return false;
            }
    
            // Get the quantity to deduct from this stock
            $deductedQuantity = min($remainingQty, $result[0]['QUANTITY']);
            $remainingQty -= $deductedQuantity;
    
            // Update the vaccine stock by deducting the quantity
            $newQuantity = $result[0]['QUANTITY'] - $deductedQuantity;
            $query2 = "UPDATE vaccine SET QUANTITY = ? WHERE VACCINE_ID = ?";
            $param2 = [$newQuantity, $result[0]['VACCINE_ID']];
            $result2 = $this->helper->regularQuery($query2, $param2);
    
            if (!$result2) {
                // Error in updating the stock
                //return $this->helper->message("Error updating stock", 200, 1);
                return false;
            }
    
           // Log the usage in the vaccine_usage table
            $query3 = "INSERT INTO vaccine_usage (VACCINE_ID, VACCINE_TYPE_ID, use_quantity, date_used) VALUES (?, ?, ?, NOW())";
            $param3 = [$result[0]['VACCINE_ID'],$vaccine_type_id, $deductedQuantity]; // Log the deducted quantity
            $result3 = $this->helper->regularQuery($query3, $param3);

            if (!$result3) {
                // Error in logging the usage
                //return $this->helper->message("Error logging usage", 200, 1);
                return false;
            }
    
        }
    
        // After the loop, check if remaining quantity is 0 (success) or partially deducted
        if ($remainingQty == 0) {
            //return $this->helper->message("Schedule approved and SMS sent successfully",200,0);
            return true;
        } 

    }

    public function getSchedule(){
        extract($_POST);

        $query = "SELECT s.SCHEDULE_ID,s.QTY_USED, vt.VACCINE_NAME,vt.`DESCRIPTION`,s.EVENT_DATE FROM schedule s,vaccine_type vt WHERE s.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID AND s.SCHEDULE_ID = ? AND s.`STATUS` = 1";
        $param = [$schedule_id];

        $result = $this->helper->regularQuery($query,$param);

        $query2 = "SELECT * from animal where ANIMAL_ID = ? LIMIT 1";
        $param2 = [$animal_id];
        $result2 = $this->helper->regularQuery($query2,$param2);
        $getVaccineCardID = $result2[0]['VACCINE_CARD_ID'];

        if(!$result2){
            return $this->helper->message('error while processing your request!',200,1);
        }

        if(!$result){
            //error

            return $this->helper->message('error while processing your request!',200,1);
        }

        $data = [
            'schedule_id' => $result[0]['SCHEDULE_ID'],
            'vaccine_name' => $result[0]['VACCINE_NAME'],
            'description' => $result[0]['DESCRIPTION'],
            'event_date' => $result[0]['EVENT_DATE'],
            'req_qty'    => $result[0]['QTY_USED'],
            'vaccine_card_id' => $getVaccineCardID
        ];


        return $this->helper->message('success',200,0,$data);

    }

    public function vaccinateAnimal(){
        // Extract data from the POST request
        extract($_POST);

        // Validate required fields
        if (empty($schedule_id) || empty($deduct_amount) || empty($animal_id) || empty($vaccine_card_id) || empty($date_injected)) {
            return $this->helper->message('Error: Missing required parameters!', 200, 1);
        }

        // Fetch current schedule quantity
        $data = $this->getRequestQty($schedule_id);
        if ($data === 0) {
            return $this->helper->message('Error: Invalid schedule ID or no quantity found.', 200, 1);
        }

        $current_quantity = $data['qty'];

        // Validate deduction amount
        if ($deduct_amount > $current_quantity) {
            return $this->helper->message('Error: Cannot deduct more than the available quantity.', 200, 1);
        }

        // Calculate new quantity and update schedule
        $new_quantity = $current_quantity - $deduct_amount;
        $updateQtyQuery = "UPDATE schedule SET QTY_USED = ? WHERE SCHEDULE_ID = ?";
        $updateQtyParams = [$new_quantity, $schedule_id];

        if (! $this->helper->regularQuery($updateQtyQuery, $updateQtyParams)) {
            return $this->helper->message('Error: Failed to update schedule quantity.', 200, 1);
        }

        // Check if quantity is zero or less and mark schedule as completed
        if ($new_quantity <= 0) {
            $markCompletedQuery = "UPDATE schedule SET isCompleted = 1 WHERE SCHEDULE_ID = ?";
            $markCompletedParams = [$schedule_id];

            if (! $this->helper->regularQuery($markCompletedQuery, $markCompletedParams)) {
                return $this->helper->message('Error: Failed to mark schedule as completed.', 200, 1);
            }
        }

        // Mark the animal as vaccinated
        $updateAnimalQuery = "UPDATE animal SET isVaccinated = 1 WHERE ANIMAL_ID = ?";
        $updateAnimalParams = [$animal_id];

        if (! $this->helper->regularQuery($updateAnimalQuery, $updateAnimalParams)) {
            return $this->helper->message('Error: Failed to update animal vaccination status.', 200, 1);
        }

        // Insert vaccination details
        $insertVaccinationQuery = "INSERT INTO vaccine_details (VACCINE_CARD_ID, SCHEDULE_ID, DATE_INJECTED, QTY_USED, STATUS) VALUES (?, ?, ?, ?, '1')";
        $insertVaccinationParams = [$vaccine_card_id, $schedule_id, $date_injected, $deduct_amount];

        if (! $this->helper->regularQuery($insertVaccinationQuery, $insertVaccinationParams)) {
            return $this->helper->message('Error: Failed to insert vaccination details.', 200, 1);
        }

    // Success message
    return $this->helper->message('Vaccination recorded successfully!', 200, 0);
}


    // public function vaccinateAnimal(){
    //     /***
    //      * @need from FORM $schedule ID 
    //      * @deduct quantity
    //      *  deduct the original quantity request to the input quantity to use @interactions schedule table and vaccine_details
    //      */
    //     extract($_POST);


    //     //$schedule id
    //     if(empty($schedule_id)){
    //         return $this->helper->message('Error:: Missing some parameters!',200,1);
    //     }
               
    //      //get schedule request quantity
    //     $data = $this->getRequestQty($schedule_id);
    //     if ($data === 0) {
    //         // Return error if no data is found
    //         return $this->helper->message("Error: Qty.", 200, 1);
    //     }

    //     $current_quantity = $data['qty'];
    //     if($deduct_amount > $current_quantity){
    //         //
    //         return $this->helper->message('Cannot deduct more than the available quantity',200,1);
    //     }

    //     //update the schedule quantity
    //     $new_quantity = $current_quantity - $deduct_amount;
    //     $queryQty = "UPDATE schedule SET QTY_USED = ? WHERE SCHEDULE_ID = ?";
    //     $paramQty = [$new_quantity,$schedule_id];
    //     $execute = $this->helper->regularQuery($queryQty,$paramQty);

    //     if( ! $execute){
    //         return $this->helper->message('error while processing your request!',200,1); 
    //     }

    //      //update animal isVAccinated column set to 1 mean true
    //      $query = "UPDATE animal SET isVaccinated = 1 WHERE ANIMAL_ID = ?";
    //      $param = [$animal_id];
    //      $result = $this->helper->regularQuery($query,$param);

    //      if( ! $result){
    //         return $this->helper->message('error while processing your request!',200,1);
    //     }
        
    //      //insert new records in vaccine_details or vaccination_details for the record of animals vaccination
    //      $query2 = "INSERT INTO vaccine_details (VACCINE_CARD_ID, SCHEDULE_ID,DATE_INJECTED,QTY_USED,STATUS) VALUES(?, ?, ?, ?, '1')";
    //      $param2 = [$vaccine_card_id, $schedule_id,$date_injected,$deduct_amount];
    //      $insert = $this->helper->regularQuery($query2,$param2);

    //      if( ! $insert){
    //          return $this->helper->message('error while processing your request!',200,1);
    //      }

    //     return $this->helper->message('Added Vaccination Successfully!',200,0);
    // }

    // public function vaccinateAnimal2(){
    //     extract($_POST);


      
    //     $data = $this->getRequestQty($schedule_id);
    //     if ($data === 0) {
    //         // Return error if no data is found
    //         return $this->helper->message("Error: Qty.", 200, 1);
    //     }

        
    //      //get DATA
    //      $qty = $data['qty'];
    //      $vaccine_type_id = $data['vaccine_type_id'];

    //     //  $dd = [
    //     //     'qt'=> $qty,
    //     //     'vc' => $vaccine_type_id
    //     //  ];



    //     //update animal isVAccinated column set to 1 mean true
    //     $query = "UPDATE animal SET isVaccinated = 1 WHERE ANIMAL_ID = ?";
    //     $param = [$animal_id];
    //     $result = $this->helper->regularQuery($query,$param);

    //     if(!$result){
    //         return $this->helper->message('error while processing your request!',200,1);
    //     }  

    //     //insert into vaccine details
    //     $query2 = "INSERT INTO vaccine_details (VACCINE_CARD_ID, SCHEDULE_ID,STATUS) VALUES(?, ?, '1')";
    //     $param2 = [$vaccine_card_id, $schedule_id];
    //     $insert = $this->helper->regularQuery($query2,$param2);

       

    //     if(!$insert){
    //         return $this->helper->message('error while processing your request!',200,1);
    //     }

    //      //update selected schedule
    //      $query3 = "UPDATE schedule SET isCompleted = '1' WHERE SCHEDULE_ID = ?";
    //      $param3 = [$schedule_id];
    //      $updated = $this->helper->regularQuery($query3,$param3);

    //      if(!$updated){
    //         return $this->helper->message('error while processing your request!',200,1);
    //      }

          
    //      $deduct =  $this->deductVaccine($vaccine_type_id,$qty);
    //     // deduct the stocks
  
    //      return $deduct;

    // }
    
    //boolean returns false if not enough stocks
    private function checkStock($vaccine_type_id,$usedQty){
        //Check total available stock before proceeding
        $query_check = "SELECT SUM(QUANTITY) AS total_stock FROM vaccine WHERE VACCINE_TYPE_ID = ? AND EXPIRY_DATE > NOW() AND QUANTITY > 0";
        $param_check = [$vaccine_type_id];
        $result_check = $this->helper->regularQuery($query_check, $param_check);

        if ($result_check[0]['total_stock'] < $usedQty) {
            //return $this->helper->message("Not enough stock available", 200, 1);
            return false;
        }
        return true;

    }
}