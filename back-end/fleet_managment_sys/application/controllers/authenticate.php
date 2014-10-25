<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Authenticate extends CI_Controller {
	function __construct() {
		parent::__construct();
//		$this -> load -> model('user', '', TRUE);
	}

	public function index() {
		//This method will have the credentials validation
		$this -> load -> library('form_validation');

		$this -> form_validation -> set_rules('username', 'Username', 'trim|required|xss_clean');
		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|xss_clean|callback_check_database');

		if ($this -> form_validation -> run() == FALSE) {
			//Field validation failed.  User redirected to login page
			$this -> load -> view('login/index');
		} else {
			//Go to private area
			redirect('dispatcher', 'refresh');
		}

	}

    function driver(){
        $this -> load -> library('form_validation');
        // TODO: get last loging of the driver and allow login
        $this -> form_validation -> set_rules('username', 'Username', 'trim|required|xss_clean');
        $this -> form_validation -> set_rules('password', 'Password', 'trim|required|xss_clean|callback_driver_auth');

        $validationResult = $this -> form_validation -> run();
        if ( $validationResult == FALSE) {
            $authentication = array('isAuthorized' => false);
        } else {
            //Go to private area
            $authentication = array('isAuthorized' => true,$validationResult->role->driverId );

        }

        $this -> output -> set_content_type('application/json') -> set_output(json_encode($return));
    }

	function check_database($password) {
        return TRUE; // TODO: remove this line when user db is ready
		//Field validation succeeded.  Validate against database
		$username = $this -> input -> post('username');

		//query the database
		$row = $this -> user -> login($username, $password);

		if ($row) {
			if ($row -> loginApprovalBit == "0") {
				$sess_array = array('computer_number' => $row -> computer_number, 'full_name' => $row -> Full_Name, 'isAdmin' => $this->user->isAdmin($row -> computer_number));
				$this -> session -> set_userdata('logged_in', $sess_array);
				$this->user->update_login($row -> computer_number);
				return TRUE;
			} else {
                $driver = $this->users_dao->find();
				$this -> form_validation -> set_message('check_database', 'Sorry you do not have privileges to login to the system');
				return false;
			}

		} else {
			$this -> form_validation -> set_message('check_database', 'Invalid username or password');
			return false;
		}
	}

    function driver_auth($password){
        $username = $this -> input -> post('username');
        $result = $this->driver_dao->authenticate($username,$password);
        $return = false;
        if($result){
            $return = true;
        }

        return $return;
    }

}