<?php

class Result {
    public $results;
    public $numResults;

    public function __construct() {
        $this->results = array();
        $this->numResults = 0;
    }

    public function addElement($res) {
        $this->results[$this->numResults] = $res;
        $this->numResults++;
    }

    public function getNumResults() {
        return $this->numResults;
    }

    public function getResults() {
        return $this->results;
    }
}