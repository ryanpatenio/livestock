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

//query for displaying the data vaccine received logs
//     SELECT 
//     vt.VACCINE_TYPE_ID,
//     vt.VACCINE_NAME,
//     vt.DESCRIPTION,
//     vh.QTY_ADD AS received,
//     vh.DATE_CREATED AS log_date
// FROM 
//     vaccine_type vt
// JOIN 
//     vaccine_history vh ON vt.VACCINE_TYPE_ID = vh.VACCINE_TYPE_ID
// WHERE 
//     vt.VACCINE_TYPE_ID = 6
// ORDER BY 
//     vh.DATE_CREATED ASC;


}