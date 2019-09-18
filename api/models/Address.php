<?php

class Address {
    public $street;
    public $city;
    public $cap;
    public $region;
    public $state;

    /**
     * Address constructor.
     * @param $street
     * @param $city
     * @param $cap
     * @param $region
     * @param $state
     */
    public function __construct($street, $city, $cap, $region, $state) {
        $this->street = $street;
        $this->city = $city;
        $this->cap = $cap;
        $this->region = $region;
        $this->state = $state;
    }


}
