<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
    include("../config/MongoDB.php");
    include("../config/timestamp.php");

    $login = json_decode(file_get_contents("php://input"));



    try {
        $mongo = new MongoDB();


        $query = new MongoDB\Driver\Query( [ 'username' => $login->username, 'password' => $login->password   ] );

        $rows = $mongo->ReadQuery($query);

        $count = 0;
        foreach ($rows as $row) {
            $count++;
        }

        if($count == 1) {
            http_response_code(200);
            session_start();
            
            $_SESSION['username'] = $login->username;
            $_SESSION['datalogin'] = getTimestamp();
           
            
            
            echo json_encode(array("message" => "Login effettuata correttamente."));
            
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Login errata."));
        }

        
    } catch (MongoDB\Driver\Exception\Exception $e) {
        http_response_code(500);
        echo json_encode(array("message" => "Configurazione errata."));
    }

   

    ?>
