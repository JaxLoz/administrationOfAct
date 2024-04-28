<?php

namespace service;

use dao\UserDao;
use interfaceDAO\DaoInterface;

class ServiceUser
{

    private DaoInterface $userDao;

    public function __construct(){
        $this->userDao = new UserDao();
    }

    public function getUsers (){
        return $this->userDao->getAll();
    }

}