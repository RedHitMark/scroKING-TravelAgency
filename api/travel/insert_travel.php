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
    include_once("../models/Veicle.php");
    include_once("../models/Destination.php");
    include_once ("../config/Mail.php");
    include_once ("../config/timestamp.php");
    include_once ("../config/security.php");
    

    $new_travel = json_decode(file_get_contents("php://input"));

    try{
        $mongo = new MongoDB();

        if(isset($new_travel->type) && isset($new_travel->destination)&& isset($new_travel->startdata) && isset($new_travel->finishdata) && isset($new_travel->price) && isset($new_travel->viecles) && isset($new_travel->hotels)){
            $destination = new Destination(
                $new_travel->destination->city1, $new_travel->destination->city2
            );
            $doc = new Travel(
                $mongo->getNewIdObject(),
                $new_travel->tyoe, $destination, $new_travel->startdata,
                $new_travel->finshdata, $new_travel->price,
                $new_travel->veicles, $new_travel->hotels);
            
                $mongo->WriteOneQuery("scroKING", "Viaggi", $doc);   

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