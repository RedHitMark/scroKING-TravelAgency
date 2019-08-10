<?php
class MongoDB {
    private $manager;

    public function __construct() {
        try {
            $manager = new MongoDB\Driver\Manager("mongodb://scroking.ddns.net:27017");
        } catch (MongoDB\Driver\Exception\Exception $e) {
            throw $e;
        }
        
    }


    public function executeQuery($dbname ) {
        //@TODO
    }
    


}

?>