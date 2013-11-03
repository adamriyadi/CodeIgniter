<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Hiddenfield { 

	private $value = "";
	private $id = "";
	private $name = "";
	private $enabled = true;

	protected $CI = null;
	protected $__string = '';

	public function Hiddenfield($id="",$name="",$value="") {
        $this->CI = & get_instance();
		
		$this->id = $id;
		$this->name = $name;
		if ($this->name == "") {
			$this->name = $id;
		}
		$this->value = $value;
	}

	public function setEnabled($enabled) {
		$this->enabled = $enabled;

		return $this;
	}

	public function setValue($value) {
		$this->value = $value;

		return $this;
	}
	
	public function setId($id = "") {
		$this->id = $id;

		return $this;
	}
	
	public function setName($name = "") {
		$this->name = $name;

		return $this;
	}
	
	protected function generate() {
		
		
		$hiddenfield .= '<input type="hidden" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" />';

		$this->__string = $hiddenfield;
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