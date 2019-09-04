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
    include_once("../config/security.php");
    include_once("../models/UpdatePasswordLog.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try {
        if ( (isset($params->old_password) && isset($params->new_password) ) ) {
            $session = new Session();
            if ( $session->isSet("id") ) {
                //new mongo instance
                $mongo = new MongoDB();

                $result = $mongo->ReadOneQuery("scroKING", "Users", $session->get("id"), ["password"]);

                if($result->password == $params->old_password) {
                    $mongo->UpdateOneQuery("scroKING", "Users", $session->get("id"), (object) ["password" => $params->new_password]);

                    //save update log in db
                    $updatePasswordLog = new UpdatePasswordLog(getTimestamp(), getClientIp(), $session->get("id"), "OK");
                    $mongo->WriteOneQuery("scroKING", "UpdatePasswordLogs", $updatePasswordLog);

                    //response: 200  Success0
                    http_response_code(200);
                    echo json_encode(array("message" => "Password aggiornata con successo."));
                } else {
                    //save wrong update password log in db
                    $updatePasswordLog = new UpdatePasswordLog(getTimestamp(), getClientIp(), $session->get("id"), "Vecchia password errata.");
                    $mongo->WriteOneQuery("scroKING", "UpdatePasswordLogs", $updatePasswordLog);

                    //response: 403 Forbidden
                    http_response_code(403);
                    echo json_encode(array("message" => "Vecchia password errata."));
                }
            } else {
                //response: 401 Unauthorized
                http_response_code(401);
                echo json_encode(array("message" => "Utente non loggato."));
            }
        } else {
            //response: 401 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }



