<?php
require_once "models/Currency.php";

class CurrencyController
{
    static public function get()
    {
        try {
            $currencies = Currency::get();

            $response = [
                "status" => 200,
                "data" => $currencies
            ];

            return $response;
        } catch (\Throwable $th) {
            $response = [
                "status" => $th->getCode(),
                "message" => $th->getMessage()
            ];

            return $response;
        }
    }
}
