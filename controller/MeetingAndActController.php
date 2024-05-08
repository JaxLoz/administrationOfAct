<?php

namespace controller;

use service\MeetingAndActService;
use view\View;

require_once "service/MeetingAndActService.php";

class MeetingAndActController
{

    private MeetingAndActService $meetAndActService;
    private View $view;

    public function __construct(){
        $this->meetAndActService = new MeetingAndActService();
        $this->view = new View();
    }

    public function getMeetAndActIdGet()
    {
        $id = $_GET["id"];
        $act = $this->meetAndActService->getMeetAndAct($id);
        $this->view->showResponse($act, "meetAndAct", "found");
    }

    public function createMeetAndActPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $actInserted = $this->meetAndActService->insertMeetAndAct($data);
        $this->view->showResponse($actInserted, "meetAndAct", "inserted");
    }

    public function updateMeetAndActPut()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $actUpdated = $this->meetAndActService->updateMeetAndAct($data);
        $this->view->showResponse($actUpdated, "meetAndAct", "updated");
    }

    public function removeMeetAndActDelete()
    {
        $id = $_GET['id'];
        $actDeleted = $this->meetAndActService->deleteMeetAndAct($id);
        $this->view->showResponse($actDeleted, "meetAndAct", "deleted");
    }

    public function removeMeetAndActByIdsDelete (){
        $idAct = $_GET["idAct"];
        $idMeeting = $_GET["idMeeting"];
        $meetingAndAct = $this->meetAndActService->deleteMeetAndActWhitIds($idAct, $idMeeting);
        $this->view->showResponse($meetingAndAct, "meetAndAct", "deleted");
    }

}