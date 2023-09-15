<?php

class AccesoDB
{
    private static $instance = null;
    private $connection = null;

    private function __construct()
    {
    }
    public static function getInstance()
    {
        if (self::$instance === null) {
            self::$instance = new AccesoDB();
        }
        return self::$instance;
    }
    public function getConnection()
    {
        if ($this->connection === null) {
            $dsn  ='mysql:host=localhost;dbname=venta_mini';
            $username = "root";
            $password = "";

            try{
                $this -> connection = new PDO($dsn, $username,$password );
                $this -> connection-> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            }catch(PDOException $ex){
                throw $ex;
            }
        }
        return $this->connection;
    }
}
