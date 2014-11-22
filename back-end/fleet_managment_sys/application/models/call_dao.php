<?php
/**
 *  @property Cab_dao $Cab_dao
 */
class Call_dao extends CI_Model
{

    function __construct()
    {

    }


    function get_collection($collection = 'calls')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;
    }

    function createCall($callArray)
    {

        $collection = $this->get_collection();

        $statusMsg = true;
        $collection->insert($callArray);

        return $statusMsg;
    }


    function getLiveCalls(){

        $collection = $this->get_collection();
        $searchQuery = array("state" => "LIVE");
        $cursor = $collection->find($searchQuery);
        $callArray = array();
        foreach ($cursor as $doc) {
            array_push($callArray,$doc);
        }
        return $callArray;
    }

}