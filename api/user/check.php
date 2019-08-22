<?php
    include("../config/timestamp.php");
    include("../config/session.php");
    session_start();

    if(isset($_SESSION['id']) && isset($_SESSION['timestamp'])){
        http_response_code(200);
        echo json_encode(array("message"=>"sessione attiva", "utente" => $_SESSION['id'], 'data' =>  $_SESSION['timestamp']));
        sessionDestroyAferOneHour('timestamp', 5000);
       
    }else{
        http_response_code(400);
        echo json_encode(array("message"=>"sessione inattiva"));

    }

?>