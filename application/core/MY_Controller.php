<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'core/Public_Controller.php'); // contains some logic applicable only to `public` controllers
require(APPPATH.'core/Admin_Controller.php'); // contains some logic applicable only to `admin` controllers

class MY_Controller extends CI_Controller {
	
	protected $ci;
	protected $limit = 15;
	protected $offset = 0;
	protected $page = 0;
	protected $data = array();
	protected $act = "";
	
	function __construct(){
		parent::__construct();
		$this->ci =& get_instance();

		$this->template->add_js('var base_url = "'.base_url().'";','embed');
		$this->template->add_js($this->config->item("jquery_js"));
		$this->template->add_js($this->config->item("jshashtable_js"));
		$this->template->add_js($this->config->item("jquery_numberformatter_js"));
		$this->template->add_js($this->config->item("bootstrap_js"));
		$this->template->add_js($this->config->item("bootstrap_filestyle_js"));
		$this->template->add_js($this->config->item("bootstrap_datepicker_js"));
		$this->template->add_js($this->config->item("main_js"));

		$this->template->add_css($this->config->item("bootstrap_css"));
		$this->template->add_css($this->config->item("bootstrap_icon_css"));
		$this->template->add_css($this->config->item("bootstrap_datepicker_css"));
		$this->template->add_css($this->config->item("main_css"));
		$this->template->add_css($this->config->item("font-awesome_css"));
		$this->template->add_css($this->config->item("normalize_css"));

		$this->load->library('ui/actions', null, 'ui_actions');
		$this->load->library('ui/datagrid', null,'ui_datagrid');
		$this->load->library('ui/tabpanel', null,'ui_tabpanel');

		$this->load->library('form/textfield');
		$this->load->library('form/hiddenfield');
		$this->load->library('form/textarea');
		$this->load->library('form/combobox');
		$this->load->library('form/inputfile');
		$this->load->library('form/datepicker');
		$this->load->library('form/dateinput');
		$this->load->library('form/title');
		$this->load->library('form/viewpanel');
		$this->load->library('form/dialoginput');
		$this->load->library('form/ckeditor');
		$this->load->library('form/button');

		$this->load->library('ui/formpanel', null, 'ui_formpanel');
		$this->load->library('ui/searchpanel', null, 'ui_searchpanel');
		
		$this->act = $this->input->get("act");

		$limit = $this->input->get("limit");
		if ($limit != "") {
			$this->limit = $limit;
		}
		
		$page = $this->input->get("page");
		if ($page == "") {
			$page = 1;
		}
		$this->page = $page;
		$this->offset = $this->limit * ($this->page - 1);

		$data["session"] = $this->session;

		$data["is_home"] = "0";

		$this->data = $data;
	}
}