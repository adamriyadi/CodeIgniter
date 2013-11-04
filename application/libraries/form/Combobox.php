<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Combobox extends Forminput { 

	private $options = array();
	private $multiple = false;
	private $size = 5;

	public function __construct($id="",$name="",$value="",$label="",$required=false) {
		parent::__construct($id,$name,$value,$label,$required);
	}

	public function setSize($size = 5) {
		$this->size = $size;

		return $this;
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

		$multiple = '';
		$size = '';
		$style = '';
		if ($this->multiple) {
			$multiple = ' multiple="true" ';
			$size = ' size="'.$this->size.'" ';
			$this->style = 'height:'.(16 * ($this->size + 1)).'px;';
		}
		
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
		$combobox .= '<select class="form-control input-sm" id="'.$this->id.'" name="'.$this->name.'" '.$readonly.' '.$style.' '.$events.''.$multiple.''.$size.'>'.$options.'</select><script>document.getElementById("'.$this->id.'").value="'.$this->value.'";</script>';

		$this->__string = $combobox;
	}
}