<?php 
require_once "db/Database.php";

class ProccessEvent {
    
    static public function get(){  
        $sql = "SELECT event.*, c.name AS client_name, c.document AS client_document, currency.currency, activity.name as activity
        FROM process_event AS event
        INNER JOIN currency ON event.currency_id = currency.id
        INNER JOIN client AS c ON event.client_id = c.id
        INNER JOIN activity ON event.activity_id = activity.id
        ORDER BY event.created_at DESC";

        $statement = Database::connect()->prepare($sql);
        $statement->execute();
        return  $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    
    static public function create($data){
        $statement = Database::connect()->prepare("INSERT INTO process_event(client_id, object, description, currency_id, budget, activity_id, start_date, start_time, end_date, end_time) VALUES (:client_id,:object, :description, :currency_id,:budget,:activity_id, :start_date, :start_time, :end_date, :end_time)");
        $clientId = isset($data["client_id"]) ? $data["client_id"] : 1;
        $statement->bindParam(":client_id",$clientId, PDO::PARAM_INT);
        $statement->bindParam(":object", $data["object"], PDO::PARAM_STR);
        $statement->bindParam(":description", $data["description"], PDO::PARAM_STR);
        $statement->bindParam(":currency_id", $data["currency_id"], PDO::PARAM_INT);
        $statement->bindParam(":budget", $data["budget"], PDO::PARAM_INT);
        $statement->bindParam(":activity_id", $data["activity"], PDO::PARAM_INT);
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

    static public function search($id = null, $object = null,$client = null, $status = null) {  
        $sql = "SELECT event.*, c.name AS client_name, c.document AS client_document, currency.currency,activity.name as activity
        FROM process_event AS event
        INNER JOIN currency ON event.currency_id = currency.id
        INNER JOIN client AS c ON event.client_id = c.id
        INNER JOIN activity ON event.activity_id = activity.id";
    
        $params = [];
        $conditions = [];

        if ($id !== null) {
            $conditions[] = "event.id LIKE :id";
            $params[':id'] = "%$id%";
        }

        if ($object !== null) {
            $objectCondition = "(object LIKE :object OR description LIKE :description)";
            $params[':object'] = "%$object%";
            $params[':description'] = "%$object%";
            $conditions[] = $objectCondition;
        }

        if ($client !== null) {
            $objectCondition = "(c.name LIKE :client_name OR c.document LIKE :client_document)";
            $params[':client_name'] = "%$client%";
            $params[':client_document'] = "%$client%";
            $conditions[] = $objectCondition;
        }

        if ($status !== null) {
            $conditions[] = "status LIKE :status";
            $params[':status'] = "%$status%";
        }

        if (empty($conditions)) {
            return [];
        }
    
        $sql .= " WHERE " . implode(" OR ", $conditions);
    
        $statement = Database::connect()->prepare($sql." ORDER BY created_at DESC");
        $statement->execute($params);
    
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }
    
    static public function changeState($id) {
        $statement = Database::connect()->prepare("UPDATE process_event SET status = 'PUBLISHED' WHERE id = :id");
        $statement->bindParam(":id", $id, PDO::PARAM_INT);
    
        if ($statement->execute()) {
            return true; 
        } else {
            return false; 
        }
    }
    
    
    
}