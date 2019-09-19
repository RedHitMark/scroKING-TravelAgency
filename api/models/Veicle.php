<?php

    class Veicle {
        public $_id;
        public $name;
        public $vtype;
        public $description;
        public $seats;
        public $vprice;

        public function __construct($_id, $name, $vtype, $description, $seats, $vprice) {
            $this->_id = $_id;
            $this->name = $name;
            $this->description = $description;
            $this->seats = $seats;
            $this->vprice = $vprice;
        }




    }


?>