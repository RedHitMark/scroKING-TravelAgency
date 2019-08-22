<?php 

//require('../config/timestamp.php');
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

function sessionDestroyAferOneHour(string $key){

    if(isset($_SESSION[$key])){
        if((getTimestamp()-$_SESSION[$key]) > $oneHour){
            sessionDestroy();
            echo json_encode(array("message" => "logout effettuata mancanza tempo ."));

        }
    }


}

?>