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

        if (isset($params->type) && isset($params->destinations) && isset($params->startdata) && isset($params->finishdata) && isset($params->price) && isset($params->veicles) && isset($params->hotels) ){
            $mongo = new MongoDB();

            $doc = new Travel( $mongo->getNewIdObject(), $params->type,
            $params->destinations, $params->startdata,
            $params->finishdata, $params->price, $params->veicles, $params->hotels);

            $mongo->WriteOneQuery("scroKING", "Travels", $doc);

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

?>
