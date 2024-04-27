<?php

namespace modelDao;

use interfaceDAO\InterfaceDao;
use PDO;
use PDOException;
use util\DbConnection;
use util\UtilesTools;

require "interfaceDAO/InterfaceDao.php";

class CrudDao implements InterfaceDao
{

    private string $nameTable;
    private PDO $con;

    public function __construct($nameTable){
        $this->con = DbConnection::getInstance()->getConnection();
        $this->nameTable = $nameTable;
    }


    public function getNameTable(): string
    {
        return $this->nameTable;
    }

    public function getAll()
    {
        $data = null;
        $sql = "select * from $this->nameTable";
        try {
            $stm = $this->con->prepare($sql);

            if ($stm->execute()) {
                $data = $stm->fetchAll(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $data;

    }

    public function getById($id)
    {
        $data = null;
        $sql = "select * from $this->nameTable where id = :id";
        try{
            $stm = $this->con->prepare($sql);
            $stm->bindParam(':id', $id);

            if($stm->execute()){
                $data = $stm->fetch(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return $data;
    }

    public function updateRegister($dataJson): bool
    {
        $i = 1;
        $updateColumns = UtilesTools::buildString($dataJson, " = ?,");
        $sql = "update $this->nameTable set $updateColumns where id = ?";

        try {
            $stm = $this->con->prepare($sql);
            foreach ($dataJson as $value) {
                $stm->bindParam($i, $value);
                $i++;
            }
            $stm->execute();

            if($stm->rowCount() > 0){
                return true;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return  false;
    }

    public function insertRegister($dataJson): int
    {
        $i = 1;
        $columns = UtilesTools::buildStringSimple($dataJson, ", ");
        $parameters = UtilesTools::buildParaters(UtilesTools::getKeys($dataJson));

        $sql = "insert into $this->nameTable ($columns) values ($parameters)";
        try {
            $stm = $this->con->prepare($sql);
            foreach ($dataJson as $value){
                $stm->bindParam($i,$value);
                $i++;
            }
            $stm->execute();
            $idInserted = $this->con->lastInsertId();

            if($idInserted > 0){
                return $idInserted;
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return 0;
    }

    public function deleteRegister($id): bool
    {
        $sql = "DELETE FROM $this->nameTable WHERE id = ?";
        try {
            $stamente = $this->con->prepare($sql);
            $stamente->bindParam(1, $id);
            $stamente->execute();

            if($stamente->rowCount() > 0){
                return true;
            }

        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return false;
    }
}