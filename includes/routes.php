<?php

require_once('../includes/initialize.php');
$action = $_GET['action'];

// Create the Helper instance (passing in the database connection)
$helper = new Helper($con);


// Create the Controller instance and pass the Helper
$clientController = new clientController($helper);
$scheduleController = new scheduleController($helper);
$cattleController = new cattleController($helper);
$vaccineController = new vaccineController($helper);
$dispersalController = new dispersalController($helper);
$categoryController = new categoryController($helper);

$userController = new userController($helper);
$authController = new authController($helper);

if($action == 'addClient'){

    $addC = $clientController->store();
	// $login = $tryLog->AuthenticateUser();
	// if($login)
	// 	echo $login;
			return $addC;
}

if($action == "addSchedule"){
	$addSched = $scheduleController->store();
	
	return $addSched;
}

if($action == "getClientData"){
	$getData = $clientController->get();

	return $getData;
}

if($action == "updateClient"){
	$updateC  = $clientController->update();

	return $updateC;
}

if($action == "addCattle"){
	$addCattle = $cattleController->store();

	return $addCattle;
}
if($action == "addCattleStaff"){
	$addCattle2 = $cattleController->storeStaff();

	return $addCattle2;
}

if($action == 'approveSchedule'){
	$approveSched = $scheduleController->update();

	return $approveSched;
}

if($action == "updateRequirements"){
	$updateReq = $scheduleController->updatRequirements();

	return $updateReq;
}

if($action == "getSchedDate"){
	$schedDate = $scheduleController->getScheduleDate();

	return $schedDate;
}

if($action == "addVaccine"){
	$addVaccine = $vaccineController->store();
	return $addVaccine;
}

if($action == "updateQty"){
	$updateQty = $vaccineController->updateQty();
	return $updateQty;
}

if($action == "addDispersal"){
	$addDispersal = $dispersalController->store();

	return $addDispersal;
}

if($action == "getScheduleData"){
	$scheduleData = $scheduleController->getSchedule();

	return $scheduleData;
}

if($action == "addAnimalVaccine"){
	$addAnimalVaccine = $scheduleController->vaccinateAnimal();

	return $addAnimalVaccine;
}

if($action == "getAnimalDetails"){
	$animal = $cattleController->getAnimalDetails();
	return $animal;
}

if($action == "getDispersal"){
	$getDispersal = $dispersalController->get();
	return $getDispersal;
}

if($action == "addFirstPayment"){
	$firstPayment = $dispersalController->firstPayment();
	return $firstPayment;
}
if($action == "addSecondPayment"){
	$secondPayment = $dispersalController->secondPayment();
	return $secondPayment;
}
if($action == 'getAnimalsByClientFemale'){
	$femaleAnimal = $cattleController->getFemaleAnimalsByClient();
	return $femaleAnimal;
}

if($action == "addUser"){
	$newUser = $userController->store();
	return $newUser;
}

if($action == "getUser"){
	$userData = $userController->getUser();
	return $userData;
}

if($action == "updateUser"){
	$update = $userController->update();
	return $update;
}

//login
if($action == "login"){
	$res = $authController->authenticate();
	return $res;
}

//updating account
if($action == "updateMyAccount"){
	$isUpdated = $userController->updateMyAccount();
	return $isUpdated;
}

//add category
if($action == 'addCategory'){
	$add = $categoryController->store();
	return $add;
}

//get category
if($action == 'getCategory'){
	$category = $categoryController->get();
	return $category; 
}

//update category
if($action == 'updateCategory'){
	$update = $categoryController->update();
	return $update;
}

//add new Vaccine Type
if($action == "addVaccType"){
	$addVaccType = $vaccineController->addVaccType();
	return $addVaccType;
}

//get vacc type details
if($action == "getVaccTypeDetails"){
	$getVaccType = $vaccineController->getVaccTypeDetails();
	return $getVaccType;
}

//update vaccine type name
if($action == "updateVaccTypeName"){
	$updateVaccTypeName = $vaccineController->updateVaccType();
	return $updateVaccTypeName;
}