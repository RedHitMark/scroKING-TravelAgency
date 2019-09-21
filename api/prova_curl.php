<?php

$curlSES=curl_init();

curl_setopt($curlSES,CURLOPT_URL,"http://localhost:8080/getTransactions");
curl_setopt($curlSES,CURLOPT_RETURNTRANSFER,true);
curl_setopt($curlSES,CURLOPT_HEADER, false);

$result=curl_exec($curlSES);

curl_close($curlSES);

echo $result;
