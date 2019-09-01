<?php

include_once("Result.php");
class MongoDB {
    //private const HOST = "mongodb://scroking.ddns.net:27017";
    private const MARCO_NODES = "scroking.ddns.net:56786,scroking.ddns.net:56787";
    private const STEFANO_NODES = "vox3715217.mynet.vodafone.it:34512,vox3715217.mynet.vodafone.it:34513,vox3715217.mynet.vodafone.it:34514,vox3715217.mynet.vodafone.it:34515,vox3715217.mynet.vodafone.it:34516,vox3715217.mynet.vodafone.it:34517,vox3715217.mynet.vodafone.it:34518";
    private const RS = "mongodb://" . MongoDB::MARCO_NODES . "," . MongoDB::STEFANO_NODES . "/?replicaSet=rs0";

    //delegato
    private $manager;

    /**
     * MongoDB constructor.
     * @throws Exception
     */
    public function __construct() {
        try {
            $this->manager = new MongoDB\Driver\Manager(MongoDB::RS);
        } catch (Exception $e) {
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
     * @param null $projection: array of value to retrive
     * @return object: Result object
     * @throws MongoDB\Driver\Exception\Exception: if query went wrong
     */
    public function ReadOneQuery(string $db, string $collection, string $id, $projection = null) {
        //namespace is a string such "dbName.collectionName"
        $namespace = $db . "." . $collection;

        $filter = [ "_id" => $this->getIdObjectFromExistent($id) ];

        $option = [];

        if(isset($projection)) {
            foreach ($projection as $col) {
                $option['projection'][$col] = 1;
            }
        }

        $query = new MongoDB\Driver\Query($filter, $option);

        $docs = $this->manager->executeQuery($namespace, $query);


        $result = new Result();

        foreach ($docs as $doc) {
            $result->addElement($doc);
        }

        return $result->getResults()['0'];
    }

    /**
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param $filter : array of key-value
     * @param array $projection : array of value to retrive
     * @param null $sort : array of sort order
     * @return Result: Result object with object
     * @throws \MongoDB\Driver\Exception\Exception : if query went wrong
     */
    public function ReadQuery(string $db, string $collection, $filter = null, $projection = null, $sort = null) {
        //namespace is a string such "dbName.collectionName"
        $namespace = $db . "." . $collection;

        //if filter is not set init as empty array filter
        if (!isset($filter)) {
           $filter = [];
        }

        $option = [];

        if(isset($projection)) {
            foreach ($projection as $col) {
                $option['projection'][$col] = 1;
            }
        }

        if(isset($sort)) {
            $option['sort'][$sort] = 1;
        }



        $query = new MongoDB\Driver\Query($filter, $option);

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
     * @throws Exception: if query went wrong
     */
    public function WriteOneQuery(string $db, string $collection, $doc) {
        $namespace = $db . "." . $collection;

        try {
            $bulk = new MongoDB\Driver\BulkWrite();

            $bulk->insert($doc);
            $writeResult = $this->manager->executeBulkWrite($namespace, $bulk);

            return $writeResult->getInsertedCount() == 1;
        }catch(Exception $e){
            throw $e;
        }
    }

    /**
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param $id : id of the document to delete
     * @return bool : true if delete success, false otherwise
     * @throws Exception: if query went wrong
     */
    public function DeleteOneQuery(string $db, string $collection, $id): bool {
        $namespace = $db . "." . $collection;

        try {
            $bulk = new MongoDB\Driver\BulkWrite();

            $bulk->delete( [ '_id' => $this->getIdObjectFromExistent("$id")] );
            $deleteResult = $this->manager->executeBulkWrite($namespace, $bulk);

            return $deleteResult->getDeletedCount() == 1;

        } catch(Exception $e) {
            throw $e;
        }
    }

    /**
     * TODO non usarla fino a prossime disposizioni
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param $id : id of the document to update
     * @param $new_proprieties: new proprieties to update in original object
     * @return bool : true if update success, false otherwise
     * @throws Exception: if query went wrong
     * @throws \MongoDB\Driver\Exception\Exception
     */
    public function UpdateOneQuery(string $db, string $collection, $id, $new_proprieties): bool {
        $namespace = $db . "." . $collection;

        try {
            //read old document stored in mongodb
            $old_doc = $this->ReadOneQuery($db, $collection, $id, null);

            //merging new values
            $new_doc = (object) array_merge((array) $old_doc, (array) $new_proprieties);


            //update the existent documente in mongodb
            $bulk = new MongoDB\Driver\BulkWrite();
            $bulk->update( [ '_id' => $this->getIdObjectFromExistent("$id")], $new_doc);
            $deleteResult = $this->manager->executeBulkWrite($namespace, $bulk);

            return $deleteResult->getModifiedCount() == 1;

        } catch(Exception $e) {
            throw $e;
        }
    }
}

?>
