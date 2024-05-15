<?php

namespace dao;

use modelDao\CrudDao;
use PDO;
use PDOException;

require_once "modelDao/CrudDao.php";

class MeetingDao extends CrudDao
{
    public function __construct(string $nameTale)
    {
        Parent::__construct($nameTale);
    }

    public function getMeetingsWhitOutActs(int $idUser)
    {
        $meetings = null;

        $sql = "select * from meeting where id not in (select m.id  from meeting_act as ma
                                             inner join meeting as m on ma.id_meeting = m.id
                                             inner join act as a on ma.id_act = a.id
                                             inner join user as u on a.id_user = u.id where u.id = :userId)";

        try {
            $stm = parent::getCon()->prepare($sql);
            $stm->bindValue(":userId", $idUser);
            $stm->execute();

            if($stm->rowCount() > 0){
                $meetings = $stm->fetchAll(PDO::FETCH_ASSOC);
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $meetings;
    }

}