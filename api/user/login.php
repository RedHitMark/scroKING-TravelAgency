<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include("../config/MongoDB.php");
    include("../config/timestamp.php");
    include("../config/session.php");

    //query params
    $login = json_decode(file_get_contents("php://input"));

    try {
        //new mongo instance
        $mongo = new MongoDB();


        $query = new MongoDB\Driver\Query( [ 'username' => $login->username, 'password' => $login->password   ] );

        $rows = $mongo->ReadQuery($query);

        //@TODO migliorare questa roba al più presto possibile
        $count = 0;
        foreach ($rows as $row) {
            $count++;
        }


        if($count == 1) {
            //if there ONLY ONE user matching
            sessionInit();
            
            $_SESSION['id'] = 'LE SCOREGGE DI MARCO PUZZANO DI GORGONZOLA';
            $_SESSION['username'] = $login->username;
            $_SESSION['timestamp'] = getTimestamp();


            http_response_code(200);
            echo json_encode(array("message" => "Login effettuata correttamente."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "Login errata."));
        }

        
    } catch (MongoDB\Driver\Exception\Exception $e) {
        //internal server error
        http_response_code(500);
        echo json_encode(array("message" => "Configurazione errata."));
    }

   

    ?>
