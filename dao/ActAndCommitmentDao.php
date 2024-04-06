<?php

namespace dao;

use model\ActAndCommiment;
use PDOException;
use util\DbConnection;

class ActAndCommitmentDao
{

    private $con;

    public function __construct()
    {
        $this->con = DbConnection::getInstance()->getConnection();
    }

    public function deleteActAndCommitment(ActAndCommiment &$actAndCommit):bool
    {
        $id_act = $actAndCommit->getIdAct();
        $id_commit = $actAndCommit->getIdCommiment();

        try {

            $sql = "DELETE FROM act_commiment WHERE id_act = :idAct and id_commiment = :idCommit";
            $stamente = $this->con->prepare($sql);
            $stamente->bindParam(":idAct", $id_act);
            $stamente->bindParam("idCommit", $id_commit);
            $stamente->execute();

            if($stamente->rowCount() > 0){
                return true;

            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return false;
    }

    public function insertActAndCommitIds(ActAndCommiment &$actAndCommit): bool
    {

        $infoInserted = false;
        $id_act = $actAndCommit->getIdAct();
        $id_commitment = $actAndCommit->getIdCommiment();

        try {
            $sql = "select * from act_commiment where id_act = :idAct and id_commiment = :idCommit";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':idAct', $id_act);
            $stm->bindParam(':idCommit', $id_commitment);
            $stm->execute();

            if ($stm->rowCount() === 0) {
                echo 'hola';
                $sql = "insert into act_commiment (id_act, id_commiment) values (:idAct, :idCommit)";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':idAct', $id_act);
                $stm->bindParam(':idCommit', $id_commitment);
                $stm->execute();

                if ($stm->rowCount() > 0) {
                    $infoInserted = true;
                }
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return $infoInserted;
    }

    public function updateActAndCommiment(ActAndCommiment &$newActAndCommiment, ActAndCommiment &$oldActAndCommiment)
    {
        $updateActCommit = false;
        $newIdAct = $newActAndCommiment->getIdAct();
        $newIdCommit = $newActAndCommiment->getIdCommiment();
        $oldIdAct = $oldActAndCommiment->getIdAct();
        $oldIdCommit = $oldActAndCommiment->getIdCommiment();

        try {
            $sql = "select * from act_commiment where id_act = :idAct and id_commiment = :idCommit";
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':idAct', $id_act);
            $stm->bindParam(':idCommit', $id_commitment);
            $stm->execute();

            if ($stm->rowCount() === 0) {

                $sql = "update act_commiment set id_act = :idAct, id_commiment = :idCommit where id_act = :widAct and id_commiment = :widCommit";
                $stm = $this->con->prepare($sql);
                $stm->bindParam(':idAct', $newIdAct);
                $stm->bindParam(':idCommit', $newIdCommit);
                $stm->bindParam(':widAct', $oldIdAct);
                $stm->bindParam('widCommit', $oldIdCommit);
                $stm->execute();

                if ($stm->rowCount() > 0) {
                    $updateActCommit = true;
                }
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return $updateActCommit;
    }

}