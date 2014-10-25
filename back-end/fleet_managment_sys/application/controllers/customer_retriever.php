<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');



class Customer_retriever extends CI_Controller
{

    public function index()
    {

    }

    public function createCustomer(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->createCustomer($input_data);
        if($result == true)
            $this->output->set_output(json_encode(array("statusMsg" => "success","data" => "customer created successfully ")));
        else
            $this->output->set_output(json_encode(array("statusMsg" => "fail","data" => "customer already exists")));
    }

    public function getSimilarTpNumbers(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getSimilar($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result)));

    }
//  TODO CHANGE GET THE ORDER FROM BOOKING OBJECT AND APPEND TO THE CUSTOMER OBJECT
    public function getCustomer(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" , "data" => $result )));

    }

    public function updateCustomer(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateCustomer($input_data["tp"],$input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function addBooking(){
        // TODO CHECK FOR REDUNDANCY AND CHANGE STATUS MESSAGE
        $statusMsg = 'success';
        $input_data = json_decode(trim(file_get_contents('php://input')), true);

        $user = $this->session->userdata('user');

        $input_data["data"]["refId"]=$this->ref_dao->getRefId();
        $input_data['data']['croId']=$user['uName'];

        /* Set the date and time to UTC */
        $input_data["data"]["callTime"]=new MongoDate();
        $input_data["data"]["bookTime"]=new MongoDate(strtotime($input_data['data']['bDate']." ".$input_data["data"]['bTime']));

        /* Unset the values of bDate and bTime */
        unset($input_data['data']['bTime']);
        unset($input_data['data']['bDate']);


        $input_data["data"]["tp"] = $input_data["tp"];
        $this->live_dao->createBooking($input_data["data"]);

        $bookingCreated = $this->live_dao->getBooking($input_data['data']['refId']);
        $bookingObjId = array('_id' => $bookingCreated['_id'] );
        /* Add the booking array to the customer collection */
        $this->customer_dao->addBooking($input_data["tp"], $bookingObjId);

        $this->output->set_output(json_encode(array("statusMsg" => $statusMsg)));

    }

    public function canceled(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getStatus($input_data["tp"] , $input_data["refId"]);

        if($result == ("onDaWay") || $result ==("msgCopied") || $result ==("atDaPlace") || $result ==("pob")) {

            $this->customer_dao->addCanceledDispatch($input_data["tp"]);
            $this->customer_dao->addCanceledTotal($input_data["tp"]);
            $this->customer_dao->updateStatus($input_data["tp"], $input_data["refId"], "cancelDis");

        }else{
            $this->customer_dao->updateStatus($input_data["tp"], $input_data["refId"], "cancel");
        }

        /* Adds +1 to the tot_cancel in customers collection */
        $this->customer_dao->addCanceledTotal($input_data["tp"]);
        /* Remove the record from live collection and add it to the history */
        $this->live_dao->deleteBooking($input_data["refId"]);
        /* Get the recent booking record from customers collection and add it to history collection */
        $data = $this->customer_dao->getBooking($input_data["tp"], $input_data["refId"]);

        /* add tp number for booking for easy access and add it to history collection */
        $data["tp"]=$input_data["tp"];
        $this->history_dao->createBooking($data);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));
    }

    public function updateBooking(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateBooking($input_data["tp"],$input_data["refId"],$input_data["data"]);

        $this->live_dao->updateBooking($input_data["refId"] , $input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function updateFee(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->updateBooking($input_data["tp"],$input_data["refId"],$input_data["data"]);

        $this->live_dao->updateBooking($input_data["refId"] , $input_data["data"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function addCanceledDispatch(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addCanceledDispatch($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function addCanceledTotal(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addCanceledTotal($input_data["tp"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));

    }

    public function getStatus(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getStatus($input_data["tp"] , $input_data["refId"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result  )));

    }

    public function getBooking(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getBooking($input_data["tp"] , $input_data["refId"]);
        $this->output->set_output(json_encode(array("statusMsg" => "success", "data" => $result  )));

    }

    public function addInquireCall(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $this->customer_dao->addInquireCall($input_data["tp"] , $input_data["refId"]);
        $this->live_dao->addInquireCall($input_data["refId"]);
        
        /* TODO INFORM THROUGH WEB SOCKETS CHANGE HAS HAPPENED */
        $this->output->set_output(json_encode(array("statusMsg" => "success" )));
    }

}