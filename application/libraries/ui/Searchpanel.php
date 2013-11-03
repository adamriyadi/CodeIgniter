<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require(APPPATH.'libraries/ui/Formpanel.php'); // contains some logic applicable only to `admin` controllers

class Searchpanel extends Formpanel { 
	
	private $form = "formSearch";

    public function __construct() { 
		parent::__construct();
        $this->CI = & get_instance();
		$this->submit_label = "Search";
		$this->cancel_label = "Reset";
		$this->container_class = "row well";
    } 

	protected function generateButtons(){
		$buttons .= '<div class="row" style="padding-top:10px;">';
		$buttons .= '<div class="col-lg-12">';
		$buttons .= '<button type="submit" class="btn btn-sm btn-default"><span class="glyphicon glyphicon-search"></span>&nbsp;'.$this->submit_label.'</button>';
		if ($this->getCancelAction() == "") {
			$buttons .= '&nbsp;&nbsp;<button type="reset" class="btn btn-sm btn-default" onclick=\'reset_form("#'.$this->form.'");\'><span class="glyphicon glyphicon-repeat"></span>&nbsp;'.$this->cancel_label.'</button>';
		} else {
			$buttons .= '&nbsp;&nbsp;<button type="reset" class="btn btn-sm btn-default" onclick=\'javascript:'.$this->getCancelAction().'\'><span class="glyphicon glyphicon-repeat"></span>&nbsp;'.$this->cancel_label.'</button>';
		}
		$buttons .= '</div>';
		$buttons .= '</div>';
		
		return $buttons;
	}

	protected function generate(){
		$formpanel = '<div class="'.$this->container_class.'">';
		$action = "#";
		if ($this->getAction() != '') {
			$action = $this->getAction();
		}

		$formpanel .= '<form id="'.$this->form.'" name="'.$this->form.'" action="'.base_url().$action.'" role="form" method="POST">';
		
		$__rows = $this->getRows();
		for ($i = 0; $i < count($__rows) ; $i++ ) {
			if ($i > 0) {
				$formpanel .= '<div class="row" style="padding-top:10px;">';
			}
			else {
				$formpanel .= '<div class="row">';
			}
			$rows = $__rows[$i];
			for ($j = 0; $j < count($rows) ; $j++ ) {
				if (!is_array($rows[$j])) {
					$class="col-md-3";
					$formpanel .= '<div class="'.$class.'">'.$rows[$j]->toString().'</div>';
				}
				else {
					$class = $rows[$j][1];

					if ($rows[$j][1] == "") {
						$class="col-md-3";
					}
					$formpanel .= '<div class="'.$class.'">'.$rows[$j][0]->toString().'</div>';
				}
			}

			$formpanel .= '</div>';
		}
		$formpanel .= $this->generateButtons();
		$formpanel .= '</form>';
		$formpanel .= '</div>';
		
		$this->__string = $formpanel;
	}
}