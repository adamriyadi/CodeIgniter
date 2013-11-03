<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Actions { 
	const ADD_BUTTON = "1";
	const EDIT_BUTTON = "2"; 
	const DELETE_BUTTON = "3"; 
	const GENERIC_BUTTON = "4";
	
	private $form = "formApps1";
	private $buttons = array();
	private $button_groups = array();
	private $drop_down_action = '';
	private $target = '';
	private $query_string = '';
	private $is_dropdown = false;
	protected $CI = null;
	protected $__string = '';

    public function __construct($form = "formApps1") { 
        $this->CI = & get_instance();
		$this->form = $form;
    } 
	
	public function setForm($form = "") {
		$this->form = $form;

		return $this;
	}
	
	public function getForm() {
		return $this->form;
	}
	
	public function setTarget($target = "", $query_string = "") {
		$this->target = $target;
		$this->query_string = $query_string;

		return $this;
	}
	
	public function addButtonGroup() {
		$count = count($this->button_groups);

		$this->button_groups[$count] = array();

		return $this;
	}

	public function addButton($id = "", $type = "1", $label = "", $is_multiple = true, $js_action = "", $icon = '', $class = '', $title='') {
		$this->is_dropdown = false;
		if ($id == '') {
			$id = 'button_'.count($this->buttons);
		}
		
		$btn_action = '';

		$button = '<button type="button" id="'.$id.'" name="'.$id.'" ';
		if ($type == Actions::ADD_BUTTON) {
			if ($class == '') {
				$class = 'btn-primary';
			}
			$button .= 'class="btn '.$class.'" ';

			$target_link = $this->target.'?act=add&'.$this->query_string;
			$btn_action = ' onclick="javascript:$(\'#'.$this->form.'\').attr(\'action\',\''.$target_link.'\');$(\'#'.$this->form.'\').submit();" ';
			
			if ($icon == '') {
				$icon = '<span class="icon icon-plus"></span>&nbsp;';
			}
		}
		elseif ($type == Actions::EDIT_BUTTON) {
			if ($class == '') {
				$class = 'btn-default';
			}
			$button .= 'class="btn '.$class.' action_btn_single" disabled="true" ';

			$target_link = $this->target.'?act=edit&'.$this->query_string;
			$btn_action = ' onclick="javascript:$(\'#'.$this->form.'\').attr(\'action\',\''.$target_link.'\');$(\'#'.$this->form.'\').submit();" ';

			if ($icon == '') {
				$icon = '<span class="icon icon-edit"></span>&nbsp;';
			}
		}
		elseif ($type == Actions::DELETE_BUTTON) {
			if ($class == '') {
				$class = 'btn-default';
			}
			$button .= 'class="btn '.$class.' action_btn" disabled="true" ';

			$target_link = $this->target.'?act=delete&'.$this->query_string;
			$btn_action = ' onclick="javascript:confirm_dialog(\'Delete Confirmation\',\'Are you sure you want to delete this record ??\',\'No\',\'Yes\',\''.$this->form.'\',\''.$target_link.'\');" ';

			if ($icon == '') {
				$icon = '<span class="icon icon-trash"></span>&nbsp;';
			}
		}
		else {
			if ($class == '') {
				$class = 'btn-default';
			}
			if ($is_multiple) {
				$button .= 'class="btn '.$class.' action_btn" disabled="true" ';
			}
			else {
				$button .= 'class="btn '.$class.' action_btn_single" disabled="true" ';
			}
		}

		if ($js_action != '') {
			$btn_action = ' onclick="javascript:'.$js_action.'" ';
		}

		$button .= $btn_action;
		$button .= '>'.$icon.$label.'</button>';
	
		$count = sizeof($this->button_groups);
		$this->buttons[] = $button;
		if ($count > 0) {
			$this->button_groups[$count - 1][] = $button;
		}
		else {
			$this->button_groups[0][] = $button;
		}

		return $this;
	}
	
	private function __reconstruct_button() {

		$count_group = sizeof($this->button_groups);
		$buttons = $this->button_groups[$count_group - 1];
		$count_buttons = sizeof($buttons);
		$button = $buttons[$count_buttons - 1];
		$split = explode("</button>", $button);
		$prefix = $split[0];
		$button = $prefix.'</button><ul class="dropdown-menu">'.$this->drop_down_action.'</ul></div>';
		$this->button_groups[$count_group - 1][$count_buttons - 1] = $button;
	}
	public function addDivider(){
		if ($this->is_dropdown) {
		
			$drop_down_action = '<li class="divider"></li>';
			$this->drop_down_action .= $drop_down_action;

			$this->__reconstruct_button();
		}

		return $this;
	}
	
	public function addDropdownAction($id = "", $label = "", $icon = "", $js_action = "", $title = ""){
		if ($this->is_dropdown) {
		
			$btn_action = '';
			if ($js_action != '') {
				$btn_action = ' onclick="javascript:'.$js_action.'" ';
			}
			$drop_down_action = '<li><a href="#"'.$btn_action.'>'.$icon.''.$label.'</a></li>';

			$this->drop_down_action .= $drop_down_action;

			$this->__reconstruct_button();
		}

		return $this;
	}

	public function addDropdownButton($id = "", $label = "", $is_multiple = true, $icon = '', $class = '', $title='') {
		$this->is_dropdown = true;
		$this->drop_down_action = '';

		if ($id == '') {
			$id = 'button_'.count($this->buttons);
		}

		$button = '<div class="btn-group btn-group-sm"><button data-toggle="dropdown" type="button" id="'.$id.'" name="'.$id.'" ';
		
		if ($class == '') {
			$class = 'btn-default';
		}
		if ($is_multiple) {
			$button .= 'class="btn '.$class.' action_btn" disabled="true" ';
		}
		else {
			$button .= 'class="btn '.$class.' action_btn_single" disabled="true" ';
		}
		$button .= 'class="btn '.$class.' dropdown-toggle" ';

		$button .= '>'.$icon.$label.' <span class="caret"></span></button></div>';
	
		$count = sizeof($this->button_groups);
		$this->buttons[] = $button;
		if ($count > 0) {
			$this->button_groups[$count - 1][] = $button;
		}
		else {
			$this->button_groups[0][] = $button;
		}

		return $this;
	}

	protected function generate(){
		$object = "";
		for ($c = 0; $c < count($this->button_groups)  ; $c++ ) {
		
			$object .= '<div class="btn-group btn-group-sm" style="padding-top:10px;">';
			
			$buttons = $this->button_groups[$c];
			for ($i = 0; $i < count($buttons) ; $i++) {
				$object .= $buttons[$i];
			}

			$object .= '</div>';	
		}

		$this->__string = $object;
		
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