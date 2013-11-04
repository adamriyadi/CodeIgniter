<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require_once(APPPATH.'libraries/form/Forminput.php'); // contains some logic applicable only to `admin` controllers

class Hiddenfield extends Forminput { 

	public function Hiddenfield($id="",$name="",$value="") {
		parent::__construct($id,$name,$value,"","");
	}
	
	protected function generate() {
		
		
		$hiddenfield .= '<input type="hidden" id="'.$this->id.'" name="'.$this->name.'" value="'.$this->value.'" />';

		$this->__string = $hiddenfield;
	}
}