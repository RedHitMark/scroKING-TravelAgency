<?php

include("Result.php");
class MongoDB {
    private $manager;

    /**
     * MongoDB constructor.
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function __construct() {
        try {
            $this->manager = new MongoDB\Driver\Manager("mongodb://scroking.ddns.net:27017");
        } catch (MongoDB\Driver\Exception\Exception $e) {
            throw $e;
        }
        
    }


    /**
     * @param $query
     * @return
     * @throws \MongoDB\Driver\Exception\Exception\
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function ReadQuery($filter, $projection = null, $sort = null) {
        $query = new MongoDB\Driver\Query($filter);

        $docs = $this->manager->executeQuery("scroKING.user", $query);

        $result = new Result();

        foreach ($docs as $doc) {
            $result->addElement($doc);
        }

        return $result;
    }

    /**
     * @param $doc object to write
     */
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
