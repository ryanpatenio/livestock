<?php 

	$host = "localhost";
	$username = "root";
	$password = ""; 
	$database = "dispersal_db"; 

	$con = new mysqli($host, $username, $password, $database);

	//Check the Connection
	if ($con->connect_error){
		die("Connection Failed: ".$con->connect_error);
	}



?>