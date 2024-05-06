<?php

namespace controller;

use model\Act;
use service\ActService;
use view\View;

require "model/Act.php";
require_once "service/ActService.php";


class ActController
{

    private ActService $actService;
    private View $view;

    public function __construct(){
        $this->actService = new ActService();
        $this->view = new View();
    }

    public function getActsGet()
    {
        $acts = $this->actService->getActs();
        $this->view->showResponse($acts, "acts", "found");
    }

    public function getActIdGet()
    {
        $id = $_GET["id"];
        $act = $this->actService->getAct($id);
        $this->view->showResponse($act, "act", "found");
    }

    public function getAllInfoActsByUserGet(){
        $idUser = $_GET["id"];
        $infoActs = $this->actService->getAllInfoActByUser($idUser);
        $this->view->showResponse($infoActs, "info", "found");
    }

    public function createActPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $actInserted = $this->actService->insertAct($data);
        $this->view->showResponse($actInserted, "act", "inserted");
    }

    public function updateActPut()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $actUpdated = $this->actService->updateAct($data);
        $this->view->showResponse($actUpdated, "act", "updated");
    }

    public function removeActDelete()
    {
        $id = $_GET['id'];
        $actDeleted = $this->actService->deleteAct($id);
        $this->view->showResponse($actDeleted, "act", "deleted");
    }

    public function getActsOfUserGet()
    {
        $idUser = $_GET['id'];
        $actsByUser = $this->actService->getActByUser($idUser);
        $this->view->showResponse($actsByUser, "acts", "found");
    }

}