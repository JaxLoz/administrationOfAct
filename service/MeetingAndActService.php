<?php

namespace service;

use dao\MeetingAndActDao;
use interfaceDAO\DaoInterface;

class MeetingAndActService
{

    private DaoInterface $meetingAndActDao;

    public function __construct(){
        $this->meetingAndActDao = new MeetingAndActDao();
    }

    public function getMeetAndAct($id)
    {
        return $this->meetingAndActDao->getById($id);
    }

    public function insertMeetAndAct($data): int
    {
        return $this->meetingAndActDao->insertRegister($data);
    }

    public function updateMeetAndAct($data): bool
    {
        $id = $data["id"];
        unset($data["id"]);
        return $this->meetingAndActDao->updateRegister($data, $id);
    }

    public function deleteMeetAndAct($id): bool{
        return $this->meetingAndActDao->deleteRegister($id);
    }
}