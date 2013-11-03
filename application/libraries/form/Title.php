<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Title { 

	private $style = "";
	private $value = "";
	private $label = "";
	private $id = "";

	protected $CI = null;
	protected $__string = '';

	public function __construct($id="",$label="") {
        $this->CI = & get_instance();
		
		$this->id = $id;
		$this->label = $label;
	}

	public function setLabel($label) {
		$this->label = $label;

		return $this;
	}
	
	public function setId($id = "") {
		$this->id = $id;

		return $this;
	}
	
	public function setStyle($val) {
		$this->style = $val;

		return $this;
	}
	
	protected function generate() {
		$expl = explode(" ",$this->label);
		$first_part = $expl[0];
		$second_part = "";
		for ($i = 1; $i < sizeof($expl) ; $i++) {
			$second_part .= $expl[$i]." ";
		}
		$title = '<h3 class="page-header sub-header">'.$first_part.' <small>'.$second_part.'</small></h3>';

		$this->__string = $title;
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