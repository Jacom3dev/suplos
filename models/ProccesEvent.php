<?php 
require_once "db/Database.php";

class ProccessEvent {
    static public function get(){
        $sql = "SELECT * FROM process_event ORDER BY created_at DESC";
        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        return  $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    static public function create($data){
        $statement = Database::connect()->prepare("INSERT INTO process_event(object, description, currency_id, activity, start_date, start_time, end_date, end_time) VALUES (:object, :description, :currency_id, :activity, :start_date, :start_time, :end_date, :end_time)");
        
        $statement->bindParam(":object", $data["object"], PDO::PARAM_STR);
        $statement->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $statement->bindParam(":currency_id", $data["currency_id"], PDO::PARAM_INT);
        $statement->bindParam(":activity", $data["activity"], PDO::PARAM_STR);
        $statement->bindParam(":start_date", $data["start_date"], PDO::PARAM_STR);
        $statement->bindParam(":start_time", $data["start_time"], PDO::PARAM_STR);
        $statement->bindParam(":end_date", $data["end_date"], PDO::PARAM_STR);
        $statement->bindParam(":end_time", $data["end_time"], PDO::PARAM_STR);
        
        if ($statement->execute()) {
            return $data;
        } else {
            print_r(Database::connect()->errorInfo());
        }
    }

    static public function search($id = null, $object = null, $status = null) {
        $sql = "SELECT * FROM process_event";
    
        $params = [];
        $conditions = [];
    
        if ($id !== null) {
            $conditions[] = "id LIKE :id";
            $params[':id'] = "%$id%";
        }
    
        if ($object !== null) {
            $objectCondition = "(object LIKE :object OR description LIKE :description)";
            $params[':object'] = "%$object%";
            $params[':description'] = "%$object%";
            $conditions[] = $objectCondition;
        }
    
        if ($status !== null) {
            $conditions[] = "status LIKE :status";
            $params[':status'] = "%$status%";
        }
    
        if (!empty($conditions)) {
            $sql .= " WHERE " . implode(" OR ", $conditions);
        }
    
        $statement = Database::connect()->prepare($sql." ORDER BY created_at DESC");
        $statement->execute($params);
    
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    
    
    
}