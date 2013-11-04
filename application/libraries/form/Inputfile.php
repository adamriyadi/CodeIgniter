<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Inputfile extends Forminput {

	public function __construct($id="",$name="",$value="",$label="",$required=false) {
		parent::__construct($id,$name,$value,$label,$required);
	}

	protected function generate() {
		
		$readonly = "";
		if (!$this->enabled) {
			$readonly = " disabled='true' ";
		}
		
		if ($this->required) {
			$img_req = base_url()."resources/images/required.gif";
			$cap_req = "Required Field";

			$inputfile = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$inputfile = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$events = '';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		if (!$this->enabled) {
			$inputfile .= '<input type="text" class="form-control input-sm" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" readonly="true" '.$style.' '.$events.'/>';
		}
		else {
			$inputfile .= '<div class="form-control container"><input type="file" class="filestyle" data-classInput="form-control inline input-sm" data-classButton="btn btn-default btn-sm" data-buttonText="Browse..." id="'.$this->id.'" name="'.$this->name.'" '.$style.' '.$events.'/></div>';
		}
		$this->__string = $inputfile;
	}
}