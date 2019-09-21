<?php 

    class Hotel {
        public $_id;
        public $name;
        public $description;
        public $address;
        public $phone;
        public $email;
        public $freeRoom;

        /**
         * Hotel constructor.
         * @param $_id
         * @param $name
         * @param $description
         * @param $address
         * @param $phone
         * @param $email
         * @param $freeRoom
         */
        public function __construct($_id, $name, $description, $address, $phone, $email, $freeRoom) {
            $this->_id = $_id;
            $this->name = $name;
            $this->description = $description;
            $this->address = $address;
            $this->phone = $phone;
            $this->email = $email;
            $this->freeRoom = $freeRoom;
        }
    }
