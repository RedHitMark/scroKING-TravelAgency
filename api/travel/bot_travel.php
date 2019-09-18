<?php
    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    //include
    include_once("../config/MongoDB.php");
    include_once("../config/timestamp.php");
    include_once("../config/Session.php");
    include_once("../config/security.php");
    include_once("../models/UpdateEmailLog.php");

    //params from http body
    $params = json_decode(file_get_contents("php://input"));

    try{
        //@TODO gestione query per la scelata di un viaggio.
        
    }catch(Exception | MongoDB\Driver\Exception\Exception $e){}

?> 