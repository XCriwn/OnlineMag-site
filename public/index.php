<?php
const BASE_PATH = __DIR__ . '/../';
require BASE_PATH . "vendor/autoload.php";

session_start();

require BASE_PATH . "database/Response.php";
require BASE_PATH . "core/functions.php";
require base_path('bootstrap.php');

$router = new \core\Router();

$uri = parse_url($_SERVER["REQUEST_URI"])['path'];

$method = $_POST['_method'] ?? $_SERVER['REQUEST_METHOD'];

$routes = require base_path('core/routes.php');

try{
    $router->route($uri, $method);
}catch(\core\ValidationException $exception){
    \core\Session::flash('errors', $exception->getErrors());
    \core\Session::flash('old', $exception->getOld());

    return redirect($router->previousUrl());
}


\core\Session::unflash();
