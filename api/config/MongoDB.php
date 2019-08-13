<?php

use MongoDB\Driver\BulkWrite;

class MongoDB {
    private $manager;

    public function __construct() {
        try {
            $this->manager = new MongoDB\Driver\Manager("mongodb://scroking.ddns.net:27017");
        } catch (MongoDB\Driver\Exception\Exception $e) {
            throw $e;
        }
        
    }


    public function ReadQuery($query ) {
        $rows = $this->manager->executeQuery("scroKING.user", $query);
        return $rows;
    }

    public function WriteQuery($doc){
        $bulk = new MongoDB\Driver\BulkWrite();

        try {

            $bulk->insert($doc);
            $this->manager->executeBulkWrite('scroKING.user', $bulk);

        }catch(MongoDB\Driver\Exception\BulkWriteException $e){
            throw $e;
        }
    }

}

?>
