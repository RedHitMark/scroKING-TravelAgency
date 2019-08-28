<?php 

const FIVE_SECOND = 5000;
const ONE_HOUR = 3600000;
                 
function getTimestamp() {
    $mt = explode(' ', microtime());
    return ((int)$mt[1]) * 1000  + ((int)round($mt[0] * 1000 ));
}

?>