<?php

namespace util;

use PDO;
use PDOException;

class DbConnection
{
    private PDO $pdo;
    private static ?DbConnection $dbConnection = null;

    private $host = "pgsql:host=ep-yellow-grass-a58n9hrr.us-east-2.aws.neon.fl0.io;port=5432;dbname=actReports;sslmode=require";

    public function __construct()
    {
        try {
            $this->pdo = new PDO("mysql:host=bisbz5bdtevegiq59lre-mysql.services.clever-cloud.com;port=3306;dbname=bisbz5bdtevegiq59lre", "uyeags95emzhznug", "aSh5riojFDJXDtWX8XHZ");
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