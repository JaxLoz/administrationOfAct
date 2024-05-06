<?php

namespace dao;

use modelDao\CrudDao;

require_once "modelDao/CrudDao.php";

class CredentialDao extends CrudDao
{
    public function __construct(){
        parent::__construct("credentials");
    }

    public function getInfoUserByCredentials($data)
    {
        $userInformation = null;
        $sql = "SELECT u.id, 
                    u.firstname, 
                    u.lastname, 
                    u.phone, 
                    c.email, 
                    r.rol_name 
                    FROM user as u 
                    inner join credentials as c 
                    on u.id_credential = c.id 
                    inner join rol as r 
                    on u.id_rol = r.id WHERE c.email = :email";
        $stm = parent::getCon()->prepare($sql);
        $stm->bindValue(":email", $data);
        $stm->execute();

        if($stm->rowCount() > 0){
            $userInformation = $stm->fetch(\PDO::FETCH_ASSOC);
        }

        return $userInformation;
    }

}