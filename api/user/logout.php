<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/session.php");

    try {
        //start session
        sessionInit();

        //new mongo instance
        $mongo = new MongoDB();

        //save logout log in db
        $logoutLog = new LoginLog(getTimestamp(), getClientIp(), sessionGet("id"), "OK");
        $mongo->WriteOneQuery("scroKING", "LogoutLogs", $logoutLog);


        //destroy session
        sessionDestroy();

        // response: 200 Success
        http_response_code(200);
        echo json_encode(array("message"=>"Logout effettuato con successo."));
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        // response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message"=>"Errore lato server."));
    }

?>
