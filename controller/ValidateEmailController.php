<?php

namespace controller;

use service\ValidateEmailService;
use view\View;

require_once "service/ValidateEmailService.php";
require_once "view/View.php";
class ValidateEmailController
{
    private ValidateEmailService $validateEmailService;
    private View $view;

    public function __construct(){
        $this->validateEmailService = new ValidateEmailService();
        $this->view = new View();
    }

    public function validateEmailVerificationCodePut()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $isVerified = $this->validateEmailService->validateEmailVerificationCode($data);
        $this->view->showResponse($isVerified, "verification_code", "verification_code");
    }

    public function refreshVerificationCodePut(){
        $data = json_decode(file_get_contents("php://input"), true);
        $isRefreshed = $this->validateEmailService->refreshVerificationCode($data);
        $this->view->showResponse($isRefreshed, "refresh_verification_code", "refresh_verification_code");
    }

}