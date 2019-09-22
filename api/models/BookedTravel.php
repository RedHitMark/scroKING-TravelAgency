<?php

    class BookedTravel {
        public $_id;
        public $id_user;
        public $id_travel;
        public $booked_timestamp;

        //public $id_transaction;

        public function __construct($_id, $id_user, $id_travel, $booked_timestamp) {
            $this->_id = $_id;
            $this->id_user = $id_user;
            $this->id_travel = $id_travel;
            // $this->id_transaction = $id_transaction;
            $this->booked_timestamp = $booked_timestamp;
        }
    }
