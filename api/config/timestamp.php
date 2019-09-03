<?php
    const FIVE_SECOND = 5000;
    const ONE_HOUR = 3600000;

    function getTimestamp() {
        $mt = explode(' ', microtime());
        return ((int)$mt[1]) * 1000  + ((int)round($mt[0] * 1000 ));
    }

    function milliseconds_to_seconds($ms) {
        return (int) $ms/1000;
    }

    function milliseconds_between($newer_timestamp, $older_timestamp) {
        return (int) $newer_timestamp - $older_timestamp;
    }

    function seconds_between($newer_timestamp, $older_timestamp) {
        return (int) milliseconds_to_seconds(milliseconds_between($newer_timestamp, $older_timestamp));
    }

