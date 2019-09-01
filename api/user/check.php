<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/Session.php");
    include_once("../config/timestamp.php");

    try {
        //init session
        $session = new Session();

        if( $session->isset("id") &&  $session->isset("timestamp") ) {
            if (!$session->checkAfterOneHour()) {
                // response: 200 OK
                http_response_code(200);
                echo json_encode( array("message"=>"sessione attiva", "id" => $session->get("id"), "username" => $session->get("username"), "data" =>  $session->get('timestamp') ));
            } else {
                $session->destroy();

                // response: 408 Request timeout
                http_response_code(408);
                echo json_encode(array("message"=>"sessione scaduta"));
            }
        } else {
            // response: 401 Unauthorized
            http_response_code(401);
            echo json_encode(array("message"=>"sessione inattiva"));
        }
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        // response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message"=>"Errore lato server"));
    }

