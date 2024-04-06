<?php

namespace controller;

use dao\ActDao;
use model\Act;

require "dao/ActDao.php";
require "model/Act.php";

class ActController
{

    private $actDao;

    public function __construct()
    {
        $this->actDao = new ActDao();
    }

    public function getActsGet()
    {
        $infoActs = $this->actDao->getAllActs();

        if($infoActs){
            $responseActs = [
                'status' => "Informacion obtenida",
                'rol' => $infoActs
            ];

            http_response_code(200);
        }else{
            $responseActs = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseActs);
    }

    public function getActIdGet()
    {
        $id = $_GET["id"];
        $infoAct = $this->actDao->getActId($id);

        if($infoAct){
            $responseAct = [
                'status' => "Informacion obtenida",
                'Acta' => $infoAct
            ];

            http_response_code(200);
        }else{
            $responseAct = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseAct);
    }

    public function createActPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $newAct = new Act();
        $newAct->setProgress($data['progress']);
        $newAct->setIdUser($data['id_user']);

        $infoActCreate = $this->actDao->insertAct($newAct);

        if(isset($infoActCreate)){
            $responseActCreate = [
                'status' => "Acta generada correctamente",
                'response' => $infoActCreate
            ];

            http_response_code(201);
        }else{
            $responseActCreate = [
                'status' => "no se pudo generar el acta",
                'response' => $infoActCreate
            ];

            http_response_code(500);
        }

        header("Content-Type: application/json");
        echo json_encode($responseActCreate);
    }

    public function updateActPut()
    {

        $data = json_decode(file_get_contents("php://input"), true);
        $act = new Act();
        $act->setId($data['id']);
        $act->setProgress($data['progress']);
        $act->setIdUser($data['id_user']);

        $actUpdated = $this->actDao->updateAct($act);

        if($actUpdated){
            $responseUpdate = [
                'status' => "Registro actualizado",
                'update_to' => $actUpdated
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

    public function removeActDelete()
    {
        $id = $_GET['id'];
        $infoActDeleted = $this->actDao->deleteAct($id);

        if($infoActDeleted){
            $responseDelete = [
                "status" => "Registro eliminado",
                'deleted_to' => $infoActDeleted
            ];

            http_response_code(200);
        }else{
            $responseDelete = [
                "status" => "Error al eliminar el registro",
            ];

            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseDelete);
    }

    public function getActsOfUserGet()
    {
        $idUser = $_GET['id'];
        $infoActs = $this->actDao->getActOfUser($idUser);

        if($infoActs){
            $responseActs = [
                "status" => "Actas",
                'Actas_of_user' => $infoActs
            ];

            http_response_code(200);
        }else{
            $responseActs = [
                "status" => "Error al obtener las actas del usuario",
            ];

            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseActs);
    }

}