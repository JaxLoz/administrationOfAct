<?php

namespace service;

use dao\InvitationDao;
use interfaceDAO\DaoInterface;

require_once "dao/InvitationDao.php";

class InvitationService
{
    private DaoInterface $invitationDao;

    public function __construct(){
        $this->invitationDao = new InvitationDao();
    }

    public function getInvitations()
    {
        return $this->invitationDao->getAll();
    }

    public function getInvitation($id)
    {
        return $this->invitationDao->getById($id);
    }

    public function updateInvitation($data): bool
    {
         $id = $data["id"];
         unset($data["id"]);
        return $this->invitationDao->updateRegister($data, $id);
    }

    public function insertInvitation($data)
    {
        $dataInsert = [
            "assistance" => $data["assistance"],
            "id_meeting" => $data["id_meeting"],
        ];
        foreach ($data["invitations"] as $idCredential ){
          $dataInsert["id_credentials"] = $idCredential['id_credential'];
          $this->invitationDao->insertRegister($dataInsert);
        }
    }

    public function deleteInvitation($id): bool
    {
        return $this->invitationDao->deleteRegister($id);
    }


}