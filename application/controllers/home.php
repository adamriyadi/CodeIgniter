<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Public_Controller {
	
	function __construct(){
		parent::__construct();
	}

	public function index()
	{

		$data["session"] = $this->session;
		
		$data["is_home"] = "1";
		$this->template->write_view('header', 'header', $data, true);
		
		$this->template->write_view('content', 'home', $data, true);

		$this->template->render();
	}
}