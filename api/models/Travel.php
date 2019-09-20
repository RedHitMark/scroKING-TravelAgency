<?php

    class Travel {
        public $_id;
        public $type;
        public $destinations;
        public $startdata;
        public $finishdata;
        public $price;
        public $veicles;
        public $hotels;


        /**
         * Travel constructor.
         * @param $_id
         * @param $type
         * @param array $destinations
         * @param string $startdata
         * @param string $finishdata
         * @param string $price
         * @param array $veicles
         * @param array $hotels
         */
         public function __construct($_id, string $type, array $destinations, string $startdata, string $finishdata, string $price, array $veicles, array $hotels) {
            $this->_id = $_id;
            $this->type = $type;
            $this->destinations = $destinations;
            $this->startdata = $startdata;
            $this->finishdata = $finishdata;
            $this->price = $price;
            $this->veicles = $veicles;
            $this->hotels = $hotels;
        }
    }
