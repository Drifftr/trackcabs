<?php
 if (!defined('BASEPATH'))
     exit('No direct script access allowed');
 session_start();
 class Monitor extends CI_Controller {

     public function index() {
         if (is_user_logged_in()) {
             $new_orders = $this->live_dao->getAllBookings();
             $this -> load -> view('monitor/index',array('orders' => $new_orders));
         } else {
             //If no session, redirect to login page
             $this -> load -> library('form_validation');
             $this -> form_validation -> set_message('check_database', 'Invalid username or password');
             redirect('login', 'refresh');
         }
     }

     public function getOrder($orderRefId){
         $order = $this->live_dao->getBooking($orderRefId);
         $driver = $this->user_dao->getUser($order['driverId']);
         $order['driver'] = $driver;
         $this->output->set_content_type('application/json');
         echo json_encode($order);
     }
 }