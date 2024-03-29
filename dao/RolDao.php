<?php

namespace dao;

use model\Rol;
use PDO;
use util\DbConnection;


require '.\model\Rol.php';

class RolDao
{

    private $con;

    public function __construct()
    {
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function createRolPost(Rol &$rol): bool
    {
        $infoRolCreate = false;
        $rolName = $rol->getName();


        $sql = "insert into rol (rol_name) values (:rolName)";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':rolName', $rolName);
        $stm->execute();

        if($stm->rowCount() > 0){
            $infoRolCreate = true;
        }

        return $infoRolCreate;
    }

    public function getRolId($id)
    {

        $rol = null;
        $sql = "select * from rol where id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':id', $id);

        if($stm->execute()){
            $rol = $stm->fetch(PDO::FETCH_ASSOC);
            return $rol;
        }

        return $rol;
    }

    public function getRol()
    {
        $rol = null;
        $sql = "select * from rol";
        $stm = $this->con->prepare($sql);

        if($stm->execute()){
            $rol = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $rol;
        }

        return $rol;
    }

    public function updateRol(Rol &$rol)
    {
        $rolId = $rol->getId();
        $rolName = $rol->getName();
        $infoRolUpdate = null;

        $sql = "update rol set rol_name = :rol where id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':rol',$rolName);
        $stm->bindParam(':id', $rolId);
        $stm->execute();

        if($stm->rowCount() > 0){
            $idUpdate = $this->con->lastInsertId();
            $infoRolUpdate = $this->getRolId($rolId);
            return $infoRolUpdate;
        }

        return $infoRolUpdate;


    }

    public function deleteRol($id)
    {
        $rolDeleted = $this->getRolId($id);

        if(isset($rolDeleted)){
            $sql = "DELETE FROM rol WHERE id = ?";
            $stamente = $this->con->prepare($sql);
            $stamente->bindParam(1, $id);
            $stamente->execute();
        }

        return $rolDeleted;
    }

}