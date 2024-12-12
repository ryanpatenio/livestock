<?php

// Ensure config.php is loaded only once
require_once('../includes/config.php');

// Use ROOT_PATH for other includes
require_once(ROOT_PATH . '/includes/helper.php');
require_once(ROOT_PATH . '/administrator/Controllers/clientController.php');
require_once(ROOT_PATH . '/administrator/Controllers/scheduleController.php');
require_once(ROOT_PATH . '/administrator/Controllers/cattleController.php');
require_once(ROOT_PATH . '/administrator/Controllers/vaccineController.php');