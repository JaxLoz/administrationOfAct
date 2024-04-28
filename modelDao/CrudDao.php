<?php

namespace modelDao;

use interfaceDAO\DaoInterface;
use PDO;
use PDOException;
use util\DbConnection;
use util\UtilesTools;

require_once "interfaceDAO/DaoInterface.php";
require_once "util/UtilesTools.php";

class CrudDao implements DaoInterface
{

    private string $nameTable;
    private PDO $con;

    public function __construct($nameTable){
        $this->con = DbConnection::getInstance()->getConnection();
        $this->nameTable = $nameTable;
    }

    private function buildQuery(string $column, string $param)
    {
        $data = null;
        $sql = "select * from $this->nameTable where $column = :param";
        try{
            $stm = $this->con->prepare($sql);
            $stm->bindValue(":param", $param);
            $stm->execute();
            if($stm->rowCount() > 0){
                $data = $stm->fetch(PDO::FETCH_ASSOC);
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return $data;
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

    public function updateRegister($data): bool
    {
        $i = 1;
        $updateColumns = UtilesTools::buildString($data, " = ?,");
        $sql = "update $this->nameTable set $updateColumns where id = :id";

        try {
            $stm = $this->con->prepare($sql);
            foreach ($data as $value) {
                $stm->bindValue($i, $value);
                $i++;
            }
            $stm->bindParam(":id", $data["id"]);
            $stm->execute();

            if($stm->rowCount() > 0){
                return true;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }
        return  false;
    }

    public function insertRegister($data): int
    {
        $i = 1;
        $columns = UtilesTools::buildStringSimple($data, ", ");
        $parameters = UtilesTools::buildParaters(count(UtilesTools::getKeys($data)));

        $sql = "insert into $this->nameTable ($columns) values ($parameters)";
        try {
            $stm = $this->con->prepare($sql);
            foreach ($data as $value){
                $stm->bindValue($i,$value, PDO::PARAM_STR);
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

    public function existRegister(string $column, string $param): bool
    {
        try{
            if($this->buildQuery($column, $param) !== null){
               return true;
            }
        }catch (PDOException $e){
            echo $e->getMessage();
        }

        return false;
    }

    public function getByParams(string $column, string $param)
    {
        return $this->buildQuery($column, $param);
    }
}