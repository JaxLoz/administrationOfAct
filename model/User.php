<?php

namespace model;

class User {

    private $id;

    private $firtsname;
    private $lastname;
    private $email;
    private $password;

    private $phone;

    private $idRol;


    public function __construct()
    {
        $this->id = 0;
        $this->firtsname = "";
        $this->lastname = "";
        $this->email = "";
        $this->password = "";
        $this->phone = "";
        $this->idRol = 0;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }


    public function getFirtsname()
    {
        return $this->firtsname;
    }

    public function setFirtsname($firtsname): void
    {
        $this->firtsname = $firtsname;
    }


    public function getLastname()
    {
        return $this->lastname;
    }


    public function setLastname($lastname): void
    {
        $this->lastname = $lastname;
    }


    public function getPhone()
    {
        return $this->phone;
    }


    public function setPhone($phone): void
    {
        $this->phone = $phone;
    }



    public function setEmail($email): void
    {
        $this->email = $email;
    }

    public function setPassword($password): void
    {
        $this->password = $password;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getIdRol(): string
    {
        return $this->idRol;
    }

    public function setIdRol(string $idRol): void
    {
        $this->idRol = $idRol;
    }



}

