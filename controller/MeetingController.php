<?php

namespace controller;

use service\MeetingService;
use view\View;

require_once "service/MeetingService.php";
class MeetingController
{
    private MeetingService $meetingService;
    private View $view;

    public function __construct(){
        $this->meetingService = new MeetingService();
        $this->view = new View();
    }

    public function getMeetingGet()
    {
        $acts = $this->meetingService->getMeetings();
        $this->view->showResponse($acts, "meeting", "found");
    }

    public function getMeetingIdGet()
    {
        $id = $_GET["id"];
        $act = $this->meetingService->getMeeting($id);
        $this->view->showResponse($act, "meeting", "found");
    }

    public function createMeetingPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $actInserted = $this->meetingService->insertMeeting($data);
        $this->view->showResponse($actInserted, "meeting", "inserted");
    }

    public function updateMeetingPut()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $actUpdated = $this->meetingService->updateMeeting($data);
        $this->view->showResponse($actUpdated, "meeting", "updated");
    }

    public function removeMeetingDelete()
    {
        $id = $_GET['id'];
        $actDeleted = $this->meetingService->deleteMeeting($id);
        $this->view->showResponse($actDeleted, "meeting", "deleted");
    }

}