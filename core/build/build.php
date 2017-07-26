<?php

class Build_Core {

	function build_schema($table){
		if (is_object($table)) {
			$table = (array)$table;
		}
		$xml = '<?xml version="1.0" encoding="UTF-8"?>';
		$xml .= "\n<table>\n";
		foreach ($table as $key => $value) {
			$xml .= "\t<{$key}>{$value}</{$key}>\n";
		}
		$xml .= '</table>';
		if(file_put_contents(PATH_BASE."config/db/schema/{$table['table_name']}.xml", $xml)){
			return true;
		} else {
			return false;
		}
	}

	function build_model($table){
		if (is_object($table)) {
			$table = (array)$table;
		}
		$class_name = ucfirst($table['table_name']);
		$file_name 	= strtolower($table['table_name']);
		$year 		= date('Y');
		$file = "<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - {$year}
	Model: {$file_name}
*/

class {$class_name}_Model extends Dbrecord_Core {

}";
		if(file_put_contents(PATH_BASE."app/models/{$file_name}.php", $file)){
			return true;
		} else {
			return false;
		}
	}

	function build_controller($controller){
		if (is_object($controller)) {
			$controller = (array)$controller;
		}
		$file_name 	= $controller['class_name'];
		$class_name = ucfirst($controller['class_name']);
		unset($controller['class_name']);
		$year 		= date('Y');
		$file = "<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - {$year}
	Controller: {$file_name}
*/

class {$class_name}_Controller extends Controller_Core {".'
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = \'Titulo da pagina\';
		$this->meta_description = \'Descricao.\';
		$this->meta_keywords = \'Palavras chave\';

		// [Voce pode passar arquivos css para a pagina do seu controller apenas 
		// informando o array como parametro de $this->set_base_css()]

		// chamando css em assets/css
		// $this->css_files = $this->set_base_css([\'index\',\'home\']);
		
		// chamando css interno dentro da view e concatenando ao css_files
		// $this->css_files .= $this->set_css([\'index\',\'home\']);
		
		// [Voce pode passar arquivos javascript para ser chamado na view deste  
		// controller apenas passando um array com os nomes dos arquivos sem a 
		// extençao no array em $this->set_base_js]

		// chamada de arquivos js dentro de assets
		// $this->js_files = $this->set_base_js([\'index\',\'teste\']);
		// chamada de arquivos js dentro da veiw 
		// $this->js_files .= $this->set_js([\'index\',\'teste\']);
	}
';
		foreach ($controller as $key => $value) {
			$render = 'require_once $this->render(\''.$key.'\');';
			$file .= "
	public function {$value}{
		{$render}
	}
	";
		}
		$file .="
}";
		if(file_put_contents(PATH_BASE."app/controllers/{$file_name}.php", $file)){
			return true;
		} else {
			return false;
		}
	}

	function build_view($views, $file_name){
		$file_name 	= strtolower($file_name);
		$year 		= date('Y');
		$file = "<!--  
	Arquivo gerado pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - {$year}
	View: {$file_name}
-->
<h1>View: {$file_name}</h1>";
		if (!file_exists(PATH_BASE."app/views/{$file_name}")) {
			mkdir(PATH_BASE."app/views/{$file_name}");
		}
		$check = false;
		foreach ($views as $key => $value) {
			if(file_put_contents(PATH_BASE."app/views/{$file_name}/{$value}.phtml", $file)){
				$check = true;
			} else {
				return false;
			}
		}
		return $check;
	}

	function build_form($form){
		if (is_object($form)) {
			$form = (array)$form;
		}
		$class_name = ucfirst($form['form_name']);
		$folder_name 	= strtolower($form['form_name']);
		$file_name 	= strtolower($form['file_name']);
		$year 		= date('Y');
		$file = "
<!--
	Formulário gerado pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - {$year}
	View: {$file_name}
-->
	<div class=\"row\">
		<div class=\"col-md-12\">
	";
		foreach ($form as $key => $value) {
			if ($value == 'select') {
				$file .= "
			<span>".ucfirst($key)."</span>
			<{$value} name=\"{$key}\" id=\"{$key}\" class=\"form-control\" placeholder=\"{$key}\">
				<option value=\"\">Selecione</option>
			</{$value}>";
			} elseif ($value == 'textarea'){
				$file .= "
			<span>".ucfirst($key)."</span>
			<{$value} name=\"$key\" id=\"$key\" class=\"form-control\" placeholder=\"{$key}\"></{$value}>";
			} elseif ($value == 'text') {
				$file .= "
			<span>".ucfirst($key)."</span>
			<input type=\"{$value}\" name=\"$key\" id=\"$key\" class=\"form-control\" placeholder=\"{$key}\">";
			}
		}
		$file .= "

		</div>
	</div>";

		if(file_put_contents(PATH_BASE."app/views/{$folder_name}/{$file_name}.php", $file)){
			return true;
		} else {
			return false;
		}
	}
}