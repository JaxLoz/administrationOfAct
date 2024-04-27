<?php

namespace interfaceDAO;
interface InterfaceDao
{
    public function getAll();
    public function getById($id);
    public function updateRegister($dataJson):bool;
    public function insertRegister($dataJson):int;
    public function deleteRegister($id):bool;

}
