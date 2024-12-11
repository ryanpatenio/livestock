<?php
// Define BASE_URL only if not already defined
if (!defined('BASE_URL')) {
    define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST'] . dirname($_SERVER['SCRIPT_NAME']) . '/');
}

// Define ROOT_PATH only if not already defined
if (!defined('ROOT_PATH')) {
    define('ROOT_PATH', realpath(dirname(__FILE__) . '/../'));
}
