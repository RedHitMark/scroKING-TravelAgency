<?php 
//include
include_once('../config/timestamp.php');

class Session {

    public function __construct() {
        session_start();
    }

    public function set($key, $value) {
        $_SESSION[$key] = $value;
    }

    public function get($key) {
        return $_SESSION[$key];
    }

    public function destroy() {
        session_destroy();
    }

    public function checkAfterOneHour() : bool {

        if (isset($_SESSION['timestamp'])) {
            if ((getTimestamp() - $_SESSION['timestamp']) > ONE_HOUR) {
                return true;
            } else {
                return false;
            }
        }
    }

    function isSet($key){
        return isset($_SESSION[$key]);
    }
}

?>
