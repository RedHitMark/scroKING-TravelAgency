<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../config/client.php");
    include_once("../models/User.php");
    include_once("../models/RegistrationLog.php");

    $new_user = json_decode(file_get_contents("php://input"));

    try {
        $mongo = new MongoDB();

        //@TODO controllare se non esiste gia un tizio registrato con stesso username ed email
        if(isset($new_user->username) && isset($new_user->password) && isset($new_user->name) && isset($new_user->surname) && isset($new_user->email)) {

            $doc = new User( $mongo->getNewIdObject(),$new_user->name ,$new_user->surname,$new_user->email, $new_user->username , $new_user->password);

            $mongo->WriteOneQuery("scroKING", "Users", $doc);

            //save registration log in db
            $registrationLog = new RegistrationLog(getTimestamp(), getClientIp(), $new_user->username, $new_user->email, "OK");
            $mongo->WriteOneQuery("scroKING", "LoginLogs", $registrationLog);

            http_response_code(200);
            echo json_encode(array("message" => "Registrazione effettuata correttamente."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Registrazione impossibile."));
        }
        
    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => $e->getMessage()));
    }
?>
