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
}