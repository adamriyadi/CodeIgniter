<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dateinput { 

	private $style = "";
	private $value = "";
	private $required = false;
	private $label = "";
	private $id = "";
	private $name = "";
	private $enabled = true;
	private $events = array();

	protected $CI = null;
	protected $__string = '';

	public function __construct($id="",$name="",$value="",$label="",$required=false) {
        $this->CI = & get_instance();
		
		$this->id = $id;
		$this->name = $name;
		if ($this->name == "") {
			$this->name = $id;
		}
		$this->value = $value;
		$this->label = $label;
		$this->required = $required;
	}

	public function setEnabled($enabled = true) {
		$this->enabled = $enabled;

		return $this;
	}

	public function setLabel($label) {
		$this->label = $label;

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
	
	public function setStyle($val) {
		$this->style = $val;

		return $this;
	}
	
	public function addEvent($event, $action) {
		$this->events[$event] = $action;

		return $this;
	}
	
	protected function generate() {
		
		$readonly = "";
		if (!$this->enabled) {
			$readonly = " readonly='true' ";
		}
		
		if ($this->required) {
			$img_req = base_url()."resources/images/required.gif";
			$cap_req = "Required Field";

			$dateinput = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$dateinput = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$events = 'onchange="$(\'.datepicker\').hide();"';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}

		$dateinput .= '<input type="text" id="'.$this->id.'" name="'.$this->id.'" value="'.$this->value.'" '.$style.' '.$events.' '.$readonly.' class="form-control input-sm date" placeholder="dd/mm/yyyy" />';

		$this->__string = $dateinput;
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