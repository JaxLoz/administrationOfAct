<?php

namespace dao;

use modelDao\CrudDao;

require_once "modelDao/CrudDao.php";

class MeetingDao extends CrudDao
{
    public function __construct(string $nameTale)
    {
        Parent::__construct($nameTale);
    }

}