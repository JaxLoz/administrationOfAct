<?php

namespace service;

use dao\CredentialDao;
use DateInterval;
use DateTime;
use DateTimeZone;
use Exception;
use util\UtilesTools;

require_once "dao/CredentialDao.php";
class ValidateEmailService
{
    private CredentialDao $credentialDao;

    public function __construct()
    {
        $this->credentialDao = new CredentialDao();
    }

    public function validateEmailVerificationCode($data): bool
    {
        $isVerified = false;
        $dataUpdateCode = $data;
        unset($dataUpdateCode["id"]);

        if ($this->compareVerificationCode($data["id"], $data["verification_code"])) {
            $isVerified = $this->credentialDao->updateRegister($data["id"], $dataUpdateCode);
        }

        return $isVerified;
    }

    public function refreshVerificationCode($data): bool
    {
        $isUpdatedVerificationCode = $this->updateVerificationCode($data);
        $isRefreshed = false;
        if ($isUpdatedVerificationCode) {
            // logica de envio de Email con el nuevo token
            $isRefreshed = true;
        }

        return $isRefreshed;
    }

    private function updateVerificationCode($data): bool
    {
        $id = $data["id"];
        $newCode = $this->generateValidationCode();
        $updateCodeExpirationDate = $this->generateCodeExpirationDate();

        $data["verification_code"] = $newCode;
        $data["code_expires_at"] = $updateCodeExpirationDate;

        unset($data["id"]);
        return $this->credentialDao->updateRegister($data, $id);
    }

    private function compareVerificationCode(int $id, string $verificationCode): bool
    {
        $isValid = false;
        $infoCredential = $this->credentialDao->getById($id);
        $dateCurrent = UtilesTools::getCurrentDate('America/Bogota');
        if(strcmp($infoCredential["verification_code"], $verificationCode) !== 0 && strtotime($infoCredential["code_expires_at"]) > strtotime($dateCurrent)){
            $isValid = true;
        }

        return $isValid;
    }

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
}