<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Error extends Public_Controller {
	
	function __construct(){
		parent::__construct();
	}

	public function error_404()
	{
		$data["session"] = $this->session;

		$this->template->write_view('content', 'error/error_404', $data, true);

		$this->template->render();
	}

	public function error_site()
	{
		$err = $this->input->get("err");
		$data["session"] = $this->session;
		$title = "Error!";
		$message = "Unkown error occured !!!";
		if($err == 1){
			$user_data = array(
			   'userid'			=> "",
			   'username'		=> "",
			   'role'			=> "",
			   'display_name'	=> "",
			   'logged_in'		=> FALSE
			);
		
			$this->session->set_userdata($user_data);
			$title = "Authentication failed!";
			$message = "<strong>Authentication failed!</strong> You are not allowed to access this page !!!";
		}

		$data["message"] = $message;
		$data["title"] = $title;
		$this->template->write_view('content', 'error/error_site', $data, true);

		$this->template->render();
	}
}