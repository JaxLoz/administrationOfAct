<?php

namespace dao;

use modelDao\CrudDao;
use PDO;
use PDOException;
use util\DbConnection;
use model\User;

require ".\util\DbConnection.php";
require_once "modelDao/CrudDao.php";
//require ".\model\User.php";

class UserDao extends CrudDao
{


    public function __construct()
    {
        parent::__construct("user");
    }

    public function getUserForRol($rol)
    {
        $infoUser = null;
        $sql = "select u.firstname, u.lastname, u.phone, r.rol_name from user as u inner join rol as r on u.id_rol = r.id where r.rol_name = :rol";
        $stm = $this->pdo->prepare($sql);
        $stm->bindParam(':rol', $rol);
        $stm->execute();
        $infoUser = $stm->fetchAll(PDO::FETCH_ASSOC);

        if(isset($infoUser)){
            return $infoUser;
        }

        return $infoUser;
    }
}