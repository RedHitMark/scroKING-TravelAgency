<?php
    include_once("../config/timestamp.php");
    include_once("../config/session.php");
    sessionInit();

    if( isset($_SESSION['id']) && isset($_SESSION['timestamp'])) {

        if (!sessionCheckAferOneHour()) {
            // response: 200 OK
            http_response_code(200);
            echo json_encode(array("message"=>"sessione attiva", "utente" => $_SESSION['id'], 'data' =>  $_SESSION['timestamp']));
        } else {
            sessionDestroy();

            // response: 408 Request timeout
            http_response_code(408);
            echo json_encode(array("message"=>"sessione scaduta"));
        }

    } else {
        // response: 401 Unauthorized
        http_response_code(401);
        echo json_encode(array("message"=>"sessione inattiva"));

    }

?>