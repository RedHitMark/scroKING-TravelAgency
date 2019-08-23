<?php 

include_once('../config/timestamp.php');

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
    // response: 401 Unauthorized
    http_response_code(401);
    exit();
}

function sessionCheckAferOneHour(){

        if(isset( $_SESSION['timestamp'])){
            if((getTimestamp() - $_SESSION['timestamp']) > 5000){
                return true;
            }else{
               return false;
           }

        }
        
        

}

?>