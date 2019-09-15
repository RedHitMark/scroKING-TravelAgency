<?php

class Address {
    public $street;
    public $cap;
    /**
     * Log constructor.
     * @param $street
     * @param $cap
     */
    public function __construct($street, $cap) {
        $this->street = $street;
        $this->cap = $cap;
    }


}