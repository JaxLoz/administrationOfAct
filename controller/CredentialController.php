<?php

namespace controller;

use exceptions\EmailExistsException;
use service\CredentialService;
use view\View;

require "service/CredentialService.php";
require "view/View.php";
require_once "exceptions/EmailExistsException.php";
class CredentialController
{

    private CredentialService $credentialService;
    private View $view;

    public function __construct(){
        $this->credentialService = new CredentialService();
        $this->view = new View();
    }

    public function registerCredentialPost (){
        $dataJson = json_decode(file_get_contents("php://input"),true);
        try{
            $idNewCredentials = $this->credentialService->registerCredentialOfUser($dataJson);
            $this->view->showResponse($idNewCredentials, "Credentials", "inserted");
        }catch (EmailExistsException $e){
            $this->view->showAlerts($e->getMessage(), 409);
        }

    }
}