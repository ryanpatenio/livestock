<?php
require("../connection/connection.php");
require_once('../includes/initialize.php');

class userController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }


    public function store(){
        extract($_POST);

        if(empty($fullname) && empty($username) && empty($password) && empty($account_type)){
            return $this->helper->message("error! missing some parameters!",200,1);
        }

        //check username
        $isExist = $this->usernameIsExist($username);

        if($isExist){
            //username is already Taken
            return $this->helper->message('Username is already Taken!',200,1);
        }

        $query = "INSERT INTO user (FULL_NAME, USERNAME, PASSWORD, ACCOUNT_TYPE_ID, status) VALUES(?, ?, ?, ?, '0');";
        $password_hash = password_hash($password,PASSWORD_DEFAULT);
        $param = [$fullname,$username,$password_hash,$account_type];
        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            return $this->helper->message('Error While processing your request!',200,1);
        }
        return $this->helper->message('New User Added Successfully!',200,0);
        
    }

    public function getUser(){
        extract($_POST);

        if(empty($user_id)){
            return $this->helper->message('error missing some Parameters!',200,1);
        }

        $query = "select u.ID as user_id,a.ID as account_type_id,a.ACCOUNT_TYPE,u.FULL_NAME as fullname,u.USERNAME as username from user u, account_type a where u.ACCOUNT_TYPE_ID = a.ID and u.ID = ? LIMIT 1";
        $param = [$user_id];
        $result = $this->helper->regularQuery($query,$param);

        if(!$result){
            return $this->helper->message('error while processing your request!',200,1);
        }

        return $this->helper->message('success!',200,0,$result);
    }

    public function update(){
        extract($_POST);
        
        if(empty($user_id) || $user_id == null){
            return $this->helper->message("error! missing some parameters!",200,1);
        }

        if(empty($fullname) && empty($username) && empty($password) && empty($account_type)){
            return $this->helper->message("error! missing some parameters!",200,1);
        }
        
        //check if the username is already exist
        $isUsernameExist = $this->isUsernameUpdateExist($username,$user_id);//if true username is already exist
        if($isUsernameExist){
            //username is already exist
            return $this->helper->message('Username is already Exist!',200,1);
        }

        $query = "UPDATE user SET FULL_NAME = ?, USERNAME = ?, PASSWORD = ?, ACCOUNT_TYPE_ID = ? WHERE ID = ?";
        $pass_hash = password_hash($password,PASSWORD_DEFAULT);
        $param = [$fullname, $username, $pass_hash, $account_type, $user_id];

        $update = $this->helper->regularQuery($query,$param);

        if(!$update){
            return $this->helper->message('error while processing your request!',200,1);
        }

        return $this->helper->message('User updated Successfully!',200,0);
        
    }
    public function updateMyAccount(){
        extract($_POST);
        if(empty($user_id) && empty($username) && empty($password) && empty($fullname)){
            return $this->helper->message('error missing some parameters!',200,1);
        }

        $isUsernameExist = $this->isUsernameUpdateExist($username, $user_id);
        if($isUsernameExist){
            //username is already exist
            return $this->helper->message('Username is Already Exist!',200,1);
        }

        $query = "UPDATE user SET USERNAME = ?, FULL_NAME = ? ,PASSWORD = ? WHERE ID = ?";
        $password_hash = password_hash($password,PASSWORD_DEFAULT);

        $param = [$username, $fullname, $password_hash, $user_id];

        $update = $this->helper->regularQuery($query,$param);

        if(!$update){
            return $this->helper->message('error while processing your request!',200,1);
        }

        return $this->helper->message('Account Updated Successfully!',200,0);
    }

    //method to check if the username is already taken 
    function usernameIsExist($username){
        if(empty($username)){
            return false;
        }

        $query = "SELECT * from user where USERNAME = ? LIMIT 1";
        $param = [$username];
        $result = $this->helper->regularQuery($query,$param);

        if(!empty($result)){
            //username exist
            return true;
        }
        return false;
    }

    //update check username is exist
    function isUsernameUpdateExist($username,$user_id){
        if(empty($user_id) && empty($username)){
            return false;
        }

        $query = "SELECT * from user where USERNAME = ? AND ID not in(?)";
        $param = [$username, $user_id];
        $result = $this->helper->regularQuery($query,$param);

        if(! empty($result)){
            //username is already exist
            return true;
        }

        return false;
    }


}