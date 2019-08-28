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

try{
    sessionInit();

    if(isset($_SESSION['id']) && isset($_SESSION['timestamp'])){

        $query = new MongoDB();
        
        $result = $query->ReadOneQuery("scroKING", "Users",sessionGet('id'),["name","surname","username","email"]);

        // response: 200 OK
        http_response_code(200);
        echo json_encode($result);

    }else{
        // response: 401 Unauthorized
        http_response_code(401);
        echo json_decode(array('message:'=> 'Non autorizzato'));
    }
        

}catch (MongoDB\Driver\Exception\Exception $e) {
    //response: 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("message" => "Configurazione server errata."));
}





?>