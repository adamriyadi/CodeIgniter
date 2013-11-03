<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dashboard extends Admin_Controller {
	
	function __construct(){
		parent::__construct();

		$this->controller = "dashboard";
	}

	public function index()
	{

		$data["session"] = $this->session;

		$this->template->write_view('header', 'header', $data, true);
		
		$this->template->write_view('content', $this->controller.'/index', $data, true);

		$this->template->render();
	}
}