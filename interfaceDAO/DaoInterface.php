<?php

namespace interfaceDAO;
interface DaoInterface
{
    public function getAll();
    public function getById($id);
    public function updateRegister($data, int $id):bool;
    public function insertRegister($data);
    public function deleteRegister($id):bool;
    public function existRegister(string $column, string $param):bool;
    public function getByParams(string $column, string $param);

}
