<?php
@session_start();
// Ensure config.php is loaded only once
require_once('../includes/config.php');

// Use ROOT_PATH for other includes

//helper
require_once(ROOT_PATH . '/includes/helper.php');

//Controllers
require_once(ROOT_PATH . '/administrator/Controllers/clientController.php');
require_once(ROOT_PATH . '/administrator/Controllers/scheduleController.php');
require_once(ROOT_PATH . '/administrator/Controllers/cattleController.php');
require_once(ROOT_PATH . '/administrator/Controllers/vaccineController.php');
require_once(ROOT_PATH . '/administrator/Controllers/dispersalController.php');
require_once(ROOT_PATH . '/administrator/Controllers/userController.php');
require_once(ROOT_PATH . '/administrator/Controllers/categoryController.php');

//authentication
require_once(ROOT_PATH . '/administrator/Controllers/authController.php');