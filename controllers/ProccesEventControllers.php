<?php
require_once "models/ProccesEvent.php";

class ProccessEventController
{
    // Método  para obtener todos los registros de eventos/procesos
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

    // Método  para buscar eventos/procesos con filtros opcionales
    static public function search($id = null, $object = null, $client=null, $status = null)
    {
        try {
            $getProccessesEvents = ProccessEvent::search($id,$object,$client,$status);

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

    static public function changeState($id)
    {
        try {
           ProccessEvent::changeState($id);

            $response = [
                "status" => 200,
                "message" => "published"
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
