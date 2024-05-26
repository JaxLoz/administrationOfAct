<?php

namespace service;

use dao\CredentialDao;
use exceptions\EmailExistsException;
use interfaceDAO\DaoInterface;
use jwt\Jwt;
use util\Bcript;

require_once "dao/CredentialDao.php";
require_once "util/Bcript.php";
require_once "exceptions/EmailExistsException.php";
require_once "exceptions/IncorectPasswordException.php";
require_once "jwt/Jwt.php";

class CredentialService
{

    private DaoInterface $credentialDao;
    private Jwt $jwtToken;

    public function __construct(){
        $this->credentialDao = new CredentialDao();
        $this->jwtToken = new Jwt("oOZbafIovK6dbgmwllUO63j27fyercc/sTYEjD6eakGEdh+Fvj8g3LIsLQ/WyxTDboct+V8j67MPglpq7UfoSA==
");
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

    public function validateCredentials ($data): array
    {
        $emailExist = $this->credentialDao->existRegister("email", $data["email"]);

        $response = [
          "validateCredentials" => false,
          "status" => "",
          "token" => "",
        ];

        if($emailExist){
            $credetials = $this->credentialDao->getByParams("email", $data["email"]);

            if(Bcript::verifyEncrypt($data["user_password"], $credetials["user_password"])){

                unset($credetials["user_password"]);
                $jwtToken = $this->jwtToken->jwtEncode($credetials);

                $response["validateCredentials"] = true;
                $response["status"] = "Credenciales validas";
                $response["token"] = $jwtToken;
            }else{
                $response["validateCredentials"] = false;
                $response["status"] = "Contraseña incorrecta";
            }
        }else{
            $response["validateCredentials"] = false;
            $response["status"] = "El email " . $data["email"] . " no esta registrado";
        }

        return $response;
    }

    public function getInfoUserByCredentials($data)
    {
        $userEmail = $data["email"];
        return $this->credentialDao->getInfoUserByCredentials($userEmail);
    }

    private function buildPayloadJwt()
    {

    }

}