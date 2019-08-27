<?php

include_once("Result.php");
class MongoDB {
    //private const HOST = "mongodb://scroking.ddns.net:27017";
    private const RS = "mongodb://scroking.ddns.net:56786,scroking.ddns.net:56787,scroking.ddns.net:56788/?replicaSet=rs0";
    private $manager;

    /**
     * MongoDB constructor.
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function __construct() {
        try {
            $this->manager = new MongoDB\Driver\Manager(MongoDB::RS);
        } catch (MongoDB\Driver\Exception\Exception $e) {
            throw $e;
        }
        
    }

    public function getNewIdObject() {
        return new MongoDB\BSON\ObjectID();
    }

    public function getIdObjectFromExistent($id) {
        return new MongoDB\BSON\ObjectID($id);
    }

    public function getIdFromObj($obj) {
        return $obj->__toString();
    }

    /**
     * @param $db: name of the db to query
     * @param $collection: name of the collection to query
     * @param $filter: array of key-value
     * @param null $projection: array of value to retrive
     * @param null $sort: array of sort order
     * @return Result: Result object with object
     * @throws MongoDB\Driver\Exception\Exception: if query went wrong
     */
    public function ReadOneQuery(string $db, string $collection, $id = null, $projection = null) {
        //namespace is a string such "dbName.collectionName"
        $namespace = $db . "." . $collection;

        //@TODO
    }

    /**
     * @param $db: name of the db to query
     * @param $collection: name of the collection to query
     * @param $filter: array of key-value
     * @param null $projection: array of value to retrive
     * @param null $sort: array of sort order
     * @return Result: Result object with object
     * @throws MongoDB\Driver\Exception\Exception: if query went wrong
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
     * @param $db : name of the db to query
     * @param $collection : name of the collection to query
     * @param $doc object to write
     * @return bool : true if insert success, false otherwise
     * @throws MongoDB\Driver\Exception\BulkWriteException: if query went wrong
     */
    public function WriteOneQuery(string $db, string $collection, $doc) {
        $namespace = $db . "." . $collection;

        $bulk = new MongoDB\Driver\BulkWrite();

        try {
            $bulk->insert($doc);
            $writeResult = $this->manager->executeBulkWrite($namespace, $bulk);

            return $writeResult->getInsertedCount() == 1;
        }catch(MongoDB\Driver\Exception\BulkWriteException $e){
            throw $e;
        }
    }

    /**
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param $id : id of the document to delete
     * @return bool : true if delete success, false otherwise
     * @throws MongoDB\Driver\Exception\BulkWriteException: if query went wrong
     */
    public function DeleteOneQuery(string $db, string $collection, $id): bool {
        $namespace = $db . "." . $collection;

        $bulk = new MongoDB\Driver\BulkWrite();

        try {
            $bulk->delete( [ '_id' => $this->getIdObjectFromExistent("$id")] );
            $deleteResult = $this->manager->executeBulkWrite($namespace, $bulk);

            return $deleteResult->getDeletedCount() == 1;

        } catch(MongoDB\Driver\Exception\BulkWriteException $e) {
            throw $e;
        }
    }

    /**
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param $id : id of the document to update
     * @param $doc : document to update
     * @return bool : true if update success, false otherwise
     * @throws MongoDB\Driver\Exception\BulkWriteException: if query went wrong
     */
    public function UpdateOneQuery(string $db, string $collection, $id, $doc): bool {
        $namespace = $db . "." . $collection;

        $bulk = new MongoDB\Driver\BulkWrite();

        try {
            $bulk->update( [ '_id' => $this->getIdObjectFromExistent("$id")], $doc );
            $deleteResult = $this->manager->executeBulkWrite($namespace, $bulk);

            return $deleteResult->getModifiedCount() == 1;

        } catch(MongoDB\Driver\Exception\BulkWriteException $e) {
            throw $e;
        }
    }
}

?>
