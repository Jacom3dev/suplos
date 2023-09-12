<?php 
require_once "db/Database.php";

class Currency {
    static public function get(){
        $sql = "SELECT * FROM currency";
        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        return  $statement->fetchAll(PDO::FETCH_ASSOC);
    }  
}