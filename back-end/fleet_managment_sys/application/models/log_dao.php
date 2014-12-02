<?php
class Log_dao extends CI_Model
{

    function __construct()
    {

    }

    function get_collection($collection = 'logs')
    {
        $conn = new MongoClient();
        $collection = $conn->selectDB('track')->selectCollection($collection);
        return $collection;

    }

    function createLog($input_data){
        $collection = $this->get_collection();
        $collection->insert($input_data);
        return;
    }

    function getCallingNumberByDate($date,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver', 'log_type' => 'login' );
        $log = $collection->findOne($searchQuery);
        return $log;
    }

    function getLogoutByDate($date,$driverId){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver', 'log_type' => 'logout' );
        $log = $collection->findOne($searchQuery);
        return $log;
    }

    function updateCallingNumber($date,$driverId,$callingNo){
        $collection = $this->get_collection();
        $searchQuery = array('userId' => $driverId,'date' => $date ,'user_type' => 'driver');
        $collection->update($searchQuery,array('$set' => array('callingNumber' => new MongoInt32($callingNo))),array('multiple' => true));
    }


}