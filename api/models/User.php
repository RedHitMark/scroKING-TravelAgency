<?php
    include_once("../models/Address.php");

    class User {
        public $_id;
        public $name;
        public $surname;
        public $address;
        public $email;
        public $username;
        public $password;
        public $role;
        public $blockedUntil;

        public function __construct($_id, $name, $surname, Address $address, $email, $username, $password, $role, $blockedUntil) {
            $this->_id = $_id;
            $this->name = $name;
            $this->surname = $surname;
            $this->address = $address;
            $this->email = $email;
            $this->username = $username;
            $this->password = $password;
            $this->role = $role;
            $this->blockedUntil = $blockedUntil;
        }
    }
