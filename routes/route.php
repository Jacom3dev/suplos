<?php

header("Access-Control-Allow-Origin: http://localhost:5173");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header("Access-Control-Allow-Credentials: true");
header("Content-Type: application/json; charset=utf-8");


require_once "controllers/ProccesEventControllers.php";
require_once "controllers/CurrencyController.php";
require_once "controllers/ActivityController.php";
require "helpers/notFoundError.php";
require "helpers/validateRequiredFields.php";


$route = explode("/", $_SERVER["REQUEST_URI"]);
$route = array_filter($route);


if (empty($route)) {
    notFoundError();
    return;
}
$method = $_SERVER["REQUEST_METHOD"];
if ($method == "OPTIONS") {
    http_response_code(200);
    return;
}
if (isset($method)) {

    /* proccess-event */
    /* GET: http://suplos.api.com/proccess-event */
    if ($method == "GET" && $route[1] == "proccess-event" && empty($route[2])) {
        $response = ProccessEventController::get();
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }

    /* GET: http://suplos.api.com/proccess-event/search?id=1 */
    if ($method == "GET" && $route[1] == "proccess-event" && isset($route[2]) && strpos($route[2], 'search') !== false) {

        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $object = isset($_GET['object']) ? $_GET['object'] : null;
        $status = isset($_GET['status']) ? $_GET['status'] : null;
        $client = isset($_GET['client']) ? $_GET['client'] : null;

        $response = ProccessEventController::search($id,$object,$client,$status);
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }

    /* POST: http://suplos.api.com/proccess-event */
    if ($method == "POST" && $route[1] == "proccess-event") {
        $body = json_decode(file_get_contents('php://input'), true);

        if(empty($body)){
            $response = [
                "status" => 400,
                "message" => "Error al decodificar el cuerpo de la solicitud JSON"
            ];
        }

        if ($body) {
            $requiredFields = ['object', 'description', 'currency_id','budget' ,'activity','start_date', 'start_time', 'end_date', 'end_time'];
            $validate = validateRequiredFields($requiredFields, $body);

            if ($validate) {
                $response = $validate;
            } else {
                $response = ProccessEventController::create($body);
            }
        } 

        echo json_encode($response,http_response_code(200));
        return;
    }

    /* PUT: http://suplos.api.com/proccess-event/{id} */
    if ( $method == "PUT" && $route[1] == "proccess-event" && isset($route[2])) {
        $response = ProccessEventController::changeState($route[2]);
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }


    /* Currency */
    /* GET: http://suplos.api.com/currency*/
    if ( $method == "GET" && $route[1] == "currency") {
        $response = CurrencyController::get();
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }

     /* Activity */
    /* GET: http://suplos.api.com/activity*/
    if ( $method == "GET" && $route[1] == "activity") {
        $response = ActivityController::get();
        echo json_encode($response, http_response_code($response["status"]));
        return;
    }
    
    notFoundError();
}
