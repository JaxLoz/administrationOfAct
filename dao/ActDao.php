<?php

namespace dao;

use model\Act;
use modelDao\CrudDao;
use PDOException;
use util\DbConnection;
use PDO;

require_once "modelDao/CrudDao.php";

class ActDao extends CrudDao
{

    public function __construct()
    {
        parent::__construct("act");
    }

    public function getActOfUser($idUser)
    {
        $infoActs = null;

        $sql = "select u.firstname, u.lastname, r.rol_name,  a.id, a.progress from act as a inner join user as u on a.id_user = u.id inner join rol as r on u.id_rol = r.id where u.id = :id";
        $stm = parent::getCon()->prepare($sql);
        $stm->bindParam(':id', $idUser);
        $stm->execute();

        if($stm->rowCount() > 0){
            $infoActs = $stm->fetchAll(PDO::FETCH_ASSOC);
        }
        return $infoActs;
    }

    public function getAllInfActOfUser($idUser): array
    {
        $ActsOfUser = [];

        $sql = "select a.id as id_act , m.id as id_meeting,  m.title, m.place, m.star_date, m.star_time, u.firstname, u.lastname,a.progress from meeting_act as ma
                inner join meeting as m on ma.id_meeting = m.id
                inner join act as a on ma.id_act = a.id
                inner join user as u on a.id_user = u.id
                where u.id = :id order by m.star_time DESC, m.star_date DESC;";

        $stm = parent::getCon()->prepare($sql);
        $stm->bindValue(":id", $idUser);
        $stm->execute();

        if($stm->rowCount() > 0){
            $ActsOfUser = $stm->fetchAll(PDO::FETCH_ASSOC);
        }

        return $ActsOfUser;
    }
}