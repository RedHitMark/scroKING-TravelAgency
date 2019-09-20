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

    try{
        $session = new Session();

        if(isset($_SESSION['id']) && isset($_SESSION['timestamp'])){
            //new mongo instance
            $mongo = new MongoDB();

            //retrive info of user from db
            $user_result = $mongo->ReadOneQuery("scroKING", "Users", $session->get("id"), ["name","surname","username","email","address","role"]);

            //retrive info of booked of user from db
            $booked_results = $mongo->ReadQuery("scroKING", "BookedTravels", ["id_user" => $session->get("id")]);

            //empty array of booked travels
            $booked_travels = array();

            //retrive alla information about travels
            foreach ($booked_results as $booked_result) {
                array_push($booked_travels, $mongo->ReadOneQuery("scroKING", "Travels", $booked_result->id_travel));
            }

            //empty array of transactions
            $transactions = array();
            //@TODO get all transaction from blockchain

            //merge all response in same json
            $user_result = (object) array_merge( (array) $user_result, array("booked_travels" => $booked_travels));
            $user_result = (object) array_merge( (array) $user_result, array("transactions" => $transactions));

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

