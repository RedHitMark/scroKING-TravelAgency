<?php

    include_once("Log.php");

    class RegistrationLog extends Log {
        public $username;
        public $email;
        public $result;

        /**
         * LoginLog constructor.
         * @param $timestamp
         * @param $ip
         * @param $username
         * @param $email
         * @param $result
         */
        public function __construct($timestamp, $ip, $username, $email, $result) {
            parent::__construct($timestamp, $ip);
            $this->username = $username;
            $this->email = $email;
            $this->result = $result;
        }
    }
