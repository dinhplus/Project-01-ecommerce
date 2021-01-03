<?php

// namespace Model;

class Model
{
    private static $conn = null;
    public function __construct()
    {
        return static::getConnection();
    }

    public static function getConnection($hostname = "localhost", $port = "3306",$dbname="project_01",  $user = "root",$password = "")
    {
        try {
            if (is_null(self::$conn)) {
                self::$conn = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname", $user, $password, array(
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
                    PDO::ATTR_CASE => PDO::CASE_NATURAL,
                    PDO::ATTR_ORACLE_NULLS => PDO::NULL_EMPTY_STRING,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ));
                // self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conn;
    } catch (PDOException $e) {
        die("Connect database false: $e ");
    }

    }
    // public function __destruct()
    // {
    //     self::$conn=null;
    // }
    // public static function testConnection(){

    // }
}
