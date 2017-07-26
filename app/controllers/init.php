<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: init
*/

class Init_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Prodígio Framework';
		$this->meta_description = 'Framework MVC simples para montagem de páginas simples com PHP e Mysql';
		$this->meta_keywords = 'Framework, PHP';

		// [Voce pode passar arquivos css para a pagina do seu controller apenas 
		// informando o array como parametro de $this->set_base_css()]

		// chamando css em assets/css
		$this->css_files = $this->set_base_css(['init']);
		
		// chamando css interno dentro da view e concatenando ao css_files
		// $this->css_files .= $this->set_css(['index','home']);
		
		// [Voce pode passar arquivos javascript para ser chamado na view deste  
		// controller apenas passando um array com os nomes dos arquivos sem a 
		// extençao no array em $this->set_base_js]

		// chamada de arquivos js dentro de assets
		$this->js_files = $this->set_base_js(['index','teste']);
		// chamada de arquivos js dentro da veiw 
		// $this->js_files .= $this->set_js(['index','teste']);
	}

	public function index(){
		require_once $this->render('index');
	}

	public function show_routers(){
		global $_ROUTERS;
		require_once $this->render('routers');	
	}

	public function dbrecord(){
		require_once $this->render('dbrecord');	
	}
}