<?php

$timestamp = strtotime("now");
$formatoData = 'd/m/Y H:i:s';

$data=date($formatoData, $timestamp);


echo json_encode(array($data));

?>