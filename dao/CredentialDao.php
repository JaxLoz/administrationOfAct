<?php

namespace dao;

use modelDao\CrudDao;

require_once "modelDao/CrudDao.php";

class CredentialDao extends CrudDao
{
    public function __construct(){
        parent::__construct("credentials");
    }

}