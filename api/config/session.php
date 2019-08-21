<?php 

function sessionInit(){
    session_start();
}

function sessionSet(string $key, string $value) {
    $_SESSION[$key] = $value;
}

function sessionGet(string $key) {
    return $_SESSION[$key];
}

function sessionDestroy(){
    
    session_destroy();

    echo json_encode(array("message" => "logout effettuata correttamente."));
    exit();
}

?>