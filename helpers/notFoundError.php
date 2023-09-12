<?php 

function notFoundError()  {
    $response = [
        "status" => 404,
        "message" => "Not found"
    ];

    header("Content-Type: application/json");
    echo json_encode($response, http_response_code(404));
}
