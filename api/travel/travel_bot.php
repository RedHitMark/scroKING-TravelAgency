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
    include_once("../config/Mail.php");
    include_once("../config/timestamp.php");
    include_once("../config/security.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try {
        $mongo = new MongoDB();


        if (isset($params->type)) {

            $result_with_existent_type = $mongo->ReadQuery("scroKING", "Travels", ["type" => $params->type]);

            if ($result_with_existent_type >= 1) {


                //response: 200  Success
                http_response_code(200);
                echo json_encode($result_with_existent_type);

            } else {


                //response: 406 Not Acceptable
                http_response_code(406);
                echo json_encode(array("message" => "tipologia non presente"));


            }


        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }