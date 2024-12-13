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

}