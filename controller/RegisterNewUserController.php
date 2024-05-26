<?php

namespace controller;

use service\RegisterNewUserService;
use view\View;

require_once "service/RegisterNewUserService.php";

class RegisterNewUserController
{

    private RegisterNewUserService $registerNewUserService;
    private View $view;

    public function __construct()
    {
        $this->registerNewUserService = new RegisterNewUserService();
        $this->view = new View();
    }

    public function registerUserPost()
    {
        $newUser = json_decode(file_get_contents('php://input'), true);
        $idNewUser = $this->registerNewUserService->registerNewUser($newUser);
        $this->view->showResponse($idNewUser, "New User", "Registered");
    }

}