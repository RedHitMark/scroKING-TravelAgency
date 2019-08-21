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
     * @param $db: name of the db to query
     * @param $collection: name of the collection to query
     * @param $filter: array of key-value
     * @param null $projection: array of value to retrive
     * @param null $sort: array of sort order
     * @return Result: Result object with object
     * @throws \MongoDB\Driver\Exception\Exception: if query went wrong
     */
    public function ReadQuery(string $db, string $collection, $filter = null, $projection = null, $sort = null) {
        //namespace is a string such "dbName.collectionName"
        $namespace = $db . "." . $collection;

        //if filter is not set init as empty array filter
        if (!isset($filter)) {
           $filter = [];
        }

        $query = new MongoDB\Driver\Query($filter);


        $docs = $this->manager->executeQuery($namespace, $query);

        $result = new Result();

        foreach ($docs as $doc) {
            $result->addElement($doc);
        }

        return $result;
    }

    /**
     * @param $db: name of the db to write
     * @param $collection: name of the collection to write
     * @param $doc object to write
     */
    public function WriteOneQuery(string $db, string $collection, $doc) {
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
