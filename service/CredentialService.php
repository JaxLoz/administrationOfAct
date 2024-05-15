<?php

namespace service;

use dao\CredentialDao;
use exceptions\EmailExistsException;
use exceptions\IncorectPasswordException;
use interfaceDAO\DaoInterface;
use util\Bcript;

require_once "dao/CredentialDao.php";
require_once "util/Bcript.php";
require_once "exceptions/EmailExistsException.php";
require_once "exceptions/IncorectPasswordException.php";

class CredentialService
{

    private DaoInterface $credentialDao;

    public function __construct(){
        $this->credentialDao = new CredentialDao();
    }

    public function registerCredentialOfUser ($data): array{

        $dataCredentials = $data;
        $passwordHash = Bcript::encrypt($dataCredentials["user_password"]);
        $dataCredentials["user_password"] = $passwordHash;

        $emailExist = $this->credentialDao->existRegister("email", $dataCredentials["email"]);
        if(!$emailExist){
            return $this->credentialDao->insertRegister($dataCredentials);
        }else{
            throw new EmailExistsException("El email " . $dataCredentials["email"] . " ya se encuentra registrado");
        }
    }

    public function validateCredentials ($data): bool
    {
        $emailExist = $this->credentialDao->existRegister("email", $data["email"]);
        if($emailExist){
            $credetials = $this->credentialDao->getByParams("email", $data["email"]);
            if(Bcript::verifyEncrypt($data["user_password"], $credetials["user_password"])){
                return true;
            }else{
                throw new IncorectPasswordException("Contraseña incorrecta");
            }
        }else{
            throw new EmailExistsException("El email " . $data["email"] . " no esta registrado");
        }
    }

    public function getInfoUserByCredentials($data)
    {
        $userEmail = $data["email"];
        return $this->credentialDao->getInfoUserByCredentials($userEmail);
    }
}