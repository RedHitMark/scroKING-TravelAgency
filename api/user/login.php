<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include("../config/MongoDB.php");
    include("../models/LoginLog.php");
    include("../config/timestamp.php");
    include("../config/session.php");
    include("../config/client.php");

    //login params from http body
    $login = json_decode(file_get_contents("php://input"));

    try {
        if(  (isset($login->username) || isset($login->email) ) && isset($login->password) ) {
            //new mongo instance
            $mongo = new MongoDB();

            //object
            $results = $mongo->ReadQuery("scroKING", "user", [ 'username' => $login->username, 'password' => $login->password ]);

            if($results->getNumResults() == 1) {
                //if there ONLY ONE user matching
                $user = $results->getResults()['0'];

                //save login log in db
                $loginLog = new LoginLog(getTimestamp(), getClientIp(), $user->_id, "OK");
                $mongo->WriteQuery("scroKING", "LoginLogs", $loginLog);

                //init session
                sessionInit();

                //set session value
                sessionSet('id', 'LE SCOREGGE DI MARCO PUZZANO DI GORGONZOLA');
                sessionSet('username', $user->username);
                sessionSet('timestamp', getTimestamp());

                //response: 200 OK
                http_response_code(200);
                echo json_encode(array("message" => "Login effettuata correttamente."));
            } else {
                //response: 401 Unauthorized
                http_response_code(401);
                echo json_encode(array("message" => "Login errata."));
            }
        } else {
            //response: 400 Bed Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }
    } catch (MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Configurazione server errata."));
    }



?>
