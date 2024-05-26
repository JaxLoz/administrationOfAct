<?php

namespace service;


class RegisterNewUserService
{
    private UserService $userService;
    private CredentialService $credentialService;

    public function __construct(){
        $this->userService = new UserService();
        $this->credentialService = new CredentialService();
    }

    public function registerNewCredentials ($data): array
    {
        $newCredentials = [
            "email" => $data["email"],
            "user_password" => $data["user_password"]
        ];

        return $idCredentials = $this->credentialService->registerCredentialOfUser($newCredentials);
    }

    public function registerNewUser ($data): array
    {
        $idCredentiasl = $this->registerNewCredentials($data);

        $newUser = [
            "firstname" => $data["firstname"],
            "lastname" => $data["lastname"],
            "id_rol" => $data["id_rol"],
            "phone" => $data["phone"],
            "id_credential" => $idCredentiasl["id"]
        ];
        return $this->userService->insertUser($newUser);
    }
}