<?php
use controller\UserController;
use controller\RolController;
use model\User;


require ".\controller\UserController.php";
require  ".\controller\RolController.php";
require "controller/ActController.php";
require  'controller/CommimentController.php';
require  'controller/ActaAndCommitController.php';

$routes = [
    "user" => "\\controller\\UserController",
    "rol" => "\\controller\\RolController",
    "act" => "\\controller\\ActController",
    'commiment' => '\\controller\\CommimentController',
    'actOnCommit' => '\controller\ActaAndCommitController'
];

$request_uri = $_SERVER["REQUEST_URI"];
$query_uri = parse_url($request_uri, PHP_URL_QUERY);
parse_str($query_uri, $query_params);


$controllerName = isset($query_params["controller"]) ? $query_params["controller"] : "";
$action = isset($query_params["action"]) ? $query_params["action"] : "";

if(isset($routes[$controllerName])){

    $className = $routes[$controllerName];
    $instance = new $className;

    $requestType = $_SERVER["REQUEST_METHOD"];

    $methodName = $action . ucfirst(strtolower($requestType));

    if(method_exists($instance, $methodName)){
        $instance->$methodName();
    }else{
        http_response_code(404);
    }
}