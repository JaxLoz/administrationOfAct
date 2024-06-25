<?php

namespace dao;

use modelDao\CrudDao;

class InvitationDao extends CrudDao
{
    public function __construct()
    {
        parent::__construct("invitation");
    }
}