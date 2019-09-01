<?php

//headers
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

//include
include_once("../config/MongoDB.php");
include_once("../models/LoginLog.php");
include_once("../config/timestamp.php");
include_once("../config/session.php");
include_once("../config/client.php");
include_once("../config/security.php");

//pass params from http body
$params = json_decode(file_get_contents("php://input"));

try {
    if ( (isset($params->old_password) && isset($login->new_password) && isSessionSet()) ) {
        //new mongo instance
        $mongo = new MongoDB();

        $result = $mongo->ReadOneQuery("scroKING", "Users", sessionGet("id"), ["password"]);

        if($result->password == $params->old_password) {
            $mongo->UpdateOneQuery("scroKING", "Users", sessionGet("id"), (object) ["password" => $login->new_password]);
        }
    } else {
        //response: 400 Bed Request
        http_response_code(400);
        echo json_encode(array("message" => "Parametri mancanti."));
    }
} catch (Exception $e) {
    //response: 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("message" => "Configurazione server errata."));
} catch (\MongoDB\Driver\Exception\Exception $e) {
    //response: 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("message" => "Configurazione server errata."));
}



