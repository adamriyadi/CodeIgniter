<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if (!class_exists('Formpanel')) {
	class Formpanel { 
		
		private $form = "formInput1";
		private $action = "";
		private $rows = array();
		private $enabled = true;
		private $disabled_all = false;
		private $submit_label = "Save";
		private $cancel_label = "Cancel";
		private $cancel_action = "";
		private $container_class = "row";
		private $title = "";
		private $target = "";
		private $action_bottom = false;
		protected $CI = null;
		protected $__string = '';

		public function __construct() { 
			$this->CI = & get_instance();
		} 

		public function setTarget($target = "") {
			$this->target = $target;

			return $this;
		}

		public function setEnabled($enabled = true) {
			$this->enabled = $enabled;

			return $this;
		}

		public function setDisabledAll($disabled_all = true) {
			$this->disabled_all = $disabled_all;
			$this->enabled = $enabled;

			return $this;
		}

		public function setActionBottom($action_bottom = false) {
			$this->action_bottom = $action_bottom;

			return $this;
		}

		public function setForm($form = "") {
			$this->form = $form;

			return $this;
		}

		public function setTitle($title = "") {
			$this->title = $title;

			return $this;
		}

		public function setSubmitLabel($submit_label = "") {
			$this->submit_label = $submit_label;

			return $this;
		}

		public function setCancelLabel($cancel_label = "") {
			$this->cancel_label = $cancel_label;

			return $this;
		}

		public function setContainerClass($container_class = "") {
			$this->container_class = $container_class;

			return $this;
		}

		public function getCancelAction() {
			return $this->cancel_action;
		}

		public function setCancelAction($cancel_action = "") {
			$this->cancel_action = $cancel_action;

			return $this;
		}

		public function setAction($action = "") {
			$this->action = $action;

			return $this;
		}

		public function getAction() {
			return $this->action;
		}

		public function setRows($rows = array()) {
			$this->rows = $rows;

			return $this;
		}
		
		public function addRow($row = ""){
			$this->rows[] = $row;

			return $this;
		}
		public function getRows(){
			return $this->rows;
		}

		protected function generateButtons(){
			if ($this->enabled) {
				if ($this->action_bottom) {
					$buttons .= '<div class="row" style="padding-top:20px;">';
					$buttons .= '<div class="col-lg-12">';
					$buttons .= '<button type="submit" id="submit_btn" name="submit_btn" class="btn btn-primary" value="'.$this->submit_label.'"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;'.$this->submit_label.'</button>';
					if ($this->cancel_action == "") {
						$buttons .= '&nbsp;&nbsp;<button type="reset" id="cancel_btn" name="cancel_btn" class="btn btn-default" onclick=\'reset_form("#'.$this->form.'");\' value="'.$this->cancel_label.'"><span class="glyphicon glyphicon-repeat"></span>&nbsp;'.$this->cancel_label.'</button>';
					} else {
						$buttons .= '&nbsp;&nbsp;<button type="button" id="cancel_btn" name="cancel_btn" class="btn btn-default" onclick=\'javascript:'.$this->cancel_action.'\' value="'.$this->cancel_label.'"><span class="glyphicon glyphicon-repeat"></span>&nbsp;'.$this->cancel_label.'</button>';
					}
					$buttons .= '</div>';
					$buttons .= '</div>';
				}
				else {
					$buttons .= '<div class="row" style="margin-top:-20px;">';
					$buttons .= '<div class="col-md-6 col-sm-6">';
					$buttons .= '<h2 class="page-header no-border">'.$this->title.'<small></small></h2>';
					$buttons .= '</div>';
					$buttons .= '<div class="col-md-6 col-sm-6" style="text-align:right;">';
					$buttons .= '<h2 class="page-header no-border">';
					$buttons .= '<div class="btn-group">';
					$buttons .= '<button type="submit" id="submit_btn" name="submit_btn" class="btn btn-primary btn-sm" value="'.$this->submit_label.'"><span class="glyphicon glyphicon-floppy-disk"></span>&nbsp;'.$this->submit_label.'</button>';
				
					if ($this->cancel_action == "") {
						$buttons .= '&nbsp;&nbsp;<button type="reset" id="cancel_btn" name="cancel_btn" class="btn btn-default btn-sm" onclick=\'reset_form("#'.$this->form.'");\' value="'.$this->cancel_label.'"><span class="glyphicon glyphicon-repeat"></span>&nbsp;'.$this->cancel_label.'</button>';
					} else {
						$buttons .= '&nbsp;&nbsp;<button type="button" id="cancel_btn" name="cancel_btn" class="btn btn-default btn-sm" onclick=\'javascript:'.$this->cancel_action.'\' value="'.$this->cancel_label.'"><span class="glyphicon glyphicon-repeat"></span>&nbsp;'.$this->cancel_label.'</button>';
					}
					$buttons .= '</div>';
					$buttons .= '</h2>';
					$buttons .= '</div>';
					$buttons .= '</div>';
					
				}
			}
			
			return $buttons;
		}

		protected function generate(){
			$formpanel = '<div class="'.$this->container_class.'">';
			$action = "#";
			if ($this->action != '') {
				$action = $this->action;
			}
			$target = "";
			if ($this->target != '') {
				$target = ' target="'.$this->target.'" ';
			}

			$formpanel .= '<form id="'.$this->form.'" name="'.$this->form.'" action="'.base_url().$action.'"'.$target.' enctype="multipart/form-data" role="form" method="POST">';
			if (!$this->action_bottom) {
				$formpanel .= $this->generateButtons();
			}

			for ($i = 0; $i < count($this->rows) ; $i++ ) {
				if ($i > 0) {
					$formpanel .= '<div class="row" style="padding-top:10px;">';
				}
				else {
					$formpanel .= '<div class="row">';
				}
				$rows = $this->rows[$i];
				for ($j = 0; $j < count($rows) ; $j++ ) {
					if (!is_array($rows[$j])) {
						$class="col-md-3";
						if ($this->disabled_all) {
							$rows[$j]->setEnabled(false);
						}
						$formpanel .= '<div class="'.$class.'">'.$rows[$j]->toString().'</div>';
					}
					else {
						$class = $rows[$j][1];

						if ($rows[$j][1] == "") {
							$class="col-md-3";
						}
						if ($this->disabled_all) {
							$rows[$j][0]->setEnabled(false);
						}
						$formpanel .= '<div class="'.$class.'">'.$rows[$j][0]->toString().'</div>';
					}
				}

				$formpanel .= '</div>';
			}
			if ($this->action_bottom) {
				$formpanel .= $this->generateButtons();
			}
			$formpanel .= '</form>';
			$formpanel .= '</div>';
			
			$this->__string = $formpanel;
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
}