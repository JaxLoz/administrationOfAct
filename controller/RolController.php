<?php

namespace controller;
use \dao\RolDao;
use \model\Rol;

require '.\dao\RolDao.php';

class RolController
{

    private $rolDao;

    public function __construct()
    {
        $this->rolDao = new RolDao();
    }

    public function createRolPost()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $newRol = new Rol();
        $newRol->setName($data['rol_name']);

        $infoRolCreate = $this->rolDao->createRolPost($newRol);

        if(isset($infoRolCreate)){
            $responseRolCreate = [
                'status' => "Rol creado exitosamente",
                'response' => $infoRolCreate
            ];

            http_response_code(201);
        }else{
            $responseRolCreate = [
                'status' => "Fallo la creacion del rol",
                'response' => $infoRolCreate
            ];

            http_response_code(500);
        }

        header("Content-Type: application/json");
        echo json_encode($responseRolCreate);

    }

    public function getRolGet()
    {
        $infoRol = $this->rolDao->getRol();

        if($infoRol){
            $responseRol = [
                'status' => "Informacion obtenida",
                'rol' => $infoRol
            ];

            http_response_code(200);
        }else{
            $responseRol = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseRol);
    }

    public function getRolIdGet()
    {
        $id = $_GET["id"];
        $infoRol = $this->rolDao->getRolId($id);

        if($infoRol){
            $responseRol = [
              'status' => "Informacion obtenida",
              'rol' => $infoRol
            ];

            http_response_code(200);
        }else{
            $responseRol = ['status' => "No se pudo obtener la informacion",];
            http_response_code(404);
        }

        header("Content-Type: application/json");
        echo json_encode($responseRol);
    }

    public function updateRolPut()
    {
        $data = json_decode(file_get_contents("php://input"), true);
        $rol = new Rol();
        $rol->setId($data['id']);
        $rol->setName($data['rol_name']);

        $rolUpdated = $this->rolDao->updateRol($rol);

        if($rolUpdated){
            $responseUpdate = [
                'status' => "Registro actualizado",
                'update_to' => $rolUpdated
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

    public function removeRolDelete()
    {
        $id = $_GET['id'];
        $infoRolDeleted = $this->rolDao->deleteRol($id);

        if($infoRolDeleted){
            $responseDelete = [
                "status" => "Registro eliminado",
                'deleted_to' => $infoRolDeleted
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

}