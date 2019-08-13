<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    require_once "../models/User.php";

    $new_user = json_decode(file_get_contents("php://input"));

    try {
        $mng = new MongoDB\Driver\Manager( "mongodb://scroking.ddns.net:27017");

        if(isset($new_user->username) && isset($new_user->password)) {
            $bulk = new MongoDB\Driver\BulkWrite();
            
            //$doc = new User(new MongoDB\BSON\ObjectID(), "marco", "cacca", "pipi", "pupu", "ff", "fff");
            $doc = ['_id' => new MongoDB\BSON\ObjectID(), 'username' => $new_user->username, 'password' => hash('sha512', $new_user->password)];

            $bulk->insert($doc);
            $mng->executeBulkWrite('scroKING.user', $bulk);
            
            http_response_code(200);
            echo json_encode(array("message" => "Registrazione effettuata correttamente."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Registrazione impossibile."));
        }
        
    } catch (MongoDB\Driver\Exception\Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Configurazione errata."));
    }
?>