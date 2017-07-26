<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: document
*/

class Document_Model extends Dbrecord_Core {
	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','title','descript','created_at'];
	}

	public function get_permit(){
		return $this->permit;
	}
}