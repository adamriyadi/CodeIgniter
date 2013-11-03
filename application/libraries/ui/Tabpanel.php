<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Tabpanel { 
	
	private $tabs = array();
	private $title = "";
	protected $CI = null;
	protected $__string = '';

    public function __construct() { 
        $this->CI = & get_instance();

		$this->CI->load->helper('string');
    } 

	public function setTabs($tabs = "") {
		$this->tabs = $tabs;

		return $this;
	}
	
	public function addTab($tab){
		$this->tabs[] = $tab;

		return $this;
	}

	protected function generate(){
		$uri_string = $this->CI->uri->uri_string;

		if ($method == "") {
			$method = "index";
		}
		$tabpanel = '<div class="row" style="padding-bottom:25px;">';
		$tabpanel .= '<div class="col-md-12 col-sm-12">';
		$tabpanel .= '<ul class="nav nav-tabs tabpanel">';
		
		$size = count($this->tabs);
		
		$max_tab = 7;
		$max_size = $size;
		if ($max_size > $max_tab) {
			$max_size = $max_tab;
		}
		$active_tab = false;
		for ($i = 0; $i < $max_size; $i++) {
			if ($this->tabs[$i]["method"] == "") {
				$this->tabs[$i]["method"] = "index";
			}
			$URL = $this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"];
			if ($this->tabs[$i]["query_string"] != "") {
				$URL .= '?'.$this->tabs[$i]["query_string"];
			}

			$width = '';
			if ($this->tabs[$i]["width"] != "") {
				$width = ' style="width:'.$this->tabs[$i]["width"].'px;"';
			}
			
			if (starts_with($this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"], $uri_string)
				|| starts_with($this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"], $uri_string."/index")
				|| starts_with($uri_string, $this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"])
				|| starts_with($uri_string."/index", $this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"])) {
				$tabpanel .= '<li class="active"'.$width.'><a href="'.base_url().$URL.'">'.$this->tabs[$i]["name"].'</a></li>';
				$active_tab = true;
			}
			else {
				$tabpanel .= '<li'.$width.'><a href="'.base_url().$URL.'">'.$this->tabs[$i]["name"].'</a></li>';
			}
		}

		if ($size > $max_tab) {
			$class = '';
			if (!$active_tab) {
				$class = ' active';
			}
			$rest = $size - $max_size;
			$tabpanel .= '<li class="dropdown'.$class.'">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown">More ('.$rest.') <b class="caret"></b></a>
				<ul class="dropdown-menu">';
			for ($i = $max_tab; $i < $size; $i++) {
				if ($this->tabs[$i]["method"] == "") {
					$this->tabs[$i]["method"] = "index";
				}
				$URL = $this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"];
				if ($this->tabs[$i]["query_string"] != "") {
					$URL .= '?'.$this->tabs[$i]["query_string"];
				}

				$width = '';
				if ($this->tabs[$i]["width"] != "") {
					$width = ' style="width:'.$this->tabs[$i]["width"].'px;"';
				}
				
				if (starts_with($this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"], $uri_string)
					|| starts_with($this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"], $uri_string."/index")
					|| starts_with($uri_string, $this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"])
					|| starts_with($uri_string."/index", $this->tabs[$i]["controller"].'/'.$this->tabs[$i]["method"])) {
					$tabpanel .= '<li class="active"'.$width.'><a href="'.base_url().$URL.'">'.$this->tabs[$i]["name"].'</a></li>';
				}
				else {
					$tabpanel .= '<li'.$width.'><a href="'.base_url().$URL.'">'.$this->tabs[$i]["name"].'</a></li>';
				}
			}
			$tabpanel .= '</ul></li>';
		}

		$tabpanel .= '</ul>';
		$tabpanel .= '</div>';
		$tabpanel .= '</div>';
		
		$this->__string = $tabpanel;
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