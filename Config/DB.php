<?php
class DB
{
    private static $conn = null;
    public function __construct()
    {

    }
    public static function getConnection()
    {  try {
            $dbname = "mvc_php";
            $hostname = "localhost";
            $user = "root";
            $password = '';
            if (is_null(self::$conn)) {
                self::$conn = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }
            return self::$conn;
    } catch (PDOException $e) {
        die("Connect database false: $e ");
    }

    }
    public function __destruct()
    {
        self::$conn=null;
    }
}
