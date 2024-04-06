<?php

namespace controller;

use dao\CommimentDao;
use model\Commiment;

require "dao/CommimentDao.php";
require "model\Commiment.php";

class CommimentController
{
    private $commimentDao;

    public function __construct()
    {
        $this->commimentDao = new CommimentDao();
    }

    public function getCommimentGet(){
        $infoCommiments = $this->commimentDao->getAllCommiment();

        if($infoCommiments){
            $responseCommiment = [
                'status' => "Informacion obtenida",
                'Commiments' => $infoCommiments
            ];

            http_response_code(200);
        }else{
            $responseCommiment = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseCommiment);
    }

    public function getCommmimentForIdGet()
    {
        $id = $_GET["id"];
        $infoCommiment = $this->commimentDao->getCommimentId($id);

        if($infoCommiment){
            $responseCommiment = [
                'status' => "Informacion obtenida",
                'Acta' => $infoCommiment
            ];

            http_response_code(200);
        }else{
            $responseCommiment = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseCommiment);
    }

    public function getActCommitmentsGet()
    {
        $id = $_GET["id"];
        $actCommitments = $this->commimentDao->getCommitmentOfAct($id);

        if($actCommitments){
            $responseActCommitments = [
                'status' => "Commitments of act #".$id,
                'commitments' => $actCommitments
            ];

            http_response_code(200);
        }else{
            $responseActCommitments = ['status' => "Commitments no obtenidos",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseActCommitments);
    }

    public function getCommimentIdGet()
    {
        $id = $_GET["id"];
        $infoCommiment = $this->commimentDao->getCommimentId($id);

        if($infoCommiment){
            $responseCommiment = [
                'status' => "Informacion obtenida",
                'Compromiso' => $infoCommiment
            ];

            http_response_code(200);
        }else{
            $responseCommiment = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseCommiment);
    }

    public function insertCommimentPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $newCommiment = new Commiment();
        $newCommiment->setName($data['name']);
        $newCommiment->setStatus($data['status']);
        $newCommiment->setDescription($data['description']);

        $infoCommimentCreate = $this->commimentDao->insertCommiment($newCommiment);

        if(isset($infoCommimentCreate)){
            $responseCommimentCreate = [
                'status' => "Compromiso registrado correctamente",
                'response' => $infoCommimentCreate
            ];

            http_response_code(201);
        }else{
            $responseCommimentCreate = [
                'status' => "no se pudo registrar el compromiso",
                'response' => $infoCommimentCreate
            ];

            http_response_code(500);
        }

        header("Content-Type: application/json");
        echo json_encode($responseCommimentCreate);
    }
    
    public function updateCommimentPut()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $commiment = new Commiment();
        $commiment->setId($data['id']);
        $commiment->setName($data['name']);
        $commiment->setStatus($data['status']);
        $commiment->setDescription($data['description']);

        $commimentUpdated = $this->commimentDao->updateCommiment($commiment);

        if($commimentUpdated){
            $responseUpdate = [
                'status' => "Registro actualizado",
                'update_to' => $commimentUpdated
            ];

            http_response_code(200);
        }else{
            $responseUpdate = [
                'status' => "Error al actualizar registro",
            ];

            http_response_code(400);
        }

        header("Content-Type: application/json");
        echo json_encode($responseUpdate);
    }

    public function removeCommimentDelete()
    {
        $id = $_GET['id'];
        $commimentDeleted = $this->commimentDao->deleteCommimentyp($id);

        if($commimentDeleted){
            $responseDelete = [
                "status" => "Compromiso eliminado",
                'deleted_to' => $commimentDeleted
            ];

            http_response_code(200);
        }else{
            $responseDelete = [
                "status" => "Error al eliminar el compromiso",
            ];

            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseDelete);
    }

}