<?php

namespace service;

use dao\InvitationDao;
use EmailConfig\EmailConfig;
use interfaceDAO\DaoInterface;

require_once "dao/InvitationDao.php";
require_once "EmailConfig/EmailConfig.php";

class InvitationService
{
    private DaoInterface $invitationDao;
    private EmailConfig $emailConfig;

    public function __construct(){
        $this->invitationDao = new InvitationDao();
        $this->emailConfig = new EmailConfig();
    }

    public function getInvitations()
    {
        return $this->invitationDao->getAll();
    }

    public function getInvitation($id)
    {
        return $this->invitationDao->getById($id);
    }

    public function getInfoGuestByMeetingdId($meetindId)
    {
        return $this->invitationDao->getInfoGuestByMeetingId($meetindId);
    }

    public function updateInvitation($data): bool
    {
         $id = $data["id"];
         unset($data["id"]);
        return $this->invitationDao->updateRegister($data, $id);
    }

    public function insertInvitation($data): array
    {
        $i = 0;
        $idsInserted = [];
        $dataInsert = [
            "assistance" => $data["assistance"],
            "id_meeting" => $data["id_meeting"],
        ];
        foreach ($data["invitations"] as $idCredential ){
          $dataInsert["id_credentials"] = $idCredential['id_credential'];
          $idInvitedInserted = $this->invitationDao->insertRegister($dataInsert);
          $idsInserted[$i] = $idInvitedInserted["id"];
          $i++;
        }
        return $idsInserted;
    }

    public function deleteInvitation($id): bool
    {
        return $this->invitationDao->deleteRegister($id);
    }

    public function deleteInvitationByMeetingId($meetingId): bool
    {
        return $this->invitationDao->deleteInvitationByMeetingId($meetingId);
    }

    public function sendEmailInvitation($invitationIds): bool
    {
        $sendEmails = false;
        foreach ($invitationIds['ids_invitation'] as $invitationId) {
            $infoForMail = $this->invitationDao->getInfoUserAndMeetingForEmail($invitationId);
            $this->emailConfig->setRecipient($infoForMail["email"]);
            unset($infoForMail["email"]);
            $sendEmails = $this->emailConfig->sendEmailInvitationMeeting($infoForMail);
        }
        return $sendEmails;
    }

    public function invitationsByCredentials($email)
    {
        return $this->invitationDao->getInvitationsByCredentials($email);
    }
}