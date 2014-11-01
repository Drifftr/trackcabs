<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cro_controller extends CI_Controller
{

    public function index()
    {
        $this->load->view('cro/cro_main');
    }

    function test()
    {
        //$prev_date = date('Y-m-d', strtotime(date('Y-m-d') .' -1 day'));
        $prev_date = date('Y-m-d');
        var_dump($prev_date);

        /* set the timezone for the call time */
        $bookDT = new DateTime(date($prev_date). ''.date('00:00:00'), new DateTimeZone('UTC'));
        $bookTS = $bookDT->getTimestamp();
        $data = array('time' => new MongoDate($bookTS));

        $db  = new MongoClient();
        $dbName = $db->selectDB('track');
        $collection = $dbName->selectCollection('live');

        $collection->insert($data);

        $this->load->view('cro/my_bookings/my_bookings_main');
    }

    function getTodayMyBookings(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        // TODO SET THE SESSION USERID AS PARAMETER
        $data = $this->live_dao->getCroBookingsToday('niro');

        $data['booking_summary'] = $this->load->view('cro/my_bookings/booking_summary', $data , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getCroDefaultView(){
        $this->load->view('cro/cro_main');
    }

    function getCustomerInfoEditView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        $data['table_content'] = $this->load->view('cro/customer_info_edit', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));

    }

    function getEditBookingView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->live_dao->getBookingByMongoId($input_data['objId']);
        $data['edit_booking_view'] = $this->load->view('cro/edit_booking', $result , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCancelConfirmationView(){

        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $bookingData = $this->live_dao->getBookingByMongoId($input_data['_id']);

        $data['cancel_confirmation_view'] = $this->load->view('cro/cancel_booking', $bookingData , TRUE);
        $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
    }

    function getCustomerInfoView(){
        $input_data = json_decode(trim(file_get_contents('php://input')), true);
        $result = $this->customer_dao->getCustomer($input_data['tp']);

        if($result == null){
            $result =array('tp' => $input_data['tp']);
            $data['table_content'] = $this->load->view('cro/new_customer_form', $result , TRUE);
            /* Customer is new so send empty to to the JOB Info View */
            $data['job_info_view'] = '';
            $data['new_booking_view'] = '';
            $this->output->set_output(json_encode(array("statusMsg" => "fail","view" => $data)));
        }else{

            $bookingData=array('booking' => array());
            foreach($result as $key => $value){
                if($key == 'history'){
                    foreach($value as $newKey){
                        $data = $this->live_dao->getBookingByMongoId($newKey['_id']);
                        if($data != null){
                            $bookingData['booking'][] = $data;
                        }
                        $data = $this->history_dao->getBookingByMongoId($newKey['_id']);
                        if($data != null){
                            $bookingData['booking'][] = $data;
                        }
                    }
                }
            }
            $data['table_content'] = $this->load->view('cro/customer_info', $result , TRUE);
            $data['job_info_view'] = $this->load->view('cro/job_info', $bookingData , TRUE);
            $data['new_booking_view'] = $this->load->view('cro/new_booking', $result , TRUE);
            $this->output->set_output(json_encode(array("statusMsg" => "success","view" => $data)));
        }
    }

}