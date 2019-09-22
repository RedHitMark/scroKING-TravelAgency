<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../models/Travel.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        if ( isset($params->id) ) {
            //new mongo instance
            $mongo = new MongoDB();

            //read all hotels from db
            $result = $mongo->ReadOneQuery("scroKING", "Travels", $params->id);

            if($result) {
                $veicles = array();
                foreach ($result->veicles as $veicle_id) {
                    $veicle = $mongo->ReadOneQuery("scroKING", "Veicles", $veicle_id);
                    array_push($veicles, $veicle);
                }

                $hotels = array();
                foreach ($result->hotels as $hotel_id) {
                    $hotel = $mongo->ReadOneQuery("scroKING", "Hotels", $hotel_id);
                    array_push($hotels, $hotel);
                }
                $result->veicles = $veicles;
                $result->hotels = $hotels;

                //response: 200  Success
                http_response_code(200);
                echo json_encode($result);
            } else {
                //response: 404 Not Found
                http_response_code(404);
                echo json_encode(array("message" => "Viaggio non trovato."));
            }
        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }

    }catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
