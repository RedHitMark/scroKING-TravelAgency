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
    include_once("../config/client.php");
    include_once("../config/security.php");
    include_once("../models/LoginLog.php");

    //login params from http body
    $params = json_decode(file_get_contents("php://input"));

    try {
        if (  (isset($params->username) || isset($params->email) ) && isset($params->password) ) {
            //new mongo instance
            $mongo = new MongoDB();

            //object Result @TODO cambiare un po sta roba
            $results = $mongo->ReadQuery("scroKING", "Users", [ 'username' => $params->username]);

            if ($results->getNumResults() == 1) {
                //if there ONLY ONE username matching
                $id = $mongo->getIdFromObj($results->getResults()['0']->_id);

                $results = $mongo->ReadQuery("scroKING", "Users", ['_id' => $mongo->getIdObjectFromExistent($id), 'password' => $params->password] );

                if ($results->getNumResults() == 1) {
                    //login success
                    $user = $results->getResults()['0'];

                    //save login log in db
                    $loginLog = new LoginLog(getTimestamp(), getClientIp(), $id, "OK");
                    $mongo->WriteOneQuery("scroKING", "LoginLogs", $loginLog);

                    //init session
                    $session = new Session();

                    //set session value
                    $session->set('id', $mongo->getIdFromObj($user->_id) );
                    $session->set('username', $user->username);
                    $session->set('timestamp', getTimestamp());

                    //response: 200 OK
                    http_response_code(200);
                    echo json_encode(array("message" => "Login effettuata correttamente.", "username" => $user->username));
                } else {
                    //password errata

                    //save login log in db
                    $loginLog = new LoginLog(getTimestamp(), getClientIp(), $id, "Password errata");
                    $mongo->WriteOneQuery("scroKING", "LoginLogs", $loginLog);

                    //query monogodb for last 5 login attempts
                    $logs = $mongo->ReadQuery("scroKING", "LoginLogs", ['userId' => $id], null, 5, "timestamp", MongoDB::DESCENTENT_SORT)->getResults();

                    if (is_bruteforceing($logs)) {
                        //@TODO bloccare l'utente per 10 min

                        //response: 429 Too Many Requests
                        http_response_code(429);
                        echo json_encode(array("message" => "Smettila di fare bruteforce della password."));
                    } else {
                        //response: 439 Forbidden
                        http_response_code(403);
                        echo json_encode(array("message" => "Password errata."));
                    }
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
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }

