<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Public_Controller extends MY_Controller {
	
	function __construct(){
		parent::__construct();
		$this->ci =& get_instance();

		$data = $this->data;
		$this->template->write_view('header', 'header', $data, true);
		$this->template->write_view('footer', 'footer', $data, true);
	}
}