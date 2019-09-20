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
    include_once("../config/timestamp.php");
    include_once("../models/LoginLog.php");

    try{
        $session = new Session();

        if(isset($_SESSION['id']) && isset($_SESSION['timestamp'])){

            $mongo = new MongoDB();

            $user_result = $mongo->ReadOneQuery("scroKING", "Users", $session->get("id"), ["name","surname","username","email","address","role"]);

            $booked_travels_result = $mongo->ReadQuery("scroKING", "BookedTravels", ["id_user" => $session->get("id")]);

            //var_dump($booked_travels_result);

            // response: 200 OK
            http_response_code(200);
            echo json_encode($user_result);
        }else{
            // response: 401 Unauthorized
            http_response_code(401);
            echo json_encode(array("message:" => "Non autorizzato"));
        }


    } catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }

