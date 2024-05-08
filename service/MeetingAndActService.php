<?php

namespace service;

use dao\MeetingAndActDao;
use interfaceDAO\DaoInterface;

require_once "dao/MeetingAndActDao.php";

class MeetingAndActService
{

    private DaoInterface $meetingAndActDao;

    public function __construct(){
        $this->meetingAndActDao = new MeetingAndActDao("meeting_act");
    }

    public function getMeetAndAct($id)
    {
        return $this->meetingAndActDao->getById($id);
    }

    public function insertMeetAndAct($data): array
    {
        return $this->meetingAndActDao->insertRegister($data);
    }

    public function updateMeetAndAct($data): bool
    {
        $id = $data["id"];
        unset($data["id"]);
        return $this->meetingAndActDao->updateRegister($data, $id);
    }

    public function deleteMeetAndAct($id): bool
    {
        return $this->meetingAndActDao->deleteRegister($id);
    }

    public function deleteMeetAndActWhitIds($idAct, $idMeeting): bool
    {
        return $this->meetingAndActDao->deleteMeetingAndActByIds($idAct, $idMeeting);
    }
}