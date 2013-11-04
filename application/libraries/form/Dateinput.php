<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Dateinput extends Forminput {

	public function __construct($id="",$name="",$value="",$label="",$required=false) {
        parent::__construct($id,$name,$value,$label,$required);
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

}