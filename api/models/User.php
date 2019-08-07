<?php
class User {
    private $_id;
    private $username;
    private $password;

    public function __construct($_id, $username, $password) {
        $this->_id = $_id; 
        $this->username = $username;
        $this->password = $password;
    }
}
