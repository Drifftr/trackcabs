<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Call extends CI_Controller
{

    public function index()
    {

    }


    function getLiveCalls()
    {

        $calls = $this->call_dao->getLiveCalls();
        $this->output->set_output(json_encode($calls));

    }

    function pabxData()
    {
        $postData = $this->input->post();
        $state = array_keys($postData)[0];

        $today = date("Y-m-d h:ia");

        $csvCallArray = str_getcsv($postData[$state]);
        $callInfo = array(
            "state" => $state,
            "phone_number" => $csvCallArray[1],
            "date" => new MongoDate(strtotime($today)),
            "parameter1" => $csvCallArray[4],
            "extension_number" => $csvCallArray[5]
        );

        $this->call_dao->createCall($callInfo);

    }
}