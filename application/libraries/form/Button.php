<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Button extends Forminput {

	private $className = "btn-default";
	private $icon = "";

	public function __construct($id="",$name="",$label="",$value="",$className = "btn-default") {
        parent::__construct($id,$name,$value,$label,$required);
	}

	public function setIcon($icon = '') {
		$this->icon = $icon;

		return $this;
	}
	
	public function setClassName($className) {
		$this->className = $className;

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
}