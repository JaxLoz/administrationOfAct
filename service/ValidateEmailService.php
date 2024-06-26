<?php

namespace service;

use dao\CredentialDao;
use DateInterval;
use DateTime;
use DateTimeZone;
use EmailConfig\EmailConfig;
use Exception;
use util\UtilesTools;

require_once "dao/CredentialDao.php";
require_once "EmailConfig/EmailConfig.php";
class ValidateEmailService
{
    private CredentialDao $credentialDao;
    private EmailConfig $emailConfig;

    public function __construct()
    {
        $this->credentialDao = new CredentialDao();
        $this->emailConfig = new EmailConfig();
    }

    public function validateEmailVerificationCode($data): bool
    {
        $isVerified = false;
        $credentials = $this->credentialDao->getByParams("email", $data["email"]);
        $dataUpdateCode = [
            "is_verified" => 1
        ];

        if ($this->compareVerificationCode($credentials["id"], $data["verification_code"])) {
            $isVerified = $this->credentialDao->updateRegister($dataUpdateCode, $credentials["id"]);
        }

        return $isVerified;
    }

    public function refreshVerificationCode($data): bool
    {
        $isUpdatedVerificationCode = $this->updateVerificationCode($data);
        $isRefreshed = false;
        if ($isUpdatedVerificationCode) {

            $isRefreshed = true;
        }

        return $isRefreshed;
    }

    private function updateVerificationCode($data): bool
    {
        $credentials = $this->credentialDao->getByParams("email", $data["email"]);
        $id = $credentials["id"];
        $newCode = $this->generateValidationCode();
        $updateCodeExpirationDate = $this->generateCodeExpirationDate();

        $data["verification_code"] = $newCode;
        $data["code_expires_at"] = $updateCodeExpirationDate;
        unset($data["email"]);
        return $this->credentialDao->updateRegister($data, $id);
    }

    // verificacion del codigo de validacion
    private function compareVerificationCode(int $id, string $verificationCode): bool
    {
        $isValid = false;
        $infoCredential = $this->credentialDao->getById($id);
        $dateCurrent = UtilesTools::getCurrentDate('America/Bogota');
        if(strcmp($infoCredential["verification_code"], $verificationCode) == 0 && strtotime($infoCredential["code_expires_at"]) > strtotime($dateCurrent)){
            $isValid = true;
        }

        return $isValid;
    }

    // insercion del codigo de validacion a los datos de registro de un nuevo usuario
    public function enterValidationCode(array $data): array
    {
        $dataWithVerificationCode = $data;

        $validationCode = $this->generateValidationCode();
        $codeExpirationDate = $this->generateCodeExpirationDate();

        $dataWithVerificationCode["is_verified"] = 0;
        $dataWithVerificationCode["verification_code"] = $validationCode;
        $dataWithVerificationCode["code_expires_at"] = $codeExpirationDate;

        return $dataWithVerificationCode;
    }

    private function generateValidationCode(): string
    {
        $verificationCode = "";
        try{
            $verificationCode = bin2hex(random_bytes(3));
        }catch (Exception $e){
            echo "Error generating the email validation code";
        }
        return $verificationCode;
    }

    private function generateCodeExpirationDate(): string
    {
        $expirationDate = null;
        try {
            $currentDate = new DateTime('now', new DateTimeZone("America/Bogota"));
            $expirationDate = $currentDate->add(new DateInterval("PT15M")); // aumentamos en 15 min la fecha actual
        }catch (Exception $e){
            echo "Error generating expiration date";
        }
        return $expirationDate->format("Y-m-d H:i:s");
    }

    // Metodo encargado de enviar el Email con el codigo de verificacion que esta almacenado en el registro de la nueva credencial
    function sendValidationCodeToEmail(string $email): bool
    {

        $infoCredentials = $this->credentialDao->getByParams("email", $email);
        $this->emailConfig->setRecipient($infoCredentials["email"]);

        return $this->emailConfig->sendEmailValidationEmail($infoCredentials["verification_code"]);
    }

    function findInfoCredentials($data)
    {
        return $this->credentialDao->getByParams("email", $data["email"]);
    }
}