<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../config/Session.php");
    include_once("../config/security.php");
    include_once ("../models/LogoutLog.php");

    try {
        //start session
        $session = new Session();

        //new mongo instance
        $mongo = new MongoDB();

        //save logout log in db
        $logoutLog = new LogoutLog(getTimestamp(), getClientIp(), $session->get("id"), "OK");
        $mongo->WriteOneQuery("scroKING", "LogoutLogs", $logoutLog);


        //destroy session
        $session->destroy();

        // response: 200 Success
        http_response_code(200);
        echo json_encode(array("message"=>"Logout effettuato con successo."));
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
