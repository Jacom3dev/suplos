<?php 
require_once "db/Database.php";

class Activity {

    /* traigo toda la data de la tabla activity */
    static public function get(){
        $sql = "SELECT * FROM activity";
        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        return  $statement->fetchAll(PDO::FETCH_ASSOC);
    }  
}