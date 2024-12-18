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

        $query = "INSERT INTO `dispersal` (`CLIENT_ID`, `1ST_PAYMENT_ID`, `2ND_PAYMENT_ID`, `STATUS`) VALUES (?,?,?,?)";
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
           
            //create new animals
            $create = $this->createAnimal($giveToClient_ID, $bday, $animal_type, $animalSex,$client_id);
            if (!$create) {
                return $this->helper->message('Error while processing your request!...', 200, 1);
            }

            //then update the dispersal records          
            $updateDispersal = $this->updateDispersalFirstPayment($paymentDate,$dispersal_id1);
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

        //user selected not exist user so must create the user first
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
        $updateDispersal2 = $this->updateDispersalFirstPayment($paymentDate,$dispersal_id1);
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


    public function createAnimal($CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX,$fromClientID)
    {
        
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
        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, ANIMALTYPE, ANIMAL_SEX, STATUS, IMAGE_PATH,isPayment,fromClient) 
                        VALUES (?, ?, ?, ?, ?, ?,'1',?)";
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

    function updateDispersalFirstPayment($paymentDate,$dispersal_id1){
        $query2 = "UPDATE dispersal SET 1ST_PAYMENT_ID = '1', DATE_FIRST_PAYMENT = ? WHERE DISPERSAL_ID = ?";
        $param2 = [$paymentDate, $dispersal_id1];
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