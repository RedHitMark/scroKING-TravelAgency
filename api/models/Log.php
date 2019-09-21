<?php

    class Log {
        public $timestamp;
        public $ip;

        /**
         * Log constructor.
         * @param $timestamp
         * @param $ip
         */
        public function __construct($timestamp, $ip) {
            $this->timestamp = $timestamp;
            $this->ip = $ip;
        }
    }
