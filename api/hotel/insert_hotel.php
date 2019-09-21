<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../models/Hotel.php");
    include_once("../models/Address.php");
    include_once("../config/timestamp.php");
    include_once("../config/security.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        $mongo = new MongoDB();

        if ( isset($params->name) && isset($params->description) && isset($params->address) && isset($params->phone) && isset($params->email) && isset($params->free_rooms) ){

            $address = new Address($params->address->street, $params->address->city, $params->address->cap, $params->address->region, $params->address->state );

            $doc = new Hotel($mongo->getNewIdObject(), $params->name, $params->description, $address, $params->phone, $params->email, $params->free_rooms);

            $mongo->WriteOneQuery("scroKING", "Hotels", $doc);

            //response: 200  Success
            http_response_code(200);
            echo json_encode(array("message" => "Viggio inserito con successo"));

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



