<?php

class Controller_Core{

	public function __construct(){
		$this->name 	= strtolower(str_replace("_Controller", "", get_class($this)));
		$this->css_path	= URL_BASE.'app/views/'.$this->name.'/css/';
		$this->img_path	= URL_BASE.'app/views/'.$this->name.'/img/';
		$this->js_path	= URL_BASE.'app/views/'.$this->name.'/js/';
		$this->trl_file	= URL_BASE.'config/locale/'.$_SESSION['language'].'/'.$this->name.'.trl';
	}

	public function check_session(){
		if (isset($_SESSION['id']) and isset($_SESSION['nome']) and isset($_SESSION['email'])) {
			$user = new Usuarios_Model;
			$where = "id={$_SESSION['id']} and nome='{$_SESSION['nome']}' and email='{$_SESSION['email']}'";
			if ($user->__count('usuarios', $where) == 0) {
				$this->redirect();
			}
		} else {
			$this->redirect();
		}
	}

	public function set_css($css){
		$css_links = '';
		foreach ($css as $value) {
			$css_links .= '<link href="'.$this->css_path.$value.'.css" rel="stylesheet" type="text/css" media="all" />';
		}
		return $css_links;
	}

	public function set_base_css($css){
		$css_links = '';
		foreach ($css as $value) {
			$css_links .= '<link href="'.URL_BASE.'app/assets/css/'.$value.'.css" rel="stylesheet" type="text/css" media="all" />';
		}
		return $css_links;
	}

	public function set_base_js($js){
		$js_links = '';
		foreach ($js as $value) {
			$js_links .= '<script type="text/javascript" src="'.URL_BASE.'app/assets/js/'.$value.'.js"></script>';
		}
		return $js_links;
	}

	public function set_js($js){
		$js_links = '';
		foreach ($js as $value) {
			$js_links .= '<script type="text/javascript" src="'.$this->js_path.$value.'.js"></script>';
		}
		return $js_links;
	}

	public function render($action, $layout = true){
		$this->action = $action;
		if ($layout == true && file_exists('app/views/layout.phtml')) {
			return 'app/views/layout.phtml';
		} else {
			return $this->content();
		}
	}

	public function content(){
		$actual = get_class($this);
		$singleClassName = strtolower(str_replace("_Controller", "", $actual));
		if (file_exists("app/views/{$singleClassName}/{$this->action}.phtml")) {
			return "app/views/{$singleClassName}/{$this->action}.phtml";
		}
	}

	public function load_labels(){
		$actual = get_class($this);
		$class_name = strtolower(str_replace("_Controller", "", $actual));
		$file = file_get_contents("config/locale/{$_SESSION['language']}/{$class_name}.trl");
		$labels = explode("\n",$file);
		foreach ($labels as $key => $value) {
			$text 		= explode("::",$labels[$key]);
			$label 		= strtolower($text[0]);
			$content 	= $text[1];
			$this->$label = $content;
		}
	}

	public function redirect($local = ''){
		header("Location: ".URL_BASE.$local);
	}

    public function error($method){
    	echo '
    	<link rel="stylesheet" href="'.URL_BASE.'/app/assets/css/error.css" />
		<div id="erro">
			<h1 id="erro-title">Erro 404</h1>
			<small id="erro-desc">'.$method.'</small>
			<a id="erro-link" href="javascript:window.history.go(-1)">Voltar</a>
		</div>
    	';
    }
}