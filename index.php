<?php
use controller\UserController;
use controller\RolController;
use model\User;


require ".\controller\UserController.php";
require  ".\controller\RolController.php";

$routes = [
    "user" => "\\controller\\UserController",
    "rol" => "\\controller\\RolController"
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


/*
switch ($_SERVER["REQUEST_METHOD"]){
    case "GET":
        http_response_code(204);
        break;

    case "POST":

        $datos = json_decode(file_get_contents("php://input"),true);
        $user = new User(0, $datos["email"], $datos["password"]);
        $userController = new UserController();
        $userController->loginPost($user);

}
*/
