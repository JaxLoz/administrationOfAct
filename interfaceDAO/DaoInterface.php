<?php

namespace interfaceDAO;
interface DaoInterface
{
    public function getAll();
    public function getById($id);
    public function updateRegister($data):bool;
    public function insertRegister($data):int;
    public function deleteRegister($id):bool;
    public function existRegister(string $column, string $param):bool;
    public function getByParams(string $column, string $param);

}
