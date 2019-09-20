<?php

    include_once("Log.php");

    class UpdatePasswordLog extends Log
    {
        public $userId;
        public $result;

        /**
         * LoginLog constructor.
         * @param $timestamp
         * @param $ip
         * @param $userId
         * @param $result
         */
        public function __construct($timestamp, $ip, $userId, $result)
        {
            parent::__construct($timestamp, $ip);
            $this->userId = $userId;
            $this->result = $result;
        }
    }
