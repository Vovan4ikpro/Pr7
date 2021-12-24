<?php

session_start();

require_once 'config/db.php';
require_once 'route/web.php';

ini_set('display_errors', 1);
error_reporting(E_ALL);

$controllerName = isset($_GET['controller']) ? $_GET['controller'] : 'index';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

$routing = new Route();
$db = new Db();

$routing->loadPage($db, $controllerName, $actionName);
