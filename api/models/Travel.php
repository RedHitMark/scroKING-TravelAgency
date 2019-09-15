<?php

class Travel {
    public $_id;
    public $destination;

    /**
     * Travel constructor.
     * @param $_id
     * @param $destination
     */
    public function __construct($_id, $destination) {
        $this->_id = $_id;
        $this->destination = $destination;
    }


}