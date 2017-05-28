<?php

// Config
ini_set('display_errors', 1);
error_reporting(E_ALL);

session_start();

// Connect files
define('ROOT', dirname(__FILE__));
require_once (ROOT. '/components/autoload.php');

// Start router
$router = new Router();
$router->run();