<?php

namespace service;

use dao\ActDao;
use interfaceDAO\DaoInterface;

require "dao/ActDao.php";

class ActService
{

    private DaoInterface $actDao;

    public function __construct(){
        $this->actDao = new ActDao();
    }

    public function getActs(){
        return $this->actDao->getAll();
    }

    public function getAct($id)
    {
        return $this->actDao->getById($id);
    }

    public function getAllInfoActByUser($idUser)
    {
        return $this->actDao->getAllInfActOfUser($idUser);
    }

    public function getActByUser(int $id)
    {
        return $this->actDao->getActOfUser($id);
    }

    public function insertAct($data): array
    {
        return $this->actDao->insertRegister($data);
    }

    public function updateAct($data): bool
    {
        $id = $data["id"];
        unset($data["id"]);
        return $this->actDao->updateRegister($data, $id);
    }

    public function deleteAct($id): bool{
        return $this->actDao->deleteRegister($id);
    }
}