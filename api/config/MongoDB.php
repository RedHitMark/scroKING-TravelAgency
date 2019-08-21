<?php

include("Result.php");
class MongoDB {
    private const HOST = "mongodb://scroking.ddns.net:27017";
    private $manager;

    /**
     * MongoDB constructor.
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function __construct() {
        try {
            $this->manager = new MongoDB\Driver\Manager(MongoDB::HOST);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            throw $e;
        }
        
    }


    /**
     * @param $db: name of the mongo db to query
     * @param $collection: name of the collection to query
     * @param $filter:
     * @param null $projection:
     * @param null $sort:
     * @return Result
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function ReadQuery(string $db, string $collection, $filter, $projection = null, $sort = null) {
        $namespace = $db . "." . $collection;

        $query = new MongoDB\Driver\Query($filter);


        $docs = $this->manager->executeQuery($namespace, $query);

        $result = new Result();

        foreach ($docs as $doc) {
            $result->addElement($doc);
        }

        return $result;
    }

    /**
     * @param $doc object to write
     */
    public function WriteQuery(string $db, string $collection, $doc){
        $namespace = $db . "." . $collection;

        $bulk = new MongoDB\Driver\BulkWrite();

        try {

            $bulk->insert($doc);
            $this->manager->executeBulkWrite($namespace, $bulk);

        }catch(MongoDB\Driver\Exception\BulkWriteException $e){
            throw $e;
        }
    }

}

?>
