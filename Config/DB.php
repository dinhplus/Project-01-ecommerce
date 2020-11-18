<?php
class DB
{
    private static $conn = null;
    public function __construct()
    {
        // return static::getConnection();
    }
    public static function getConnection($hostname = "localhost", $port = "3306",$dbname="project_01",  $user = "root",$password = "")
    {  try {
            if (is_null(self::$conn)) {
                self::$conn = new PDO("mysql:host=$hostname;port=$port;dbname=$dbname", $user, $password);
                self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                // self::$conn->setFetchMode(PDO::FETCH_ASSOC);
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
