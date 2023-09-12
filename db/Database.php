<?php 

class Database {

    static public function connect(){
        $serverName = "localhost";
        $dbName = "suplos";
        $userName = "root";
        $password = "";
        $connection = new PDO("mysql:host=$serverName;dbname=$dbName",$userName,$password);
        $connection->exec("set names utf8");
        return $connection;
    }
}

?>