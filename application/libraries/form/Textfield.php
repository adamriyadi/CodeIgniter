<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Textfield { 

	private $maxlength = 255;
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

	public function setMaxLength($val) {
		$this->maxlength = $val;

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

			$textfield = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$textfield = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$events = '';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		$textfield .= '<input type="text" class="form-control input-sm" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" '.$readonly.' '.$style.' '.$events.'/>';

		$this->__string = $textfield;
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