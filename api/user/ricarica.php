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

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        $session = new Session();

        if(isset($_SESSION['id']) && isset($_SESSION['timestamp'])){
            $url = "http://vox3715217.mynet.vodafone.it:34518/ricarica?user_id=" . rawurlencode($session->get('id')) . "&money=" . rawurlencode($params->money) . "&description=" . rawurlencode($params->description);

            $curl = curl_init();

            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER,true);
            curl_setopt($curl, CURLOPT_HEADER, false);

            $result = curl_exec($curl);
            $http_status_code = curl_getinfo($curl,  CURLINFO_HTTP_CODE);

            //close connection
            curl_close($curl);

            // response: 200 success || 400 Bad Request
            http_response_code($http_status_code);
            echo json_encode($result);
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
