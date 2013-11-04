<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!class_exists('Forminput')) {
	class Forminput { 

		protected $style = "";
		protected $required = false;
		protected $label = "";
		protected $id = "";
		protected $name = "";
		protected $value = "";
		protected $enabled = true;
		protected $events = array();

		protected $CI = null;
		protected $__string = '';

		public function __construct($id="",$name="",$value="",$label="",$required=false) {
			$this->CI = & get_instance();
			
			$this->id = $id;
			$this->name = $name;
			if ($this->name == "") {
				$this->name = $id;
			}
			$this->value = $value;
			$this->label = $label;
			$this->required = $required;
		}

		public function setEnabled($enabled = true) {
			$this->enabled = $enabled;

			return $this;
		}

		public function setValue($value) {
			$this->value = $value;

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
		
		public function setStyle($val) {
			$this->style = $val;

			return $this;
		}
		
		public function addEvent($event, $action) {
			$this->events[$event] = $action;

			return $this;
		}
		
		public function render(){
			$this->generate();

			echo $this->__string;
		}

		public function toString(){
			$this->generate();

			return $this->__string;
		}
		
		protected function generate() {

		}

	}
}