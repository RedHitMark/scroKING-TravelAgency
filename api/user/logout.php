<?php
    session_start();
    session_destroy();

    echo json_encode(array("message" => "logout effettuata correttamente."));
 
    header("location:/index.htm");
    exit();
    ?>