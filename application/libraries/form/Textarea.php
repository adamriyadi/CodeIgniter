<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Textarea extends Forminput {

	private $rows = "5";

	public function __construct($id="",$name="",$value="",$label="",$required=false) {
		parent::__construct($id,$name,$value,$label,$required);
	}

	public function setRows($rows = 5) {
		$this->rows = $rows;

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

			$textarea = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$textarea = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$events = '';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		$textarea .= '<textarea class="form-control input-sm" id="'.$this->id.'" name="'.$this->name.'" '.$readonly.' '.$style.' rows="'.$this->rows.'" '.$events.'>'.br2nl($this->value).'</textarea>';

		$this->__string = $textarea;
	}
}