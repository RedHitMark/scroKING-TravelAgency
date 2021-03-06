<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try {
        //mongo instance
        $mongo = new MongoDB();

        //query result
        $result = $mongo->getServerInfo();

        //response: 200 OK
        http_response_code(200);
        echo json_encode($result['0']);
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
