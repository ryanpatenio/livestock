<?php
require("../connection/connection.php");
require_once('../includes/initialize.php');

class inventoryController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }


    public function getAvailableInventory(){

        $query  = "SELECT VACCINE_NAME,
                          VACCINE_TYPE,
                          sum(QUANTITY) as available_quantity,
                          DATE_CREATED
                    FROM VACCINE
                    WHERE DATE_EXPIRED > now()
                    GROUP BY VACCINE_NAME, VACCINE_TYPE, DATE_CREATED
                    ORDER BY DATE_CREATED ASC        

        ";

        $result = $this->helper->regularQuery($query);
        if(!$result){
            //return error
            return $this->helper->message('error while processing Data...',200,1);
        }

        return $result;
        
    }

}