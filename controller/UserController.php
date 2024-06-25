<?php

namespace controller;
use dao\UserDao;
use model\User;
use service\UserService;
use view\View;

require ".\dao\UserDao.php";
require  '.\model\User.php';
require_once "service/UserService.php";
class UserController
{

    private UserDao $userDao;
    private UserService $serviceUser;
    private View $view;

    public function __construct()
    {
        $this->userDao = new UserDao();
        $this->serviceUser = new UserService();
        $this->view = new View();
    }

    public function getDataHTTP()
    {
        return json_decode(file_get_contents("php://input"),true);
    }

    public function getUsersGet()
    {
       $users = $this->serviceUser->getUsers();
       $this->view->showResponse($users, "users", "found");
    }

    public function getUserIdGet(){
        $id = $_GET['id'];
        $user = $this->serviceUser->getUser($id);
        $this->view->showResponse($user, "user", "found");
    }

    public function getUserWithEmailGet()
    {
        $users = $this->serviceUser->getUserWithEmail();
        $this->view->showResponse($users, "users", "usersWithEmail");
    }

    public function getUserForRolGet()
    {

    }

    public function registerUserPost()
    {
        $id = $this->serviceUser->insertUser($this->getDataHTTP());
        $this->view->showResponse($id, "user", "created");
    }

    public function removeUserDelete()
    {
        $id = $_GET["id"];
       $userRevomed = $this->serviceUser->deleteUser($id);
       $this->view->showResponse($userRevomed, "user", "deleted");
    }

    public function updateUserPut()
    {
        $data = $this->getDataHTTP();
        $userUpdate = $this->serviceUser->updateUser($data);
        $this->view->showResponse($userUpdate, "user", "updated");
    }

}