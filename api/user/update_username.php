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
    include_once("../config/Mail.php");
    include_once("../config/timestamp.php");
    include_once("../config/security.php");
    include_once("../models/UpdateUsernameLog.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        if( isset($params->newUsername)){
            $session = new Session();
            if ($session->isSet("username") && $session->isSet("id") ){
                //new mongo instance
                $mongo = new MongoDB();

                //read username and email from db
                $result = $mongo->ReadOneQuery("scroKING", "Users", $session->get("id"), ["username", "email"]);

                //update
                $mongo->UpdateOneQuery("scroKING", "Users", $session->get("id"), (object) ["username" => $params->newUsername]);

                //save update log in db
                $updateUsernameLog = new UpdateUsernameLog(getTimestamp(), getClientIp(), $session->get("id"), $result->username, $params->newUsername);
                $mongo->WriteOneQuery("scroKING", "UpdateUsernameLogs", $updateUsernameLog);

                //send mail of confirm
                $mail = new Mail();
                $mail ->sendEmail($result->email, "Username modificato", "Complimenti, il tuo username è stato aggiornato. <br> Il tuo nuovo username è $params->newUsername. <br> Se noti attività sospette sul tuo account rispondi a questa mail per ottenere assistenza.");

                //response: 200  Success
                http_response_code(200);
                echo json_encode(array("message" => "Username aggiornato con successo."));
            } else {
                //response: 401 Unauthorized
                http_response_code(401);
                echo json_encode(array("message" => "Utente non loggato."));
            }

        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }

    } catch (Exception | MongoDB\Driver\Exception\Exception $e){
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }
