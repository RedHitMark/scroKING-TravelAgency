<?php
    include("../config/timestamp.php");
    include("../config/session.php");
    session_start();

    if(isset($_SESSION['username']) && isset($_SESSION['timestamp'])){
        http_response_code(200);
        echo json_encode(array("message"=>"sessione attiva", "utente" => $_SESSION['username'], 'data' =>  $_SESSION['datalogin']));
    }else{
        http_response_code(400);
        echo json_encode(array("message"=>"sessione inattiva"));

    }

    /*
    $differenza = getTimestamp() - $_SESSION['timetsamp'];

    if($differenza == $oneHour){


    }
    */
?>