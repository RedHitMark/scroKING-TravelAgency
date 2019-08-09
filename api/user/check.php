<?php
    session_start();

    if(isset($_SESSION['username'])){
        http_response_code(200);
        echo json_encode(array("message"=>"sessione attiva"));
    }else{
        http_response_code(400);
        echo json_encode(array("message"=>"sessione inattiva"));

    }

?>