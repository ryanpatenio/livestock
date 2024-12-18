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

}