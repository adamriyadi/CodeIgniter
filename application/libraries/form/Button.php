<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Button { 

	private $className = "btn-default";
	private $label = "";
	private $id = "";
	private $name = "";
	private $icon = "";
	private $value = "";
	private $enabled = true;
	private $events = array();

	protected $CI = null;
	protected $__string = '';

	public function __construct($id="",$name="",$label="",$value="",$className = "btn-default") {
        $this->CI = & get_instance();
		
		$this->id = $id;
		$this->name = $name;
		if ($this->name == "") {
			$this->name = $id;
		}
		$this->label = $label;
		$this->value = $value;
		$this->className = $className;
	}

	public function setValue($value = '') {
		$this->value = $value;

		return $this;
	}

	public function setIcon($icon = '') {
		$this->icon = $icon;

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
	
	public function setId($id = "") {
		$this->id = $id;

		return $this;
	}
	
	public function setName($name = "") {
		$this->name = $name;

		return $this;
	}
	
	public function setClassName($className) {
		$this->className = $className;

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
		if ($this->className == '') {
			$this->className = 'btn-default';
		}

		$events = '';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		$icon = '';
		if ($this->icon != '') {
			$icon = $this->icon;
		}
		$button = '<button type="button" id="'.$this->id.'" name="'.$this->name.'" ';
		$button .= 'class="btn btn-sm '.$this->className.'" ';
		$button .= $events;
		$button .= $readonly;
		$button .= '>';
		$button .= $icon.''.$this->label;
		$button .= '</button>';

		$this->__string = $button;
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