<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../config/CurlPotente.php");
    include_once("../config/Session.php");
    include_once("../config/timestamp.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        $session = new Session();

        if(isset($_SESSION['id']) && isset($_SESSION['timestamp'])){
            //new curl instance
            $curl = new CurlPotente("/ricarica");

            $result = $curl->getJson();

            $http_response_code = $curl->getHttpStatusCode();

            // response: 200 success || 400 Bad Request
            http_response_code($http_response_code);
            echo json_encode($result);
        }else{
            // response: 401 Unauthorized
            http_response_code(401);
            echo json_encode(array("message:" => "Non autorizzato"));
        }


    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
