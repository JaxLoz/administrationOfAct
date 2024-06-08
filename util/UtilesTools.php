<?php

namespace util;

use DateTime;
use DateTimeZone;
use Exception;
use PDO;
use PDOException;

class UtilesTools
{

    public static function getKeys($array): array
    {
        return $keys = array_keys($array);
    }

    public static function buildStringSimple($array, string $split): string
    {
        return implode($split, self::getKeys($array));
    }
    
    public static function buildString($array, string $addString)
    {
        $keys = array_keys($array);
        $newString = "";
        foreach ($keys as $key) {
            $newString .= $key . $addString;
        }

        return substr($newString, 0, -1);
    }

    public static function buildParaters($iter): string
    {

        $parameters = "?";

        for ($i=0; $i < $iter-1; $i++){
            $parameters = $parameters . ", ?";
        }

        return $parameters;
    }

    public function buildQuery(string $column, string $param, string $nameTable)
    {
        $data = null;
        $sql = "select * from $nameTable where $column = :param";
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

    public static function getCurrentDate(string $location): string
    {
        $currentDate = new DateTime();
        try {
            $currentDate = new DateTime('now', new DateTimeZone($location));
        }catch (Exception $e){
            echo "error in obtaining the current date";
        }
        return $currentDate->format("Y-m-d H:i:s");
    }

}