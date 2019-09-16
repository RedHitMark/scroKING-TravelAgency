<?php

include_once("Log.php");

class UpdateUsernameLog extends Log{

    public $userId;
    public $oldUsername;
    public $newUsername;

    /**
     * LoginLog constructor.
     * @param $timestamp
     * @param $ip
     * @param $userId
     * @param $result
     */
    public function __construct($timestamp, $ip, $userId, $oldUsername, $newUsername) {
        parent::__construct($timestamp, $ip);
        $this->userId = $userId;
        $this->oldUsername = $oldUsername;
        $this->newUsername = $newUsername;
    }


}


?>
