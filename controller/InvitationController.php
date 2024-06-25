<?php

namespace controller;

use service\InvitationService;
use view\View;

require_once "service/InvitationService.php";
require_once "view/View.php";
class InvitationController
{
    private InvitationService $invitationService;
    private View $view;

    public function __construct(){
        $this->invitationService = new InvitationService();
        $this->view = new View();
    }

    public function getInvitationsGet()
    {
        $invitations = $this->invitationService->getInvitations();
        $this->view->showResponse($invitations, "Invitations", "getInvitations");
    }

    public function getInvitationGet(){
        $id = $_GET["id"];
        $invitation = $this->invitationService->getInvitation($id);
        $this->view->showResponse($invitation, "Invitation", "getInvitation");
    }

    public function insertInvitationPost(){
        $infNewInvitation = json_decode(file_get_contents("php://input"), true);
        $this->invitationService->insertInvitation($infNewInvitation);
        //$this->view->showResponse($idInvitationInserted, "Invitation", "InvitationInserted");
    }

    public function updateInvitationPut(){
        $infoInvitationUpdate = json_decode(file_get_contents("php://input"), true);
        $invitationUpdated = $this->invitationService->updateInvitation($infoInvitationUpdate);
        $this->view->showResponse($invitationUpdated, "Invitation", "invitationUpdated");
    }

    public function removeInvitationDelete(){
        $id = $_GET["id"];
        $invitationDeleted = $this->invitationService->deleteInvitation($id);
        $this->view->showResponse($invitationDeleted, "Invitation", "invitationDeleted");
    }

}