<?php 

function sessionInit(){
    session_start();
}

function sessionSet($key, $value) {
    $_SESSION[$key] = $value;
}

function sessionGet($key) {
    return $_SESSION[$key];
}

function sessionDestroy(){
    
    session_destroy();

    echo json_encode(array("message" => "logout effettuata correttamente."));
    exit();
}

?>