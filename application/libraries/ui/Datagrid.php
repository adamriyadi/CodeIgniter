<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Datagrid { 
	
	private $actions = null;
	private $headers = array();
	private $fields = array();
	private $query_string = '';
	private $link_action = '';
	private $result_set = null;
	private $model = null;
	private $editable = true;
	private $pagination = true;
	private $primary_key = 'id';
	protected $CI = null;
	protected $__string = '';

    public function __construct() { 
        $this->CI = & get_instance();
    } 

	public function setLinkAction($link_action = "") {
		$this->link_action = $link_action;
		return $this;
	}
	
	public function setPagination($pagination = true){
		$this->pagination = $pagination;

		return $this;
	}
	
	public function setEditable($editable = true){
		$this->editable = $editable;

		return $this;
	}

	public function setPrimaryKey($primary_key = "") {
		$this->primary_key = $primary_key;

		return $this;
	}

	public function setForm($form = "") {
		$this->form = $form;

		return $this;
	}
	
	public function setHeaders($headers = array()) {
		$this->headers = $headers;

		return $this;
	}
	
	public function setFields($fields = array()) {
		$this->fields = $fields;

		return $this;
	}
	
	public function setActions($actions) {
		$this->actions = $actions;

		return $this;
	}
	
	public function setResultSet($result_set) {
		$this->result_set = $result_set;

		return $this;
	}
	
	public function setModel($model) {
		$this->model = $model;

		return $this;
	}
	

	protected function generate(){
		$datagrid = '<div class="btn-toolbar btn-toolbar-padding">';
		if ($this->actions != null && $this->actions != '') {
			if ($this->actions->toString() != '') {
				$datagrid .= $this->actions->toString();
			}
		}
		$datagrid .= '</div>';
		if ($this->actions != null && $this->actions != '') {
			$datagrid .= '<form id="'.$this->actions->getForm().'" name="'.$this->actions->getForm().'" method="POST" action="#">';
		}
		$datagrid .= '<div class="panel panel-default">';
		$datagrid .= '<table class="table table-hover table-striped table-bordered table-condensed">';
		$datagrid .= '<thead>';
		$datagrid .= '<tr class="row_header">';

		if ($this->editable) {
			$datagrid .= '<th scope="col" style="width:50px;text-align:center;">';
			$datagrid .= '<span class="icon-check" id="check_all"></span> <span class="icon-check-empty" id="uncheck_all"></span>';
			$datagrid .= '</th>';
		}
		for ($i = 0; $i < count($this->headers) ; $i++) {
			$datagrid .= '<th scope="col">'.$this->headers[$i].'</th>';
		}
		$datagrid .= '</tr>';
		$datagrid .= '</thead>';
		$datagrid .= '<tbody>';
		
		$counter = 1;
		foreach ($this->result_set as $record) {
			$str = '$pk_value = $record->'.$this->primary_key.';';
			eval($str);
			
			if ($this->link_action != '') {
				$datagrid .= '<tr class="row_data">';
				$toggle_event = ' style="cursor:pointer;" title="Click to view detail record" caption="Click to view detail record" onclick="javascript:location.href=\''.$this->link_action.'?ref='.$pk_value.'\';"';
			}
			else {
				$datagrid .= '<tr class="row_data">';
				$toggle_event = ' onclick="javascript:toggle_check(\'.data_check.row_'.$pk_value.'\');"';
			}
			if ($this->editable) {

				$datagrid .= '<td style="width:50px;text-align:center;">';
				$datagrid .= '<input type="checkbox" class="data_check row_'.$pk_value.'" name="ref_id[]" value="'.$pk_value.'" />';
				$datagrid .= '</td>';
			}
			for ($i = 0; $i < count($this->fields) ; $i++) {
				$align = 'left';
				$prepend = '';
				$append = '';
				if ($this->fields[$i]['align'] != '') {
					$align = $this->fields[$i]['align'];
				}
				if ($this->fields[$i]['prepend'] != '') {
					$prepend = $this->fields[$i]['prepend'];
				}
				if ($this->fields[$i]['append'] != '') {
					$append = $this->fields[$i]['append'];
				}

				$width = '';
				if ($this->fields[$i]['width'] != '') {
					$width = ' width="'.$this->fields[$i]['width'].'"';
				}

				$style = '';
				if ($this->fields[$i]['style'] != '') {
					$style = ' style="'.$this->fields[$i]['style'].'"';
				}
				
				$value = '';
				if ($this->fields[$i]['field'] == 'counter') {
					$value = $counter.'.';
				}
				else {
					$str = '$value=$record->'.$this->fields[$i]['field'].';';
					if ($this->fields[$i]['callback'] != '') {
						$params = "";
						if ($this->fields[$i]['callback_params'] != '') {
							$params = ','.$this->fields[$i]['callback_params'];
						}
						$str = '$value='.$this->fields[$i]['callback'].'($record->'.$this->fields[$i]['field'].''.$params.');';
					}
					eval($str);
				}

				$datagrid .= '<td '.$toggle_event.' align="'.$align.'" '.$width.' '.$style.'>'.$prepend.$value.$append.'</td>';
			}
			$datagrid .= '</tr>';
			$counter++;
		}		
		$datagrid .= '</tbody>';	

		if ($this->pagination) {
			$pagination_links = $this->model->pagination->create_links();
		}
		if ($pagination_links != "") {
			$datagrid .= '<tfoot>';			
			$datagrid .= '<tr>';		
			$datagrid .= '<td colspan="'.(count($this->headers) + 1).'">';	
			$datagrid .= $this->model->pagination->create_links();	
			$datagrid .= '</td>';	
			$datagrid .= '</tr>';	
			$datagrid .= '</tfoot>';
		}
		$datagrid .= '</table>';	
		$datagrid .= '</div>';	
		if ($this->actions != null && $this->actions != '') {
			$datagrid .= '</form>';	
		}
		
		$this->__string = $datagrid;
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