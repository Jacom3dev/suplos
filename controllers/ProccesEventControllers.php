<?php
require_once "models/ProccesEvent.php";

class ProccessEventController
{
    static public function get()
    {
        try {
            $getProccessesEvents = ProccessEvent::get();

            $response = [
                "status" => 200,
                "data" => $getProccessesEvents
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

    static public function search($id = null, $object = null, $status = null)
    {
        try {
            $getProccessesEvents = ProccessEvent::search($id,$object,$status);

            $response = [
                "status" => 200,
                "data" => $getProccessesEvents
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

    static public function create($data)
    {
        try {
            $create = ProccessEvent::create($data);

            $response = [
                "status" => 201,
                "data" => $create
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
