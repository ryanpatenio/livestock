<?php
require("../connection/connection.php");
require_once('../includes/initialize.php');

class authController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }

    public function authenticate(){
        extract($_POST);

        if(empty($username) || empty($password)){
            return $this->helper->message('error! missing some parameters!',200,1);
        }
        $query = "SELECT ID as user_id,FULL_NAME as name,USERNAME as username,PASSWORD as password, case when ACCOUNT_TYPE_ID = 1 THEN 'admin'
                WHEN ACCOUNT_TYPE_ID = 2 THEN 'staff' WHEN ACCOUNT_TYPE_ID = 3 THEN 'super_admin' END as account_type, ACCOUNT_TYPE_ID
                FROM user where USERNAME = ? LIMIT 1";
        $param = [$username];

        $user_inquire = $this->helper->regularQuery($query,$param);

        if(!$user_inquire){
            return $this->helper->message('Invalid Username OR Password!',200,1);
        }

        $user_data = $user_inquire[0];
        $password_hash = $user_data['password'];

        if( ! password_verify($password,$password_hash)){
            return $this->helper->message('Invalid Username OR Password!',200,1);
        }

        //success
        //set SESSION
        $_SESSION['user_id'] = $user_data['user_id'];
        $_SESSION['name'] = $user_data['name'];
        $_SESSION['account_type'] = $user_data['ACCOUNT_TYPE_ID'];

        //@note 1 = ADMIN 2 = STAFF 3= SUPER_ADMIN
        $location = "";
        if($user_data['ACCOUNT_TYPE_ID'] == 1){
            //admin
            $location = '../index2.php?page=dashboard2';
        }else if($user_data['ACCOUNT_TYPE_ID'] == 2){
            //staff
            $location = '../index.php?page=dashboard';
        }else if($user_data['ACCOUNT_TYPE'] == 3){
            //SUPER ADMIN
            $location = '../index2.php?page=dashboard2';
        }else{
            $location = '404 not found';
        }

        return $this->helper->message('success',200,0,$location);
        
        

    }

}