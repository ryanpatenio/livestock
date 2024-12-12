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

        $imagePath = $uploadDirectory . basename($image['name']);

        if (!move_uploaded_file($image['tmp_name'], $imagePath)) {
           return $this->helper->message("error while uploading...",200,1);
        }

        $insertQuery = "INSERT INTO animal (CLIENT_ID, BIRTHDATE, ANIMALTYPE, ANIMAL_SEX, STATUS, VACCINE_CARD_ID, IMAGE_PATH) 
        VALUES (?, ?, ?, ?, ?, ?, ?)";
        $param = [$CLIENT_ID, $BIRTHDATE, $ANIMALTYPE, $ANIMAL_SEX, $STATUS, $VACCINE_CARD_ID, $imagePath];

        $update = $this->helper->regularQuery($insertQuery,$param);

        if(!$update){
            return $this->helper->message("error while updating!...",200,1);
        }
        $dir = "../index2.php?page=Recording&client_id=$CLIENT_ID";

        return $this->helper->message('success',200,0,$dir);

        //header("Location: ../index.php?page=Recording&client_id=$client_id");

    }

}