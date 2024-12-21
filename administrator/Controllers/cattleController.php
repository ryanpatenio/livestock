<?php


require("../connection/connection.php");
require_once('../includes/initialize.php');


class cattleController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }



    public function store(){
        extract($_POST);

        $image = $_FILES['IMAGE_PATH'];
    
        $uploadDirectory = "path_to_images/"; // Folder to save uploaded images
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true); // Create folder if it doesn't exist
        }

       
        // Generate a unique name for the uploaded image
        $imageName = uniqid() . "_" . basename($image['name']);
        $imagePath = $uploadDirectory . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
           return $this->helper->message("error while uploading...",200,1);
        }

        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, ANIMALTYPE, ANIMAL_SEX, STATUS, IMAGE_PATH) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $param = [$CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX, $STATUS, $imagePath];

        $insert = $this->helper->regularQuery($insertQuery,$param);


        if(!$insert){
            return $this->helper->message("error while updating!...",200,1);
        }
        //get the animal ID
        $animal_id = $insert['insert_id'];

         //Create new Vaccine Card
         $query2 = "INSERT INTO vaccine_card (ANIMAL_ID,DATE_CREATED) VALUES(?, now())";
         $param2 = [$animal_id];
         $create = $this->helper->regularQuery($query2,$param2);

         $vaccine_card_id = $create['insert_id'];


         //update animal
         $update = "UPDATE animal SET VACCINE_CARD_ID = ? WHERE ANIMAL_ID = ?";
         $param3 = [$vaccine_card_id,$animal_id];
         $doUpdate = $this->helper->regularQuery($update,$param3);

        $dir = "../index2.php?page=Recording&client_id=$CLIENT_ID";

        return $this->helper->message('success',200,0,$dir);

        //header("Location: ../index.php?page=Recording&client_id=$client_id");

    }
    //
    public function storeStaff(){
        extract($_POST);

        $image = $_FILES['IMAGE_PATH'];
    
        $uploadDirectory = "path_to_images/"; // Folder to save uploaded images
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0755, true); // Create folder if it doesn't exist
        }

        
        // Generate a unique name for the uploaded image
        $imageName = uniqid() . "_" . basename($image['name']);
        $imagePath = $uploadDirectory . $imageName;

        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
           return $this->helper->message("error while uploading...",200,1);
        }

        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, ANIMALTYPE, ANIMAL_SEX, STATUS, IMAGE_PATH) 
        VALUES (?, ?, ?, ?, ?, ?)";
        $param = [$CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX, $STATUS, $imagePath];

        $insert = $this->helper->regularQuery($insertQuery,$param);


        if(!$insert){
            return $this->helper->message("error while updating!...",200,1);
        }
        $animal_id = $insert['insert_id'];

         //Create new Vaccine Card
         $query2 = "INSERT INTO vaccine_card (ANIMAL_ID,DATE_CREATED) VALUES(?, now())";
         $param2 = [$animal_id];
         $create = $this->helper->regularQuery($query2,$param2);

         $vaccine_card_id = $create['insert_id'];


         //update animal
         $update = "UPDATE animal SET VACCINE_CARD_ID = ? WHERE ANIMAL_ID = ?";
         $param3 = [$vaccine_card_id,$animal_id];
         $doUpdate = $this->helper->regularQuery($update,$param3);

        $dir = "../index.php?page=Recording&client_id=$CLIENT_ID";

        return $this->helper->message('success',200,0,$dir);

        //header("Location: ../index.php?page=Recording&client_id=$client_id");

    }


    public function getAnimalDetails(){
        extract($_POST);

        $query = "SELECT vt.VACCINE_NAME,s.EVENT_DATE,s.QTY_USED FROM vaccine_details vd, vaccine_card vc,schedule s,vaccine_type vt WHERE vd.VACCINE_CARD_ID = vc.VACCINE_CARD_ID AND vd.SCHEDULE_ID = s.SCHEDULE_ID AND s.VACCINE_TYPE_ID = vt.VACCINE_TYPE_ID AND  vc.ANIMAL_ID = ?";
        $param = [$animal_id];
        $result = $this->helper->regularQuery($query,$param);

        if(empty($result)){
            return $this->helper->message('NODF',200,0);
        }
       

        $query2 = "SELECT ANIMAL_ID,ANIMALTYPE,VACCINE_CARD_ID FROM animal WHERE ANIMAL_ID = ?";
        $param2 = [$animal_id];
        $result2 = $this->helper->regularQuery($query2,$param2);

        if(!$result2){
            return $this->helper->message('error while processing your request!..',200,1);
        }

        $returnData = [
            'tbl_data' =>$result,
            'tbl_head' =>$result2
        ];

        return $this->helper->message('success',200,0,$returnData);
        

    }


}