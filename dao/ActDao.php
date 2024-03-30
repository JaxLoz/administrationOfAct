<?php

namespace dao;

use model\Act;
use util\DbConnection;
use PDO;

class ActDao
{

    private $con;

    public function __construct()
    {
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function getAllActs()
    {
        $acts = null;
        $sql = "select * from act";
        $stm = $this->con->prepare($sql);

        if($stm->execute()){
            $acts = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $acts;
        }

        return $acts;
    }
    
    public function getActId($id)
    {
        $act = null;
        $sql = "select * from act where id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':id', $id);

        if($stm->execute()){
            $act = $stm->fetch(PDO::FETCH_ASSOC);
            return $act;
        }

        return $act;
    }

    public function insertAct(Act &$act)
    {
        $actInserted = null;
        $progress = $act->getProgress();
        $idUser = $act->getIdUser();

        $sql = "insert into act (progress, id_user) values (:progress, :user)";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':progress', $progress);
        $stm->bindParam(':user', $idUser);
        $stm->execute();


        if($stm->rowCount() > 0){

            $lastIdInsert = $this->con->lastInsertId();
            $actInserted = $this->getActId($lastIdInsert);
        }

        return $actInserted;
    }

    public function updateAct(Act &$act)
    {
        $id = $act->getId();
        $progress = $act->getProgress();
        $user = $act->getIdUser();
        $infoActUpdate = null;

        $sql = "update act set progress = :progress, id_user = :user where id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':progress',$progress);
        $stm->bindParam(':user',$user);
        $stm->bindParam(':id', $id);
        $stm->execute();

        if($stm->rowCount() > 0){
            $infoActUpdate = $this->getActId($id);
            return $infoActUpdate;
        }

        return $infoActUpdate;
    }

    public function deleteAct($id)
    {
        $actDeleted = $this->getActId($id);

        if(isset($actDeleted)){
            $sql = "DELETE FROM act WHERE id = ?";
            $stamente = $this->con->prepare($sql);
            $stamente->bindParam(1, $id);
            $stamente->execute();
        }

        return $actDeleted;
    }

    public function getActOfUser($idUser)
    {
        $infoActs = null;

        $sql = "select u.firstname, u.lastname, r.rol_name  a.id, a.progress from act as a inner join user as u on a.id_user = u.id inner join rol as r on u.id_rol = r.id where u.id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':id', $idUser);
        $stm->execute();
        $infoActs = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(isset($infoActs)){
            return $infoActs;
        }

        return $infoActs;
    }

}