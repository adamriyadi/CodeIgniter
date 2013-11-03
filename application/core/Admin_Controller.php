<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_Controller extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->ci =& get_instance();
		
		if (!$this->session->userdata("logged_in") || ($this->session->userdata("logged_in") == "") ){
			redirect(base_url()."error/error_site?err=1", 'refresh');
			exit;
		}

		$data = $this->data;
		$this->template->write_view('header', 'header', $data, true);
		$this->template->write_view('footer', 'footer', $data, true);
	}
}