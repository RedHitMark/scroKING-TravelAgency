<?php

    include_once("timestamp.php");

    /**
     * @param array $logs: last login attempt to analyse, they are ordered in descending order
     * @return bool: true if is bruteforcing, false otherwise
     */
    function is_bruteforceing(array $logs) : bool {
        //in case there are less then 5 login attempts is ok
        if(count($logs) < 5) {
            return false;
        }

        //check if last 5 attempts where in less then 10 seconds
        if ($logs['0']->timestamp - $logs['4']->timestamp  < 10000) {
            return true;
        }

        return false;
    }

    /**
     * @return string: the ip address of client
     */
    function getClientIp() : string {
        $ip = "";

        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        return $ip;
    }

    function getLocationFromIp($ip) {
        return json_decode(file_get_contents("http://api.ipstack.com/". $ip . "?access_key=07442de09688a3b8e53eaf8c132b61f4&format=1"));
    }

    function isUserBlocked(int $blockedUntil = null) : bool {
        if( isset($blockedUntil)) {
            return $blockedUntil >= getTimestamp();
        } else {
            return false;
        }
        
    }
