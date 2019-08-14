<?php
    session_start();

    if(isset($_SESSION['username']) && isset($_SESSION['datalogin'])){
        http_response_code(200);
        echo json_encode(array("message"=>"sessione attiva", "utente" => $_SESSION['username'], 'data' =>  $_SESSION['datalogin']));
    }else{
        http_response_code(400);
        echo json_encode(array("message"=>"sessione inattiva"));

    }

?>