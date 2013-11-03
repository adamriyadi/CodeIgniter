<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dialoginput { 
	const INPUT_TEXT_FIELD = "1";
	const INPUT_TEXT_AREA = "2"; 

	private $style = "";
	private $value = array();
	private $required = false;
	private $label = "";
	private $id = "";
	private $name = "";
	private $title = "";
	private $target = "";
	private $enabled = true;
	private $input = INPUT_TEXT_FIELD;

	protected $CI = null;
	protected $__string = '';

	public function __construct($id="",$name="",$value=array(),$label="",$required=false) {
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
	
	public function setInput($input){
		$this->input = $input;

		return $this;
	}
	public function setEnabled($enabled) {
		$this->enabled = $enabled;

		return $this;
	}

	public function setTarget($target) {
		$this->target = $target;

		return $this;
	}

	public function setTitle($title) {
		$this->title = $title;

		return $this;
	}

	public function setLabel($label) {
		$this->label = $label;

		return $this;
	}

	public function setValue($value = array()) {
		$this->value = $value;

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
	
	protected function generate() {
		
		if ($this->required) {
			$img_req = base_url()."resources/images/required.gif";
			$cap_req = "Required Field";

			$dialoginput = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$dialoginput = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		$events = 'onchange="$(\'.dialoginput\').hide();"';
		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}
		
		if ($this->target == "") {
			$this->target = "#";
		}
		
		if ($this->enabled) {
			$dialoginput .= '';

			if ($this->input == Dialoginput::INPUT_TEXT_AREA) {
				$dialoginput .= '
				<table width="100%" border="0"><tr><td width="100%"><textarea id="'.$this->id.'_caption" name="'.$this->id.'_caption" value="'.$this->value[1].'" '.$style.' class="form-control input-sm"  readonly="readonly">'.$this->value[1].'</textarea><input type="hidden" id="'.$this->id.'" name="'.$this->id.'" value="'.$this->value[0].'" /></td><td style="vertical-align:top;white-space:nowrap;">
				<button type="button" class="btn btn-sm btn-primary" onclick="$(\'#'.$this->id.'_frame\').attr(\'src\',\''.$this->target.'\');$(\'#'.$this->id.'_dialog\').modal(\'show\');"><i class="glyphicon glyphicon-search"></i>&nbsp;Find ...</button>&nbsp;&nbsp;<button type="button" class="btn btn-sm  btn-default" onclick="$(\'#'.$this->id.'\').val(\'\');$(\'#'.$this->id.'_caption\').val(\'\');"><i class="glyphicon glyphicon-remove"></i>&nbsp;Clear</button></tr></table>';
			}
			else {
				$dialoginput .= '<div class="form-control container"><div class="input-append input-group"><input type="text" id="'.$this->id.'_caption" name="'.$this->id.'_caption" value="'.$this->value[1].'" '.$style.' class="form-control input-sm"  readonly="readonly"/><input type="hidden" id="'.$this->id.'" name="'.$this->id.'" value="'.$this->value[0].'" /><span class="add-on input-group-btn"><button type="button" class="btn btn-sm" style="margin-top:-1px;padding:3px 5px 3px 5px;" onclick="$(\'#'.$this->id.'_frame\').attr(\'src\',\''.$this->target.'\');$(\'#'.$this->id.'_dialog\').modal(\'show\');"><i class="glyphicon glyphicon-search"></i></button><button type="button" class="btn btn-sm" style="margin-top:-1px;padding:3px 5px 3px 5px;" onclick="$(\'#'.$this->id.'\').val(\'\');$(\'#'.$this->id.'_caption\').val(\'\');"><i class="glyphicon glyphicon-remove"></i></button></span></div></div>';
			}
			
			if ($this->title == "") {
				$this->title = "&nbsp;";
			}
			$dialoginput .= '<div class="modal fade" id="'.$this->id.'_dialog" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
			  <div class="modal-dialog" style="width:800px;">
				<div class="modal-content">
				  <div class="modal-header">
					<button type="button" class="close white" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title">'.$this->title.'</h4>
				  </div>
				  <div class="modal-body" style="width:100%;padding:0px;">
						<iframe id="'.$this->id.'_frame" width="100%" height="350" src="#" frameborder=0></iframe>
				  </div>
				  <div class="modal-footer">
					<button id="'.$this->id.'_dismiss" type="button" class="btn btn-default" data-dismiss="modal"><span class="glyphicon glyphicon-remove"></span>&nbsp;Close</button>
				  </div>
				</div>
			  </div>
			</div>';
			$dialoginput .= '<script>document.set_'.$this->id.'_value = function set_'.$this->id.'_value(id, nama) {
					$(\'#'.$this->id.'\').val(id);
					$(\'#'.$this->id.'_caption\').val(nama);
					$(\'#'.$this->id.'_dialog\').modal(\'hide\');
				}
				</script>';	
		}
		else {
			$dialoginput .= '<input type="text" id="'.$this->id.'_caption" name="'.$this->id.'_caption" value="'.$this->value[1].'" '.$style.' class="form-control input-sm"  readonly="readonly"/>
			<input type="hidden" id="'.$this->id.'" name="'.$this->id.'" value="'.$this->value[0].'" />';
		}

		$this->__string = $dialoginput;
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