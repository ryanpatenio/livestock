<?php

require("../connection/connection.php");
require_once('../includes/initialize.php');

class dispersalController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }

    public function store(){
        extract($_POST);
        
        if($CLIENT_ID == "" || $CLIENT_ID == null){
            return $this->helper->message("error missing some parameters!",200,1);
        }
        $FIRST_PAYMENT_ID = ""; $SECOND_PAYMENT_ID = "";

        $query = "INSERT INTO `dispersal` (`CLIENT_ID`, `1ST_PAYMENT_ID`, `2ND_PAYMENT_ID`, `STATUS`,`date_created`) VALUES (?,?,?,?,now())";
        $param = [$CLIENT_ID, $FIRST_PAYMENT_ID , $SECOND_PAYMENT_ID , $STATUS];

        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            //return error
            return $this->helper->message("error while processing your request!",200,1);
        }
        //success
        return $this->helper->message("Dispersal Updated Successfully!",200,0);
    }

    public function get(){
        extract($_POST);

        if($DISPERSAL_ID == "" || $DISPERSAL_ID == null){
            return $this->helper->message("error! missing some parameters!",200,1);
        }

        $query = "SELECT * FROM dispersal WHERE DISPERSAL_ID = ?";
        $param = [$DISPERSAL_ID];
        
        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            return $this->helper->message("error! While processing your request!",200,1);
        }

        return $this->helper->message('success',200,0);
    }

    public function firstPayment(){
        extract($_POST);
        
        //payment STATUS
        $paymentStatus = "First Payment";

        if($existingClient == "" || $existingClient == null){
            return $this->helper->message("error missing some parameters!",200,1);
        }
        if($client_id == "" || $client_id == null){
            return $this->helper->message("error missing some parameters!",200,1);
        }
        if($dispersal_id1 == "" || $dispersal_id1 == null){
            return $this->helper->message('error! missing some parameters..',200,1);
        }


         // Validate if the file is present
         if (!isset($_FILES['animal_img']) || $_FILES['animal_img']['error'] !== UPLOAD_ERR_OK) {
                return $this->helper->message("error missing some parameters!",200,1); 
        }

        $existClient = $existingClient;
        if($existClient == "existing"){
            //update dispersal first payment then the date
            $giveToClient_ID = $give_to;

             //check if the selected client same of the owner
            if($client_id == $give_to){
                //same
                return $this->helper->message("Transfer failed: An owner cannot assign an animal to themselves. Please choose a different owner!.",200,1);
            }
           
            //create new animals
            $create = $this->createAnimal($giveToClient_ID, $bday, $animal_type, $animalSex,$client_id);
            if (!$create) {
                return $this->helper->message('Error while processing your request!...', 200, 1);
            }

            //then update the dispersal records          
            $updateDispersal = $this->updateDispersalFirstPayment($paymentDate,$dispersal_id1,$ANIMAL_ID);
            if(!$updateDispersal){
                return $this->helper->message('error while processing your request2...',200,1);
            }

            //then create payment
            $newPayment = $this->createPayment($dispersal_id1,$or,$client_id,$giveToClient_ID,$paymentStatus);
            if(!$newPayment){
                return $this->helper->message('error while processing your request2...',200,1);
            }

            return $this->helper->message('First Payment Dispersal Updated successfully!',200,0);
        }

        //this section is for not existing user or CLIENT

        //user selected not exist || so must create the user first
        $newInsertedClientID = $this->createClient($FNAME,$LNAME,$MI,$ASSOC,$CONTACT,$ADDRESS);

        if(!$newInsertedClientID){
            return $this->helper->message('error while processing your request...!',200,1);
        }
        $newClient_ID = $newInsertedClientID;//ID of last inserted Client

        //create new animal
        $insertNewAnimal = $this->createAnimal($newClient_ID,$bday,$animal_type,$animalSex,$client_id);
        if(!$insertNewAnimal){
            return $this->helper->message('Error while processing your request!...', 200, 1);
        }

        //then update dispersal
        $updateDispersal2 = $this->updateDispersalFirstPayment($paymentDate,$dispersal_id1,$ANIMAL_ID);
        if(!$updateDispersal2){
            return $this->helper->message('error! while processing your request..',200,1);
        }
        //create payment Data 
        $insertNewPayment = $this->createPayment($dispersal_id1,$or,$client_id,$newClient_ID,$paymentStatus); 
        if(!$insertNewPayment){
            return $this->helper->message('error! while processing your request..',200,1);
        }   
     
        //return success message
        return $this->helper->message('First Payment Dispersal Updated successfully!',200,0);
       
    }


    public function secondPayment(){
        extract($_POST);

         //payment STATUS
         $paymentStatus = "Second Payment";

        if($client_id2 == null || $client_id2 == ""){
            return $this->helper->message('error! missing some parameters....',200,0,1);
        }
        if($dispersal_id2 == "" || $dispersal_id2 == null){
            return $this->helper->message('error! missing some parameters....',200,0,1);
        }

        if($existingClient2 == "" || $existingClient2 == null){
            return $this->helper->message("error missing some parameters!",200,1);
        }

         // Validate if the file is present
         if (!isset($_FILES['animal_img2']) || $_FILES['animal_img2']['error'] !== UPLOAD_ERR_OK) {
                return $this->helper->message("error missing some parameters!",200,1); 
        }


        $existClient = $existingClient2;
        if($existClient == "existing"){
            //update dispersal first payment then the date
            $giveToClient_ID = $give_to2;

             //check if the selected client same of the owner
            if($client_id2 == $give_to2){
                //same
                return $this->helper->message("Transfer failed: An owner cannot assign an animal to themselves. Please choose a different owner!.",200,1);
            }
           
            //create new animals
            $create = $this->createAnimal2($giveToClient_ID, $bday, $animal_type, $animalSex,$client_id2);
            if (!$create) {
                return $this->helper->message('Error while processing your request!...', 200, 1);
            }

            //then update the dispersal records          
            $updateDispersal = $this->updateDispersalSecondPayment($paymentDate,$dispersal_id2);
            if(!$updateDispersal){
                return $this->helper->message('error while processing your request2...',200,1);
            }

            //then create payment
            $newPayment = $this->createPayment($dispersal_id2,$or,$client_id2,$giveToClient_ID,$paymentStatus);
            if(!$newPayment){
                return $this->helper->message('error while processing your request2...',200,1);
            }

            return $this->helper->message('Second Payment Dispersal Updated successfully!',200,0);
        }


        //this section is for not existing user or CLIENT

        //user selected not exist || so must create the user first
        $newInsertedClientID = $this->createClient($FNAME,$LNAME,$MI,$ASSOC,$CONTACT,$ADDRESS);

        if(!$newInsertedClientID){
            return $this->helper->message('error while processing your request...!',200,1);
        }
        $newClient_ID = $newInsertedClientID;//ID of last inserted Client

        //create new animal
        $insertNewAnimal = $this->createAnimal2($newClient_ID,$bday,$animal_type,$animalSex,$client_id2);
        if(!$insertNewAnimal){
            return $this->helper->message('Error while processing your request!... ani', 200, 1);
        }

        //then update dispersal
        $updateDispersal3 = $this->updateDispersalSecondPayment($paymentDate,$dispersal_id2);
        if(!$updateDispersal3){
            return $this->helper->message('error! while processing your request up dis..',200,1);
        }
        //create payment Data 
        $insertNewPayment = $this->createPayment($dispersal_id2,$or,$client_id2,$newClient_ID,$paymentStatus); 
        if(!$insertNewPayment){
            return $this->helper->message('error! while processing your request. new.',200,1);
        }   


        return $this->helper->message('Second Payment Dispersal Updated Successfully!',200,0);
    }

    //add animal for first payment
    public function createAnimal($CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX,$fromClientID){
    
        
        // Check if the file is uploaded
        if (!isset($_FILES['animal_img']) || $_FILES['animal_img']['error'] !== UPLOAD_ERR_OK) {
            return false; // Handle the error appropriately
        }

        // Use the uploaded file directly from $_FILES
        $image = $_FILES['animal_img'];

        // Define the upload directory
        $uploadDirectory = "path_to_images/"; // Folder to save uploaded images
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true); // Create folder if it doesn't exist
        }
    
        // Generate a unique name for the uploaded image
        $imageName = uniqid() . "_" . basename($image['name']);
        $imagePath = $uploadDirectory . $imageName;
    
        // Move the uploaded file to the target directory
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            return false;
        }
    
        // Insert the animal record into the database
        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, category_id, ANIMAL_SEX, STATUS, IMAGE_PATH,isPayment,fromClient, date_created) 
                        VALUES (?, ?, ?, ?, ?, ?,'1',?, now())";
        $STATUS = "1"; // Default status @it means animal is alive
        $param = [$CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX, $STATUS, $imagePath,$fromClientID];
        $insert = $this->helper->regularQuery($insertQuery, $param);
    
        if (!$insert) {
            return false;
        }
    
        // Get the inserted animal ID
        $animal_id = $insert['insert_id'];
    
        // Create a new Vaccine Card
        $query2 = "INSERT INTO vaccine_card (ANIMAL_ID, DATE_CREATED) VALUES (?, NOW())";
        $param2 = [$animal_id];
        $create = $this->helper->regularQuery($query2, $param2);
    
        if (!$create) {
            return false;
        }
    
        // Get the inserted vaccine card ID
        $vaccine_card_id = $create['insert_id'];
    
        // Update the animal record with the vaccine card ID
        $update = "UPDATE animal SET VACCINE_CARD_ID = ? WHERE ANIMAL_ID = ?";
        $param3 = [$vaccine_card_id, $animal_id];
        $doUpdate = $this->helper->regularQuery($update, $param3);
    
            if (!$doUpdate) {
                return false;
            }
    
        return true;
    }

    //this function is for the secondPayment @reason cause of animal file_name
    public function createAnimal2($CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX,$fromClientID)
    {
        
        // Check if the file is uploaded
        if (!isset($_FILES['animal_img2']) || $_FILES['animal_img2']['error'] !== UPLOAD_ERR_OK) {
            return false; // Handle the error appropriately
        }

        // Use the uploaded file directly from $_FILES
        $image = $_FILES['animal_img2'];

        // Define the upload directory
        $uploadDirectory = "path_to_images/"; // Folder to save uploaded images
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true); // Create folder if it doesn't exist
        }
    
        // Generate a unique name for the uploaded image
        $imageName = uniqid() . "_" . basename($image['name']);
        $imagePath = $uploadDirectory . $imageName;
    
        // Move the uploaded file to the target directory
        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
            return false;
        }
    
        // Insert the animal record into the database
        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, category_id, ANIMAL_SEX, STATUS, IMAGE_PATH,isPayment,fromClient, date_created) 
                        VALUES (?, ?, ?, ?, ?, ?,'1',?, now())";
        $STATUS = "1"; // Default status @it means animal is alive
        $param = [$CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX, $STATUS, $imagePath,$fromClientID];
        $insert = $this->helper->regularQuery($insertQuery, $param);
    
        if (!$insert) {
            return false;
        }
    
        // Get the inserted animal ID
        $animal_id = $insert['insert_id'];
    
        // Create a new Vaccine Card
        $query2 = "INSERT INTO vaccine_card (ANIMAL_ID, DATE_CREATED) VALUES (?, NOW())";
        $param2 = [$animal_id];
        $create = $this->helper->regularQuery($query2, $param2);
    
        if (!$create) {
            return false;
        }
    
        // Get the inserted vaccine card ID
        $vaccine_card_id = $create['insert_id'];
    
        // Update the animal record with the vaccine card ID
        $update = "UPDATE animal SET VACCINE_CARD_ID = ? WHERE ANIMAL_ID = ?";
        $param3 = [$vaccine_card_id, $animal_id];
        $doUpdate = $this->helper->regularQuery($update, $param3);
    
        if (!$doUpdate) {
            return false;
        }
    
        return true;
    }

    function createClient($FNAME,$LNAME,$MI,$ASSOC,$CONTACT,$ADDRESS){
        $queryNewClient = "INSERT INTO client (FNAME, LNAME, MIDINITIAL, ASSOCIATION, CONTACT_NO, ADDRESS, DATE_REGISTERED) VALUES(?, ?, ?, ?, ?, ?, now());";
        $param = [$FNAME,$LNAME,$MI,$ASSOC,$CONTACT,$ADDRESS];

        $insert = $this->helper->regularQuery($queryNewClient,$param);

        if(!$insert){
            return false;
        }
        $id = $insert['insert_id'];

        return $id;
    }

    function updateDispersalFirstPayment($paymentDate,$dispersal_id1,$parent_animal_id){
        $query2 = "UPDATE dispersal SET 1ST_PAYMENT_ID = '1' ,DATE_FIRST_PAYMENT = ?,PARENT_ANIMAL_ID = ? WHERE DISPERSAL_ID = ?";
        $param2 = [$paymentDate,$parent_animal_id, $dispersal_id1];
        $updateDispersal = $this->helper->regularQuery($query2,$param2);

        if(!$updateDispersal){
            return false;
        }
        return true;
    }
    function updateDispersalSecondPayment($paymentDate,$dispersal_id2){
        $query2 = "UPDATE dispersal SET 2ND_PAYMENT_ID = '1',STATUS = 'COMPLETED', DATE_SECOND_PAYMENT = ? WHERE DISPERSAL_ID = ?";
        $param2 = [$paymentDate, $dispersal_id2];
        $updateDispersal = $this->helper->regularQuery($query2,$param2);

        if(!$updateDispersal){
            return false;
        }
        return true;
    }
    function createPayment($DISPERSAL_ID,$OR,$PAID_BY_CLIENT_ID,$GIVE_TO,$PAYMENT_STATUS){
        $query = "INSERT INTO payment (DISPERSAL_ID, OR_PAYMENT_NO, DATE, PAID_BY, GIVE_TO, PAYMENT_STATUS) VALUES(?, ?, now(), ?, ?, ?);";
        $param = [$DISPERSAL_ID,$OR, $PAID_BY_CLIENT_ID,$GIVE_TO,$PAYMENT_STATUS];
        $insert = $this->helper->regularQuery($query,$param);

        if(!$insert){
            return false;
        }
        return true;
    }


}