<?php
require("../connection/connection.php");
require_once('../includes/initialize.php');

class categoryController {

   
    private $helper;

    // Constructor to initialize the Helper class
    public function __construct($helper) {
        $this->helper = $helper; // Set the helper instance
    }

    public function store(){
        extract($_POST);

        if(empty($category_name)){
            return $this->helper->message('error missisng some parameters!',200,1);
        }

        //check if category is already exist to avoid duplication
        $isExist = $this->isExist($category_name);
        if($isExist){
            //category is already exist
            return $this->helper->message('Category Name is already Exist! try another Name',200,1);
        }

        $query = "INSERT INTO category (category_name) VALUES(?)";
        $param = [$category_name];

        $insert = $this->helper->regularQuery($query,$param);

        if(!$insert){
            //false
            return $this->helper->message('error while processing your request!',200,1);
        }

        return $this->helper->message('New Category added successfully!',200,0);

        
    }

    public function get(){
        extract($_POST);

        if(empty($cat_id) || $cat_id == null){
            return $this->helper->message('error! missing some parameters!',200,1);
        }

        $query = "SELECT * FROM category where category_id = ? LIMIT 1";
        $param = [$cat_id];
        //execute Query
        $result = $this->helper->regularQuery($query,$param);

        if(empty($result)){
            return $this->helper->message('error! while processing your request!',200,1);
        }

        return $this->helper->message('success',200,0,$result);
    }

    public function update(){
        extract($_POST);

        if(empty($cat_id) || $cat_id == null){
            return $this->helper->message('error! missing some parameters!',200,1);
        }
        if(empty($category_name) || $category_name == ''){
            return $this->helper->message('error! missing some parameters!',200,1);
        }
        //boolean
        $isExist = $this->isExistWithID($cat_id,$category_name);
        if($isExist){
            //expect method returns true @category is already exist
            return $this->helper->message('Category Name is already Exist!',200,1);
        }

        //update
        $query = "UPDATE category SET category_name = ? WHERE category_id = ?";
        $param = [$category_name,$cat_id];

        $update = $this->helper->regularQuery($query,$param);

        if(!$update){
            return $this->helper->message('error! while processing your request!',200,1);
        }

        return $this->helper->message('Selected Category Updated Successfully',200,0);
        
    }

    private function isExist($cat_name){
        if(empty($cat_name)){
            return false;
        }

        $query = "SELECT * FROM category WHERE category_name = ? LIMIT 1";
        $param = [$cat_name];

        $result = $this->helper->regularQuery($query,$param);

        if(empty($result)){
            return false;
        }

        return true;
    }

    //this function is for updating data checking if the category is already exist 
    private function isExistWithID($cat_id,$cat_name){
        if(empty($cat_name) && empty($cat_id)){
            //@true to display error when u use
            return true;
        }
        
        $query = "SELECT * FROM category WHERE category_name = ? and category_id not in(?) LIMIT 1";
        $param = [$cat_name, $cat_id];

        $result = $this->helper->regularQuery($query,$param);

        if(! empty($result)){
            //category name is already exist
            return true;
        }
        return false;
    }

}