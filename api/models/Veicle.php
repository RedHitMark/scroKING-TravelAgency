<?php

    class Veicle {
        public $_id;
        public $name;
        public $type;
        public $description;
        public $seats;
        public $price;

        public function __construct($_id, $name, $type, $description, $seats, $price) {
            $this->_id = $_id;
            $this->name = $name;
            $this->type = $type;
            $this->description = $description;
            $this->seats = $seats;
            $this->price = $price;
        }
    }
