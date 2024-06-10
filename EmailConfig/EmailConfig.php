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
        $this->userName = "";
        $this->password = "";
        $this->configSMTP();
    }

    private function configSMTP (){
        $this->email->SMTPDebug = 0;
        $this->email->isSMTP();
        $this->email->SMTPAuth = true;
        $this->email->Host = "smtp.gmail.com";
        $this->email->Port = 587;
        $this->email->SMTPSecure = "tls";

        $this->email->Username = $this->userName;
        $this->email->Password = $this->password;
    }

    /**
     * @throws Exception
     */
    public function setSenderAndRecipient ($sender, $recipient)
    {
        $this->email->setFrom($sender, "AdministrationActs");
        $this->email->addAddress($recipient, "Destination");
    }
    public function sendEmailValidationEmail($validationCode)
    {
        $this->email->isHTML(true);
        $this->email->Subject = "Validation Email";
        $this->email->Body = str_replace("VerificationCode", $validationCode, file_get_contents("EmailConfig/HtmlTemplates/formatVerificationCode.html"));
        try{
            $this->email->send();
        }catch (Exception $e){
            echo $e->getMessage();
        }
        $this->email->clearAddresses();
        $this->email->smtpClose();
    }

}