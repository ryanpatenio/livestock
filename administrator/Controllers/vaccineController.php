<?php

require("../connection/connection.php");
require_once('../includes/initialize.php');

class vaccineController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }

    public function store(){
        extract($_POST);

        // VACCINE_TYPE_ID
        // QUANTITY
        // EXPIRY_DATE

        $query = "INSERT INTO vaccine (VACCINE_TYPE_ID, QUANTITY, EXPIRY_DATE, DATE_CREATED) VALUES(?, ?, ?, now());";
        $param = [$VACCINE_TYPE_ID, $QUANTITY, $EXPIRY_DATE];

        $result = $this->helper->regularQuery($query,$param);

       

        if(!$result){
            //return error
            return $this->helper->message("error while processing your request!",200,1);
        }

        //insert log for vaccine
        $query2 = "INSERT INTO vaccine_history (VACCINE_ID,VACCINE_TYPE_ID, QTY_ADD, DATE_CREATED) VALUES(?, ?, ?, now());";
        $param = [$result['insert_id'], $VACCINE_TYPE_ID ,$QUANTITY];
        $result2 = $this->helper->regularQuery($query2,$param);

        return $this->helper->message('Vaccine added successfully!',200,0);
    }

    public function updateQty(){
        extract($_POST);

        $query = "UPDATE vaccine SET QUANTITY = ? WHERE VACCINE_ID = ?";
        $param = [$quantity,$vaccine_id];

        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            //return error
            return $this->helper->message("error while processing your request!",200,1);
        }
        //success 
        return $this->helper->message("Quantity Updated Successfully!",200,0);
    }

    //add vacc type
   public function addVaccType(){
        extract($_POST);

        if(empty($vaccine_type_name) || $vaccine_type_name == null){
            return $this->helper->message('error missing some parameters!',200,1);
        }
        if(empty($description) || $description == null){
            return $this->helper->message('error missing some parameters!',200,1);
        }

        $query = "INSERT INTO vaccine_type (VACCINE_NAME, DESCRIPTION) VALUES(?,?);";
        $param = [$vaccine_type_name,$description];

        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            //error
            return $this->helper->message('error while processing your request!',200,1);
        }
        //success
        return $this->helper->message('New Vaccine Type Added Successfulyl!',200,0);

    }

    //get Vacc Type Details

    public function getVaccTypeDetails(){
        extract($_POST);

        if(empty($id) || $id == null){
            return $this->helper->message('error missing some parameters!',200,1);
        }

        $query = "SELECT * FROM vaccine_type WHERE VACCINE_TYPE_ID = ? LIMIT 1";
        $param = [$id];

        $result = $this->helper->regularQuery($query,$param);

        if(empty($result)){
            return $this->helper->message('No result(s) found!',200,1);
        }

        return $this->helper->message('success',200,0,$result);
    }

    //update vaccine name
    public function updateVaccType(){
        extract($_POST);

        if(empty($vaccine_type_id) || $vaccine_type_id == null){
            return $this->helper->message('error missing some parameters!',200,1);
        }

        if(empty($vaccine_type_name) || $vaccine_type_name == null){
            return $this->helper->message('error missing some parameters!',200,1);
        }
        if(empty($description) || $description == null){
            return $this->helper->message('error missing some parameters!',200,1);
        }


        $query = "UPDATE vaccine_type SET VACCINE_NAME = ?, DESCRIPTION = ? WHERE VACCINE_TYPE_ID = ?";
        $param = [$vaccine_type_name,$description,$vaccine_type_id];

        $update = $this->helper->regularQuery($query,$param);

        if(!$update){
            //error
            return $this->helper->message('error while processing your request!',200,1);
        }

        //success
        return $this->helper->message('Vaccine Name Updated Successfully!',200,0);
    }

}