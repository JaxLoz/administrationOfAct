<?php

namespace EmailConfig;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require "vendor/autoload.php";

class EmailConfig
{

    private PHPMailer $email;
    private string $userName;
    private string $password;

    public function __construct(){
        $this->email = new PHPMailer(true);
        $this->userName = "adactsup@gmail.com";
        $this->password = "yvbd hdfq qnjr caoq";
        try {
            $this->configSMTP();
        }catch (Exception $e){
            echo $e->getMessage();
        }
    }

    /**
     * @throws Exception
     */
    private function configSMTP (){
        $this->email->SMTPDebug = 0;
        $this->email->isSMTP();
        $this->email->SMTPAuth = true;
        $this->email->Host = "smtp.gmail.com";
        $this->email->Port = 587;
        $this->email->SMTPSecure = "tls";

        $this->email->Username = $this->userName;
        $this->email->Password = $this->password;
        $this->email->setFrom($this->userName, "AdministrationActs.com");

    }

    public function setRecipient ($recipient)
    {
        try {
            $this->email->addAddress($recipient, "Destination");
        }catch (exception $e){
            echo $e->getMessage();
        }
    }
    public function sendEmailValidationEmail($validationCode): bool
    {
        $mailSent = false;
        $this->email->isHTML(true);
        $this->email->Subject = "Validation Email";
        $this->email->Body = str_replace("VerificationCode", $validationCode, file_get_contents("EmailConfig/HtmlTemplates/formatVerificationCode.html"));
        try{
            $this->email->send();
            $mailSent = true;
        }catch (Exception $e){
            echo $e->getMessage();
        }
        $this->email->clearAddresses();
        $this->email->smtpClose();

        return $mailSent;
    }

    public function sendEmailInvitationMeeting($infoInvitationMeeting): bool
    {
        $mailSent = false;
        $arraySearch = ['firstname', 'lastname', 'NameMeeting', 'PlaceMeeting', 'dateMeeting', 'timeMeeting'];

        $this->email->isHTML(true);
        $this->email->Subject = "invitation to the meeting";
        $this->email->Body = str_replace($arraySearch, array_values($infoInvitationMeeting), file_get_contents('EmailConfig/HtmlTemplates/formatInvitationMeeting.html'));

        try{
            $this->email->send();
            $mailSent = true;
        }catch (Exception $e){
            echo $e->getMessage();
        }
        $this->email->clearAddresses();
        $this->email->smtpClose();
        return $mailSent;
    }

}