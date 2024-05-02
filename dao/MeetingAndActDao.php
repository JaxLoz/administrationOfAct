<?php

namespace dao;

use modelDao\CrudDao;

require_once "modelDao/CrudDao.php";

class MeetingAndActDao extends CrudDao
{

    public function __construct(string $nameTable)
    {
        parent::__construct($nameTable);
    }
}