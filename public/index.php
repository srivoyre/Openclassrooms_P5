<?php
require_once '../config/dev.php';
require_once '../vendor/autoload.php';
use Tracy\Debugger;
Debugger::enable();
session_start();
$router = new App\src\Router();
$router->run();
