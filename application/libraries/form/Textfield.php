<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Textfield extends Forminput {

	private $maxlength = 255;

	public function __construct($id="",$name="",$value="",$label="",$required=false) {
		parent::__construct($id,$name,$value,$label,$required);
	}

	public function setMaxLength($val) {
		$this->maxlength = $val;

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
}