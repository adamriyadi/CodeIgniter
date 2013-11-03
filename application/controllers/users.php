<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Users extends Public_Controller {
	
	function __construct(){
		parent::__construct();
	}

	public function do_login()
	{
		$user_data = array(
			   'userid'			=> "",
			   'username'		=> "",
			   'role'			=> "",
			   'display_name'	=> "",
			   'email'			=> "",
			   'logged_in'		=> FALSE
		   );
		
		$this->session->set_userdata($user_data);
		
		$username = $this->input->post("username");
		$password = $this->input->post("password");

		if($username != 'admin' && $password != 'password'){
			$user_data = array(
				   'userid'			=> "",
				   'username'		=> "",
				   'role'			=> "",
				   'display_name'	=> "",
				   'email'			=> "",
				   'logged_in'		=> FALSE
				);

			$this->session->set_userdata($user_data);

			$array["result"] = "<strong>Error!</strong> User/Password not found !!!";

			echo json_encode($array);
			exit;
			
		}
		else {
			$user_data = array(
                   'userid'			=> '1',
                   'username'		=> 'admin',
                   'role'			=> '1',
                   'display_name'	=> 'admin',
                   'email'			=> '',
                   'logged_in'		=> TRUE
               );

			$this->session->set_userdata($user_data);

			$array["result"] = "1";

			echo json_encode($array);
			exit;
		}
	}

	public function do_logout()
	{
		$user_data = array(
			   'userid'			=> "",
			   'username'		=> "",
			   'role'			=> "",
			   'display_name'	=> "",
			   'email'			=> "",
			   'logged_in'		=> FALSE
			);
		
		$this->session->set_userdata($user_data);
		redirect(base_url(), 'refresh');
	}
}