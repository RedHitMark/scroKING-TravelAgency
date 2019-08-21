<?php

include("Log.php");

class LoginLog extends Log {
    public $userId;
    public $result;

    /**
     * LoginLog constructor.
     * @param $id
     * @param $result
     */
    public function __construct($timestamp, $ip, $userId, $result){
        parent::__construct($timestamp, $ip);
        $this->userId = $userId;
        $this->result = $result;
    }


}