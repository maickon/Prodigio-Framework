<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Model: home
*/

class Alunos_Model extends Dbrecord_Core {

	private $permit;

	public function __construct(){
		parent::__construct();
		$this->permit = ['id','nome','matricula','descricao','created_at'];
	}

	public function get_permit(){
		return $this->permit;
	}
}