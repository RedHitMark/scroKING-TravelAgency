<?php
    //header("Access-Control-Allow-Origin: *");
    //header("Content-Type: application/json; charset=UTF-8");

    //headers
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

    $login = json_decode(file_get_contents("php://input"));



    if($login->username == "giovanni" && $login->password == "giovanniBravo") {
        http_response_code(200);
        echo json_encode(array("message" => "Login effettuata correttamente."));
    } else {
        http_response_code(400);
        echo json_encode(array("message" => "Login errata."));
    }
?>