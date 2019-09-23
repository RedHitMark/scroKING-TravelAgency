<?php


class CurlPotente {
    private const BASE_URL = "http://vox3715217.mynet.vodafone.it:34518";


    private $path;
    private $curl;

    /**
     * CurlPotente constructor.
     * @param $path
     */
    public function __construct($path) {
        $this->path = $path;

        $this->curl = curl_init();

        curl_setopt($this->curl,CURLOPT_URL,CurlPotente::BASE_URL . $path);
        curl_setopt($this->curl,CURLOPT_RETURNTRANSFER,true);
        curl_setopt($this->curl,CURLOPT_HEADER, false);
    }

    public function getJson() {
        $result = curl_exec($this->curl);

        return json_decode($result);
    }

    public function getHttpStatusCode() {
        return curl_getinfo ( $this->curl,  CURLINFO_HTTP_CODE);
    }

    public function closeConnection() {
        curl_close($this->curl);
    }


}
