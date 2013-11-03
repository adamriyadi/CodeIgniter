<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Combobox { 

	private $options = array();
	private $multiple = false;
	private $size = "";
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

	public function setOptions($options = array()) {
		$this->options = $options;

		return $this;
	}

	public function addOption($option = array()) {
		$this->options[] = $option;

		return $this;
	}

	public function setMultiple($multiple = true) {
		$this->multiple = $multiple;

		return $this;
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

	public function setSelected($value) {
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
			$readonly = " disabled='true' ";
		}
		
		if ($this->required) {
			$img_req = base_url()."resources/images/required.gif";
			$cap_req = "Required Field";

			$combobox = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$combobox = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$options = '';
		for ($i = 0; $i < count($this->options) ; $i++) {
			$options .= '<option value="'.$this->options[$i][0].'" ';
			if (trim($this->options[$i][0]) == $this->value) {
				$options .= ' selected="selected"';
			}
			$options .= ' >'.$this->options[$i][1].'</option>';
		}

		$events = '';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		$combobox .= '<select class="form-control input-sm" id="'.$this->id.'" name="'.$this->name.'" '.$readonly.' '.$style.' '.$events.'>'.$options.'</select><script>document.getElementById("'.$this->id.'").value="'.$this->value.'";</script>';

		$this->__string = $combobox;
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