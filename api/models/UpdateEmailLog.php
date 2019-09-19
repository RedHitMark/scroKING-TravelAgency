<?php

include_once("Log.php");

class UpdateEmailLog extends Log {
    public $userId;
    public $oldEmail;
    public $newEmail;

    /**
     * LoginLog constructor.
     * @param $timestamp
     * @param $ip
     * @param $userId
     * @param $oldEmail
     * @param $newEmail
     */
    public function __construct($timestamp, $ip, $userId, $oldEmail, $newEmail) {
        parent::__construct($timestamp, $ip);
        $this->userId = $userId;
        $this->oldEmail = $oldEmail;
        $this->newEmail = $newEmail;
    }


}
