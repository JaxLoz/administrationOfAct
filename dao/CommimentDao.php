<?php

namespace dao;

use model\commiment;
use PDO;
use util\DbConnection;

class CommimentDao
{

    private $con;

    public function __construct()
    {
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function getAllCommiment()
    {
        $commiment = null;
        $sql = "select * from commiment";
        $stm = $this->con->prepare($sql);

        if($stm->execute()){
            $commiment = $stm->fetchAll(PDO::FETCH_ASSOC);
            return $commiment;
        }

        return $commiment;
    }

    public function getCommitmentOfAct($idAct)
    {

        $actCommitments = null;

        try{
            $sql = "select a.id, c.name, c.status, c.description from commiment as c inner join act_commiment as ac on c.id = ac.id_commiment inner join act as a on ac.id_act = a.id where a.id = :idAct";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(":idAct", $idAct);
            $stm->execute();

            $actCommitments = $stm->fetchAll(PDO::FETCH_ASSOC);

            if (isset($actCommitments)){
                return $actCommitments;
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return $actCommitments;
    }

    public function getCommimentId($id)
    {
        $commiment = null;
        $sql = "select * from commiment where id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':id', $id);

        if($stm->execute()){
            $commiment = $stm->fetch(PDO::FETCH_ASSOC);
            return $commiment;
        }

        return $commiment;
    }

    public function insertCommiment(Commiment &$commiment)
    {
        $commimentInserted = null;
        $name = $commiment->getName();
        $status = $commiment->getStatus();
        $description = $commiment->getDescription();

        $sql = "insert into commiment (name, status, description) values (:name, :status, :description)";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':name', $name);
        $stm->bindParam(':status', $status);
        $stm->bindParam(':description', $description);
        $stm->execute();

        if($stm->rowCount() > 0){

            $lastIdInsert = $this->con->lastInsertId();
            $commimentInserted = $this->getCommimentId($lastIdInsert);
        }

        return $commimentInserted;
    }

    public function updateCommiment(Commiment $commiment)
    {
        $id = $commiment->getId();
        $name = $commiment->getName();
        $status = $commiment->getStatus();
        $description = $commiment->getDescription();
        $infoCommimetUpdate = null;

        $sql = "update commiment set name = :name, status = :status, description = :description where id = :id";
        $stm = $this->con->prepare($sql);
        $stm->bindParam(':name',$name);
        $stm->bindParam(':status',$status);
        $stm->bindParam(':description', $description);
        $stm->bindParam(':id', $id);
        $stm->execute();

        if($stm->rowCount() > 0){
            $infoCommimetUpdate = $this->getCommimentId($id);
            return $infoCommimetUpdate;
        }

        return $infoCommimetUpdate;
    }

    public function deleteCommimentyp($id)
    {

        $commimentDeleted = $this->getCommimentId($id);

        if(isset($commimentDeleted)){
            $sql = "DELETE FROM commiment WHERE id = ?";
            $stamente = $this->con->prepare($sql);
            $stamente->bindParam(1, $id);
            $stamente->execute();
        }

        return $commimentDeleted;
    }


}