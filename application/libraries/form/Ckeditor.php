<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ckeditor { 

	private $value = "";
	private $required = false;
	private $label = "";
	private $id = "";
	private $name = "";
	private $enabled = true;
	private $height = 400;
	private $events = array();

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

	public function setHeight($height) {
		$this->height = $height;

		return $this;
	}

	public function setLabel($label) {
		$this->label = $label;

		return $this;
	}

	public function setValue($value) {
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
	
	public function addEvent($event, $action) {
		$this->events[$event] = $action;

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

			$ckeditor = '<label for="'.$this->id.'"><img src="'.$img_req.'" alt="'.$cap_req.'" title="'.$cap_req.'" height="14" width="7" align="absmiddle">&nbsp;'.$this->label.'</label>';
		}
		else {
			$ckeditor = '<label for="'.$this->id.'">'.$this->label.'</label>';
		}
		
		$style = '';
		if ($this->style != '') {
			$style = ' style="'.$this->style.'"';
		}

		while (list($key,$val) = each($this->events)) {
			$events .= ' '.$key.' = "javascript:'.$val.'"';
			
		}

		$editor_config = array(
			//ID of the textarea that will be replaced
			'id' 	=> 	$this->id,
			//Optionnal values
			'config' => array(
				'toolbar' 	=> 	"Default", 	//Using the Full toolbar
				'width' 	=> 	"100%",	//Setting a custom width
				'height' 	=> 	$this->height.'px',	//Setting a custom height
 
			)
		);

		$ckeditor .= '<textarea id="'.$this->id.'" name="'.$this->name.'" '.$readonly.'>'.$this->value.'</textarea>'.$this->display_ckeditor($editor_config);

		$this->__string = $ckeditor;
	}
	
	public function render(){
		$this->generate();

		echo $this->__string;
	}

	public function toString(){
		$this->generate();

		return $this->__string;
	}

	/**
	 * config_data function.
	 * This function look for extra config data
	 *
	 * @author ronan
	 * @link http://kromack.com/developpement-php/codeigniter/ckeditor-helper-for-codeigniter/comment-page-5/#comment-545
	 * @access public
	 * @param array $data. (default: array())
	 * @return String
	 */
	protected function config_data($data = array())
	{
		$return = '';
		foreach ($data as $key)
		{
			if (is_array($key)) {
				$return .= "[";
				foreach ($key as $string) {
					$return .= "'" . $string . "'";
					if ($string != end(array_values($key))) $return .= ",";
				}
				$return .= "]";
			}
			else {
				$return .= "'".$key."'";
			}
			if ($key != end(array_values($data))) $return .= ",";

		}
		return $return;
	}
	/**
	 * This function displays an instance of CKEditor inside a view
	 * @author Samuel Sanchez 
	 * @access public
	 * @param array $data (default: array())
	 * @return string
	 */
	protected function display_ckeditor($data = array())
	{
		// Initialization
		$return = $this->cke_initialize($data);
		
		// Creating a Ckeditor instance
		$return .= $this->cke_create_instance($data);
		

		// Adding styles values
		if(isset($data['styles'])) {
			
			$return .= "<script type=\"text/javascript\">CKEDITOR.addStylesSet( 'my_styles_" . $data['id'] . "', [";
	   
			
			foreach($data['styles'] as $k=>$v) {
				
				$return .= "{ name : '" . $k . "', element : '" . $v['element'] . "', styles : { ";

				if(isset($v['styles'])) {
					foreach($v['styles'] as $k2=>$v2) {
						
						$return .= "'" . $k2 . "' : '" . $v2 . "'";
						
						if($k2 !== end(array_keys($v['styles']))) {
							 $return .= ",";
						}
					} 
				} 
			
				$return .= '} }';
				
				if($k !== end(array_keys($data['styles']))) {
					$return .= ',';
				}	    	
				

			} 
			
			$return .= ']);';
			
			$return .= "CKEDITOR.instances['" . $data['id'] . "'].config.stylesCombo_stylesSet = 'my_styles_" . $data['id'] . "';
			</script>";		
		}   

		return $return;
	}

	 
	/**
	 * This function create JavaScript instances of CKEditor
	 * @author Samuel Sanchez 
	 * @access private
	 * @param array $data (default: array())
	 * @return string
	 */
	protected function cke_create_instance($data = array()) {
		
		$return = "<script type=\"text/javascript\">
			CKEDITOR.replace('" . $data['id'] . "', {";
		
				//Adding config values
				if(isset($data['config'])) {
					foreach($data['config'] as $k=>$v) {
						
						// Support for extra config parameters
						if (is_array($v)) {
							$return .= $k . " : [";
							$return .= config_data($v);
							$return .= "]";
							
						}
						else {
							$return .= $k . " : '" . $v . "'";
						}

						if($k !== end(array_keys($data['config']))) {
							$return .= ",";
						}		    			
					} 
				}   			
						
		$return .= '});</script>';	
		
		return $return;
		
	}
	
	/**
	 * This function adds once the CKEditor's config vars
	 * @author Samuel Sanchez 
	 * @access private
	 * @param array $data (default: array())
	 * @return string
	 */
	protected function cke_initialize($data = array()) {
		
		$return = '';
		if (sizeof($data) <= 0 || $data['path'] == '') {
			$data['path'] = 'resources/js/ckeditor';
		}
		if(!defined('CI_CKEDITOR_HELPER_LOADED')) {
			
			define('CI_CKEDITOR_HELPER_LOADED', TRUE);
			$return =  '<script type="text/javascript" src="'.base_url(). $data['path'] . '/ckeditor.js"></script>';
			$return .=	"<script type=\"text/javascript\">CKEDITOR_BASEPATH = '" . base_url() . $data['path'] . "/';</script>";
		} 
		
		return $return;
		
	}
}