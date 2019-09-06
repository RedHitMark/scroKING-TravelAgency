<?php
class User {
    public $_id;
    public $name;
    public $surname;
    public $email;
    public $username;
    public $password;
    public $blockedUntil;

    public function __construct($_id, $name, $surname, $email, $username, $password, $blockedUntil) {
        $this->_id = $_id; 
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        $this->username = $username;
        $this->password = $password;
        $this->blockedUntil = $blockedUntil;
    }
}
