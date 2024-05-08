<?php

namespace dao;

use modelDao\CrudDao;
use PDOException;

require_once "modelDao/CrudDao.php";

class MeetingAndActDao extends CrudDao
{

    public function __construct(string $nameTable)
    {
        parent::__construct($nameTable);
    }

    public function deleteMeetingAndActByIds($idAct, $idMeeting): bool
    {
        $sql = "delete from meeting_act where id_act = :idAct and id_meeting = :idMeeting";

        try {
            $stm = parent::getCon()->prepare($sql);
            $stm->bindValue(":idAct", $idAct);
            $stm->bindValue("idMeeting", $idMeeting);
            $stm->execute();

            if($stm->rowCount() > 0){
                return true;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return false;
    }
}