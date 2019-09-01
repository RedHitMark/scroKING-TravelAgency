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

    //login params from http body
    $login = json_decode(file_get_contents("php://input"));

    try {
        if (  (isset($login->username) || isset($login->email) ) && isset($login->password) ) {
            //new mongo instance
            $mongo = new MongoDB();

            //object Result @TODO cambiare un po sta roba
            $results = $mongo->ReadQuery("scroKING", "Users", [ 'username' => $login->username]);

            if ($results->getNumResults() == 1) {
                //if there ONLY ONE username matching
                $id = $results->getResults()['0']->_id;

                $results = $mongo->ReadQuery("scroKING", "Users", [ '_id' => $id, 'password' => $login->password]);

                if ($results->getNumResults() == 1) {
                    //logim success
                    $user = $results->getResults()['0'];

                    //save login log in db
                    $loginLog = new LoginLog(getTimestamp(), getClientIp(), $id, "OK");
                    $mongo->WriteOneQuery("scroKING", "LoginLogs", $loginLog);

                    //init session
                    sessionInit();

                    //set session value
                    sessionSet('id', $mongo->getIdFromObj($user->_id) );
                    sessionSet('username', $user->username);
                    sessionSet('timestamp', getTimestamp());

                    //response: 200 OK
                    http_response_code(200);
                    echo json_encode(array("message" => "Login effettuata correttamente.", "username" => $user->username));
                } else {
                    //password errata
                    //save login log in db
                    $loginLog = new LoginLog(getTimestamp(), getClientIp(), $id, "Password errata");
                    $mongo->WriteOneQuery("scroKING", "LoginLogs", $loginLog);

                    //@TODO check is is bruteforcing
                    //$logs = $mongo->ReadQuery("scroKING", "LoginLogs", ['$userId' => $id])->getResults();

                    //response: 403 Forbidden
                    http_response_code(403);
                    echo json_encode(array("message" => "Password errata."));
                }
            } else {
                //response: 401 Unauthorized
                http_response_code(401);
                echo json_encode(array("message" => "Username errato."));
            }
        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Configurazione server errata."));
    }



?>
