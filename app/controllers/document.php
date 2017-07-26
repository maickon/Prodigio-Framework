<?php
/*
	Classe gerada pelo Build_Core 
	@author Maickon Rangel - maickon4developers@gmail.com
	Prodigio Framework - 2017
	Controller: register
*/

class Document_Controller extends Controller_Core {
	function __construct(){
		parent::__construct();
		// setanto os meta dados
		$this->meta_title = 'Documentação - Prodígio Framework';
		$this->meta_description = 'Documentação.';
		$this->meta_keywords = 'Documentação';

		// [Voce pode passar arquivos css para a pagina do seu controller apenas 
		// informando o array como parametro de $this->set_base_css()]

		// chamando css em assets/css
		$this->css_files = $this->set_base_css(['init','bootstrap.min']);
		
		// chamando css interno dentro da view e concatenando ao css_files
		// $this->css_files .= $this->set_css(['index','home']);
		
		// [Voce pode passar arquivos javascript para ser chamado na view deste  
		// controller apenas passando um array com os nomes dos arquivos sem a 
		// extençao no array em $this->set_base_js]

		// chamada de arquivos js dentro de assets
		$this->js_files = $this->set_base_js(['ckeditor/ckeditor']);
		// chamada de arquivos js dentro da veiw 
		// $this->js_files .= $this->set_js(['index','teste']);
	}

	public function index(){
		$this->redirect('document/show');
	}

	public function create(){
		$sumary = (new Document_Model)->find_all();
		require_once $this->render('form');
	}

	public function show($params = 1){
		$document = new Document_Model;
		$show_document = $document->find(intval($params));
		$sumary = (new Document_Model)->find_all();
		require_once $this->render('index');
	}

	public function register(){
		if ($_REQUEST) {
			$document = new Document_Model;
			if (isset($_REQUEST['id'])) {
				if($document->update()){
					$this->redirect('document');
				} 
			} else {
				if($document->save()){
					$this->redirect('document');
				}
			}
		} else {
			$this->redirect('document?error=dangger');
		}
	}

	public function form(){
		require_once $this->render('form');
	}

	public function edit($params){
		$document = (new Document_Model)->find(intval($params));
		require_once $this->render('form');
	}
}