<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../config/timestamp.php");
    include_once("../config/Session.php");
    include_once("../models/UpdatePasswordLog.php");

    //login params from http body
    $params = json_decode(file_get_contents("php://input"));

    try {
        //init session
        $session = new Session();

        if ($session->isSet("username") && $session->isSet("id")) {
            //mongo instance
            $mongo = new MongoDB();

            //query result
            $result = $mongo->ReadQuery("scroKING", "UpdatePasswordLogs", ["userId" => $session->get("id")], ["timestamp", "result", "ip"], null, "timestamp", MongoDB::DESCENTENT_SORT);


            //add location to result
            foreach ($result as &$log) {
                if ($log->ip != "::1") {
                    $location_details = getLocationFromIp($log->ip);
                    $log = (object)array_merge(array_merge((array)$log, array('location' => $location_details)));
                } else {
                    $log = (object)array_merge(array_merge((array)$log, array('location' => 'localhost')));
                }
            }

            //response: 200 OK
            http_response_code(200);
            echo json_encode($result);
        } else {
            //response: 401 Unauthorized
            http_response_code(401);
            echo json_encode(array("message" => "Utente non loggato."));
        }
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
