<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $login = json_decode(file_get_contents("php://input"));

    session_start();

    try {
        $mng = new MongoDB\Driver\Manager( "mongodb://scroking.ddns.net:27017");
        $query = new MongoDB\Driver\Query( [ 'username' => $login->username, 'password' => hash('sha512', $login->password) ] );

        $rows = $mng->executeQuery("scroKING.user", $query);

        $count = 0;
        foreach ($rows as $row) {
            $count++;
        }

        if($count == 1) {
            http_response_code(200);
            echo json_encode(array("message" => "Login effettuata correttamente."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Login errata."));
        }

        
    } catch (MongoDB\Driver\Exception\Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Configurazione errata."));
    }

    if(isset($login->username)){
        $_SESSION['username'] = $login->username;
        echo  $_SESSION['username'];
    }

    ?>
