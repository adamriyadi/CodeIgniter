<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Datepicker extends Forminput {

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

			$datepicker = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$datepicker = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$events = 'onchange="$(\'.datepicker\').hide();"';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		
		if ($this->enabled) {
			$datepicker .= '<div class="form-control container"><div class="input-append date input-group">
			<input type="text" id="'.$this->id.'" name="'.$this->id.'" value="'.$this->value.'" '.$style.' '.$events.' '.$readonly.' class="form-control input-sm"  placeholder="dd/mm/yyyy"/><span class="add-on input-group-btn"><button type="button" class="btn btn-sm" style="margin-top:-1px;padding:3px 5px 3px 5px;"><i class="icon-th"></i></button></span>
			</div></div>';
		}
		else {
			$datepicker .= '<input type="text" id="'.$this->id.'" name="'.$this->id.'" value="'.$this->value.'" '.$style.' '.$events.' '.$readonly.' class="form-control input-sm"  />';
		}

		$this->__string = $datepicker;
	}

}