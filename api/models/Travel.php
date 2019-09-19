<?php

    class Travel {
        public $_id;
        public $type;
        public $destination;
        public $startdata;
        public $finishdata;
        public $price;
        public $veicles;
        public $hotels;


        /**
         * Travel constructor.
         * @param $_id
         * @param $type
         * @param $destination
         * @param string $startdata
         * @param string $finishdata
         * @param string $price
         * @param array $veicles
         * @param array $hotels
         */
         public function __construct($_id, $type, $destination, string $startdata, string $finishdata, string $price, array $veicles, array $hotels) {
            $this->_id = $_id;
            $this->type = $type;
            $this->destination = $destination;
            $this->startdata = $startdata;
            $this->finishdata = $finishdata;
            $this->price = $price;
            $this->veicles = $veicles;
            $this->hotels = $hotels;
        }


    }
