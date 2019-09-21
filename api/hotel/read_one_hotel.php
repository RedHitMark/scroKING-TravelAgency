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

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        if ( isset($params->id) ) {
            //new mongo instance
            $mongo = new MongoDB();

            //read all hotels from db
            $result = $mongo->ReadOneQuery("scroKING", "Hotels", $params->id);

            //response: 200  Success
            http_response_code(200);
            echo json_encode($result);
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
