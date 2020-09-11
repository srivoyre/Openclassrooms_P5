<?php
require_once '../config/dev.php';
require_once '../vendor/autoload.php';
// Deactivated for prod environment
//use Tracy\Debugger;
//Debugger::enable();
session_start();
$router = new App\Src\Router();
$router->run();
