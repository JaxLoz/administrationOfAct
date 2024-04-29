<?php

namespace service;

use dao\UserDao;
use interfaceDAO\DaoInterface;

class UserService
{

    private DaoInterface $userDao;

    public function __construct(){
        $this->userDao = new UserDao();
    }

    public function getUsers (){
        return $this->userDao->getAll();
    }

    public function getUser($id)
    {
        return $this->userDao->getById($id);
    }

    public function insertUser($data): int
    {
       return $this->userDao->insertRegister($data);
    }

    public function updateUser($data): bool
    {
        $id = $data["id"];
        unset($data["id"]);
        return $this->userDao->updateRegister($data, $id);
    }

    public function deleteUser($id): bool{
        return $this->userDao->deleteRegister($id);
    }

}