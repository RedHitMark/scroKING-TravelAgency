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
include ("../models/User.php");
include("../config/timestamp.php");
include("../config/session.php");
include("../config/client.php");

//login params from http body
$post_value = json_decode(file_get_contents("php://input"));

try {
    //new mongo instance
    $mongo = new MongoDB();

    /*
    //read
    $result = $mongo->ReadQuery("scroKING", "Users");
    echo json_encode($result);
    */

    /*
    //write
    $user = new User($mongo->getIdObjectFromExistent("123"), "cacca", "pipi", "pupu@gmail.com", "cacca", "fff");
    $result = $mongo->WriteOneQuery("scroKING", "Users", $user);
    echo json_encode($result);
    */

    /*
    //delete
    $result = $mongo->DeleteOneQuery("scroKING", "Users","123");
    echo json_encode($result);
    */

    /*
    //update @TODO
    $result = $mongo->UpdateOneQuery("scroKING", "Users");
    echo json_encode($result);
    */
} catch (MongoDB\Driver\Exception\Exception $e) {
    //response: 500 Internal Server Error
    http_response_code(500);
    echo json_encode(array("message" =>  $e->getMessage()));
}



?>
