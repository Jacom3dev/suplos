<?php
require_once "controllers/ProccesEventControllers.php";
require_once "controllers/CurrencyController.php";
require "helpers/notFoundError.php";
require "helpers/validateRequiredFields.php";


$route = explode("/", $_SERVER["REQUEST_URI"]);
$route = array_filter($route);


if (empty($route)) {
    notFoundError();
    return;
}
$method = $_SERVER["REQUEST_METHOD"];

if (isset($method)) {

    /* proccess-event */
    if ($route[1] == "proccess-event" && empty($route[2]) && $method == "GET") {
        $response = ProccessEventController::get();
        header("Content-Type: application/json");
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }

    if ($route[1] == "proccess-event" && strpos($route[2], 'search') !== false && $method == "GET") {

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $object = isset($_GET['object']) ? $_GET['object'] : null;
        $status = isset($_GET['status']) ? $_GET['status'] : null;

        $response = ProccessEventController::search($id,$object,$status);
        header("Content-Type: application/json");
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }

    if ($route[1] == "proccess-event" && $method == "POST") {
        $body = json_decode(file_get_contents('php://input'), true);

        if(empty($body)){
            $response = [
                "status" => 400,
                "message" => "Error al decodificar el cuerpo de la solicitud JSON"
            ];
        }

        if ($body) {
            $requiredFields = ['object', 'description', 'currency_id', 'activity', 'start_date', 'start_time', 'end_date', 'end_time'];
            $validate = validateRequiredFields($requiredFields, $body);

            if ($validate) {
                $response = $validate;
            } else {
                $response = ProccessEventController::create($body);
            }
        } 

        header("Content-Type: application/json");
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }


    /* Currency */

    if ($route[1] == "currency" && $method == "GET") {
        $response = CurrencyController::get();
        header("Content-Type: application/json");
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }
    
    notFoundError();
}
