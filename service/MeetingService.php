<?php

namespace service;

use dao\MeetingDao;
use interfaceDAO\DaoInterface;

class MeetingService
{

    private DaoInterface $meetingDao;
    public function __construct()
    {
        $this->meetingDao = new MeetingDao("meeting");
    }

    public function getMeetings()
    {
        return $this->meetingDao->getAll();
    }

    public function getMeeting($id)
    {
        return $this->meetingDao->getById($id);
    }

    public function insertMeeting($data): int
    {
        return $this->meetingDao->insertRegister($data);
    }

    public function updateMeeting($data): bool
    {
        $id = $data["id"];
        unset($data["id"]);
        return $this->meetingDao->updateRegister($data, $id);
    }

    public function deleteMeeting($id): bool{
        return $this->meetingDao->deleteRegister($id);
    }
}