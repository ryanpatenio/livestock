<?php

require_once('../includes/initialize.php');
$action = $_GET['action'];

// Create the Helper instance (passing in the database connection)
$helper = new Helper($con);


// Create the clientController instance and pass the Helper
$clientController = new clientController($helper);

if($action == 'addClient'){

    $addC = $clientController->store();
	// $login = $tryLog->AuthenticateUser();
	// if($login)
	// 	echo $login;
			return $addC;
}