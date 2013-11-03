<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Viewpanel { 

	private $view = "";
	private $id = "";
	private $enabled = true;

	protected $CI = null;
	protected $__string = '';

	public function __construct($id = "") {
        $this->CI = & get_instance();
		$this->id = $id;
	}

	public function setView($view) {
		$this->view = $view;

		return $this;
	}

	public function setEnabled($enabled) {
		$this->enabled = $enabled;

		return $this;
	}

	public function setId($id) {
		$this->id = $id;

		return $this;
	}
	
	protected function generate() {
		$view =  $this->view;
		if ($this->id != "") {
			$view = "<div id='".$this->id."'>".$view."</div>";
		}
		$this->__string = $view;
	}
	
	public function render(){
		$this->generate();

		echo $this->__string;
	}

	public function toString(){
		$this->generate();

		return $this->__string;
	}

}