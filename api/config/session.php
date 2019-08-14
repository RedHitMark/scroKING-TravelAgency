<?php 

function sessionInit(){
    session_start();
}

function sessionDestroy(){
    
    session_destroy();

    echo json_encode(array("message" => "logout effettuata correttamente."));
    exit();
}

?>