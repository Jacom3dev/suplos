<?php
require_once "models/Activity.php";

class ActivityController
{
    static public function get()
    {
        try {
            $activities = Activity::get();

            $response = [
                "status" => 200,
                "data" => $activities
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
