<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../models/Hotel.php");
    include_once("../models/Address.php");
    include_once("../config/timestamp.php");
    include_once("../config/security.php");

    $new_hotel = json_decode(file_get_contents("php://input"));

    try{
        $mongo = new MongoDB();

        if ( isset($new_hotel->name) && isset($new_hotel->description) && isset($new_hotel->address) && isset($new_hotel->phone) && isset($new_hotel->email) && isset($new_hotel->free_rooms) ){

            $address = new Address($new_hotel->address->street, $new_hotel->address->city, $new_hotel->address->cap, $new_hotel->address->region, $new_hotel->address->state);

            $doc = new Hotel($mongo->getNewIdObject(), $new_hotel->name, $new_hotel->description, $address, $new_hotel->phone, $new_hotel->email, $new_hotel->free_rooms);

            $mongo->WriteOneQuery("scroKING", "Hotels", $doc);

            //response: 200  Success
            http_response_code(200);
            echo json_encode(array("message" => "Viggio inserito con successo"));

        } else {
            //response: 400 Bad Request
            http_response_code(400);
            echo json_encode(array("message" => "Parametri mancanti."));
        }

    }catch (Exception | MongoDB\Driver\Exception\Exception $e) {
        //response: 500 Internal Server Error
        http_response_code(500);
        echo json_encode(array("message" => "Errore lato server.", "verbose" => $e->getMessage()));
    }



