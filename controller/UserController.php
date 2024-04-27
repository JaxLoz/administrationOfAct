<?php

namespace controller;
use dao\UserDao;
use model\User;

require ".\dao\UserDao.php";
require  '.\model\User.php';
class UserController
{

    private UserDao $userDao;

    public function __construct()
    {
        $this->userDao = new UserDao();
    }

    public function getDataHTTP()
    {
        return json_decode(file_get_contents("php://input"),true);
    }

    public function getUsersGet()
    {
        $getUsers = $this->userDao->getAll();

        if($getUsers){

            $responseUseGet = [
                'status' => "Informacion recuperada",
                'user' => $getUsers
            ];

            http_response_code(200);
        }else{
            $responseUseGet = [
                'status' => "No se encontro la informacion",
                'user' => $getUsers
            ];

            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseUseGet);
    }

    public function getUserIdGet(){
        $id = $_GET['id'];
        $getUser = $this->userDao->getUserId($id);

        if($getUser){

            $responseUseGet = [
                'status' => "Informacion recuperada",
                'user' => $getUser
            ];

            http_response_code(200);
        }else{
            $responseUseGet = [
                'status' => "No se encontro la informacion",
                'user' => $getUser
            ];

            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseUseGet);
    }

    public function getUserForRolGet()
    {
        $rol = ucfirst(strtolower($_GET['rol']));

        $users = $this->userDao->getUserForRol($rol);

        if($users){

            $responseUsersGet = [
                'status' => "Informacion recuperada",
                'users' => $users
            ];

            http_response_code(200);
        }else{
            $responseUsersGet = [
                'status' => "No se encontro la informacion",
                'user' => $users
            ];

            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseUsersGet);
    }

    public function loginGet()
    {

        $iEmail = $_GET['email'];
        $password = $_GET['password'];

        $user = new User();
        $user->setEmail($iEmail);
        $user->setPassword($password);

        $responseInfo = $this->userDao->loginVerification($user);

        if(isset($responseInfo)){
            $response = [
                "status" => "Sesion iniciada",
                "id" => $responseInfo["id"],
                "user" => $responseInfo["firstname"]." ".$responseInfo["lastname"],
                "email" => $responseInfo["email"],
                "phone" => $responseInfo['phone']

            ];

            $responseAPI = json_encode($response);

            http_response_code(200);
            header("Content-Type: application/json");
            echo $responseAPI;
        }else{
            $response = [
                "status" => "Credenciales incorrectas"
            ];

            $responseAPI = json_encode($response);
            header("Content-Type: application/json");
            echo $responseAPI;
            http_response_code(404);
        }
    }

    public function registerUserPost()
    {
        $data = $this->getDataHTTP();
        $user = new User();
        $user->setFirtsname($data["firtsname"]);
        $user->setLastname($data["lastname"]);
        $user->setEmail($data["email"]);
        $user->setPassword($data["password"]);
        $user->setPhone($data["phone"]);
        $user->setIdRol($data['rol']);

        $infoRegisterUser = $this->userDao->registerUser($user);

        if(isset($infoRegisterUser)){
            $response = [
                "status" => "resgistro exitoso",
                "register" => $infoRegisterUser
            ];

            header("Content-Type: application/json");
            http_response_code(201);
            echo json_encode($response);
        }else{
            $response = [
                "status" => "Fallo al resgistrar",
            ];

            header("Content-Type: application/json");
            http_response_code(500);
            echo json_encode($response);
        }
    }

    public function removeUserDelete()
    {
        $id = $_GET["id"];
        $infoUserDelete = $this->userDao->deleteUser($id);
        if (isset($infoUserDelete)){
            $responseInfoDelete = [
                "Status" => "Informacion eliminada correctamente",
                "id" => $infoUserDelete["id"],
                "firtsname" => $infoUserDelete["firstname"],
                "lastname" => $infoUserDelete["lastname"],
                "phone" => $infoUserDelete["phone"]
            ];

            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($responseInfoDelete);
        }else{
            $responseInfoDelete = [
                "Status" => "Error al eliminar el registro",
            ];

            header("Content-Type: application/json");
            http_response_code(401);
            echo json_encode($responseInfoDelete);
        }
    }

    public function updateUserPut()
    {

        $data = $this->getDataHTTP();
        $user = new User();
        $user->setId($data['id']);
        $user->setFirtsname($data["firtsname"]);
        $user->setLastname($data["lastname"]);
        $user->setEmail($data["email"]);
        $user->setPassword($data["user_password"]);
        $user->setPhone($data["phone"]);

        $infoUser = $this->userDao->updateUser($user);

        if(isset($infoUser)){

            $responseUpdate = [
                'status' => 'Informacion actualizada correctamente',
                'dataUpdate' => $infoUser
            ];
            header("Content-Type: application/json");
            http_response_code(200);
            echo json_encode($responseUpdate);
        }else{
            $responseUpdate = [
                "Status" => "Error al actualizar la informacion",
            ];

            header("Content-Type: application/json");
            http_response_code(401);
            echo json_encode($responseUpdate);
        }

    }

}