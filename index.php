<?php
use controller\UserController;
use controller\RolController;
use jwt\TokenAuth;
use model\User;

require ".\controller\UserController.php";
require  ".\controller\RolController.php";
require "controller/ActController.php";
require  'controller/CommimentController.php';
require  'controller/ActaAndCommitController.php';
require "controller/CredentialController.php";
require "controller/MeetingController.php";
require "controller/MeetingAndActController.php";
require "controller/RegisterNewUserController.php";
require_once "jwt/TokenAuth.php";

$routes = [

    "routesAuth" => [
        "act" => "\\controller\\ActController",
        'commiment' => '\\controller\\CommimentController',
        'actOnCommit' => '\\controller\\ActaAndCommitController',
        "meeting" => "\\controller\\MeetingController",
        "meetAndAct" => "\\controller\\MeetingAndActController"
    ],

    "routesWhitOutAuth" => [
        "register" => "\\controller\\RegisterNewUserController",
        "singup" => "\\controller\\CredentialController",
        "validationEmail" => "\\controller\\ValidationEmailController",
        "user" => "\\controller\\UserController",
        "rol" => "\\controller\\RolController"
    ]


];

header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method, Authorization, Bearer");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");

$method = $_SERVER['REQUEST_METHOD'];
$authorizationHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? null;

if($method == "OPTIONS") {
    http_response_code(200);
    exit();
}



$tokenAuth = new TokenAuth();


$request_uri = $_SERVER["REQUEST_URI"];
$query_uri = parse_url($request_uri, PHP_URL_QUERY);
parse_str($query_uri, $query_params);


$controllerName = isset($query_params["controller"]) ? $query_params["controller"] : "";
$action = isset($query_params["action"]) ? $query_params["action"] : "";

if(isset($routes["routesAuth"][$controllerName]) && $authorizationHeader != null) {
    if($tokenAuth->authenticationJWTToken($authorizationHeader)){
        $className = $routes["routesAuth"][$controllerName];
        $instance = new $className;

        $requestType = $_SERVER["REQUEST_METHOD"];
        $methodName = $action . ucfirst(strtolower($requestType));

        if(method_exists($instance, $methodName)){
            $instance->$methodName();
        }else{
            http_response_code(404);
        }
    }
}else if(isset($routes["routesWhitOutAuth"][$controllerName])) {
    $className = $routes["routesWhitOutAuth"][$controllerName];
    $instance = new $className;

    $requestType = $_SERVER["REQUEST_METHOD"];
    $methodName = $action . ucfirst(strtolower($requestType));

    if(method_exists($instance, $methodName)){
        $instance->$methodName();
    }else{
        http_response_code(404);
    }
}