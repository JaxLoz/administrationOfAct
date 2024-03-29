<?php

namespace util;

use PDO;
use PDOException;

class DbConnection
{
    private PDO $pdo;
    private static ?DbConnection $dbConnection = null;

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=localhost;dbname=minute_report", "root", "Cr@fteo12");
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e){
            die("Error al conectar la base de datos: ".$e);
        }
    }

    public static function getInstance()
    {
        if (!isset(self::$dbConnection)) {
            self::$dbConnection = new DbConnection();
        }
        return self::$dbConnection;
    }

    public function getConnection()
    {
        return $this->pdo;
    }

}