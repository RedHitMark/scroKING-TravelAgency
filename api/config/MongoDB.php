<?php

class MongoDB {
    //private const HOST = "mongodb://scroking.ddns.net:27017";
    private const MARCO_NODES = "scroking.ddns.net:56786,scroking.ddns.net:56787";
    private const STEFANO_NODES = "vox3715217.mynet.vodafone.it:34512,vox3715217.mynet.vodafone.it:34513,vox3715217.mynet.vodafone.it:34514,vox3715217.mynet.vodafone.it:34515,vox3715217.mynet.vodafone.it:34516,vox3715217.mynet.vodafone.it:34517,vox3715217.mynet.vodafone.it:34518";
    private const RS = "mongodb://" . MongoDB::MARCO_NODES . "," . MongoDB::STEFANO_NODES . "/?replicaSet=rs0";

    public const ASCENDENT_SORT = 1;
    public const DESCENTENT_SORT = -1;

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
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param string $id
     * @param null $projection : array of value to retrieve
     * @return bool|object
     * @throws \MongoDB\Driver\Exception\Exception : if query went wrong
     */
    public function ReadOneQuery(string $db, string $collection, string $id, $projection = null) {
        //namespace is a string such "dbName.collectionName"
        $namespace = $db . "." . $collection;

        //filer only document with given id
        $filter = [ "_id" => $this->getIdObjectFromExistent($id) ];

        //empty option array
        $option = [];

        //add projection option to query
        if(isset($projection)) {
            foreach ($projection as $col) {
                $option['projection'][$col] = 1;
            }
        }

        //query obj
        $query = new MongoDB\Driver\Query($filter, $option);

        //execute query
        $docs = $this->manager->executeQuery($namespace, $query);

        $result = $docs->toArray()['0'];

        return (isset($result) ?  $result : false);
    }

    /**
     * @param string $db : name of the db to query
     * @param string $collection : name of the collection to query
     * @param $filter : array of key-value
     * @param array $projection : array of value to retrive
     * @param null $limit
     * @param null $sort : array of sort order
     * @param int|null $sort_type
     * @return array: array with result objects
     * @throws \MongoDB\Driver\Exception\Exception : if query went wrong
     */
    public function ReadQuery(string $db, string $collection, $filter = null, $projection = null, $limit = null, $sort = null, int $sort_type = null) {
        //namespace is a string such "dbName.collectionName"
        $namespace = $db . "." . $collection;

        //if filter is not set init as empty array filter
        if (!isset($filter)) {
           $filter = [];
        }

        //empty option array
        $option = [];

        //add projection option to query
        if(isset($projection)) {
            foreach ($projection as $col) {
                $option['projection'][$col] = 1;
            }
        }

        //add limit option to query
        if(isset($limit)) {
            $option['limit'] = $limit;
        }

        //add sort option to query
        if(isset($sort)) {
            $option['sort'][$sort] = $sort_type;
        }

        //query obj
        $query = new MongoDB\Driver\Query($filter, $option);

        //execute query
        $docs = $this->manager->executeQuery($namespace, $query);

        //return the array of object
        return $docs->toArray();
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
