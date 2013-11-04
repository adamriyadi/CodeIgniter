<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends Public_Controller {
	
	function __construct(){
		parent::__construct();
	}

	public function index()
	{
		
		$textfield = new Textfield("id1","id1","Test 1","Test 1");
		$datepicker = new Datepicker("id2","id2","Test 2","Test 2");
		$hiddenfield = new Hiddenfield("id3","id3","Test 3");
		$ckeditor = new Ckeditor("id4","id4","Test 4","Test 4");
		$ckeditor->setHeight(200);
		
		$dialoginput = new Dialoginput('id5','id5',array("key","input value"),'Test 5');
		$dialoginput->setTitle("Select one")->setTarget(base_url()."master/pengawas/find");
		$dialoginput->setInput(Dialoginput::INPUT_TEXT_AREA);
		$dialoginput->setStyle("height:200px");

		$combobox = new Combobox("id6","id6","6","Test 6");
		$combobox->addOption(array("1","Test 1"))
				->addOption(array("2","Test 2"))
				->addOption(array("3","Test 3"))
				->addOption(array("4","Test 4"))
				->addOption(array("5","Test 5"))
				->addOption(array("6","Test 6"))
				->addOption(array("7","Test 7"))
				->addEvent("onchange","alert(this.value)");
		$textarea = new Textarea("id7","id7","Test 7","Test 7");
		$inputfile = new Inputfile("id8","id8","Test 8","Test 8");
		$dateinput = new Dateinput("id9","id9","Test 9","Test 9");
		$button = new Button("id10","id10","Test 10","Test 10");

		$data["session"] = $this->session;
		$data["textfield"] = $textfield;
		$data["datepicker"] = $datepicker;
		$data["hiddenfield"] = $hiddenfield;
		$data["ckeditor"] = $ckeditor;
		$data["dialoginput"] = $dialoginput;
		$data["combobox"] = $combobox;
		$data["textarea"] = $textarea;
		$data["inputfile"] = $inputfile;
		$data["dateinput"] = $dateinput;
		$data["button"] = $button;
		
		$data["is_home"] = "1";
		$this->template->write_view('header', 'header', $data, true);
		
		$this->template->write_view('content', 'home', $data, true);

		$this->template->render();
	}
}