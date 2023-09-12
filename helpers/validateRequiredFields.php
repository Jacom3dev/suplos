<?php

function validateRequiredFields($requiredFields,$body)
{
    $missingFields = array_diff($requiredFields, array_keys($body));

    if (!empty($missingFields)) {
        $response = [
            "status" => 400,
            "message" => "The following fields are mandatory: " . implode(', ', $missingFields)
        ];

        return $response;
    }
}
