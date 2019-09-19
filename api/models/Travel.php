<?php

class Travel {
    public $_id;
    public $type;
    public $destination;
    public $startdata;
    public $finishdata;
    public $price;
    public $viecles;
    public $hotels;


    /**
     * Travel constructor.
     * @param $_id
     * @param $destination
     */


    public function __construct($_id, $type, $destination, $startdata, $finishdata, $price, $viecles, $hotels) {
        $this->_id = $_id;
        $this->type = $type;
        $this->destination = $destination;
        $this->$startdata = $startdata;
        $this->$finishdata = $finishdata;
        $this->$price = $price;
        $this->$viecles = $viecles;
        $this->$hotels = $hotels;
    }


}