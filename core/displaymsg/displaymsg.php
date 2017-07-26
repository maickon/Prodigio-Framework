<?php
class Displaymsg_Core{
	
	function msg($query){

		$methods = ['success', 'info', 'warning', 'danger'];
		$options = ['create', 'update', 'erro'];

		$method = key($query);
		if (in_array($method, $methods) and in_array($query[$method], $options)) {
			$option = $query[$method];
			return $this->$method($option);
		} else {
			return '';
		}
	}

	function success($option){
		$msg = [
			'create' => 'Dados cadastrados.',
			'update' => 'Dados atualizados'
		];

		$alert = '
		<div data-notify="container" class="alert col-xs-12 col-sm-12 col-md-12 alert alert-success alert-with-icon animated fadeInDown" role="alert" data-notify-position="top-center">
			<button type="button" aria-hidden="true" class="close" data-dismiss="alert" style="position: absolute; right: 10px; top: 50%; margin-top: -13px; z-index: 1033;">×</button>

			<span data-notify="icon" class="pe-7s-check"></span> 
			<span data-notify="title">Sucesso</span> 
			<span data-notify="message">'.$msg[$option].'</span>
		</div>';
		return $alert;
	}

	function info($option){
		$msg = [
			'create' => 'Dados cadastrados.',
			'update' => 'Dados atualizados'
		];
		$alert = '
		<div data-notify="container" class="alert col-xs-12 col-sm-12 col-md-12 alert alert-info alert-with-icon animated fadeInDown" role="alert" data-notify-position="top-center">
			<button type="button" aria-hidden="true" class="close" data-dismiss="alert" style="position: absolute; right: 10px; top: 50%; margin-top: -13px; z-index: 1033;">×</button>

			<span data-notify="icon" class="pe-7s-info"></span> 
			<span data-notify="title">Informativo</span> 
			<span data-notify="message">'.$msg[$option].'</span>
		</div>';
		return $alert;
	}

	function warning($option){
		$msg = [
			'create' => 'Dados cadastrados.',
			'update' => 'Dados atualizados'
		];
		$alert = '
		<div data-notify="container" class="alert col-xs-12 col-sm-12 col-md-12 alert alert-warning alert-with-icon animated fadeInDown" role="alert" data-notify-position="top-center">
			<button type="button" aria-hidden="true" class="close" data-dismiss="alert" style="position: absolute; right: 10px; top: 50%; margin-top: -13px; z-index: 1033;">×</button>

			<span data-notify="icon" class="pe-7s-attention"></span> 
			<span data-notify="title">Atenção!</span> 
			<span data-notify="message">'.$msg[$option].'</span>
		</div>';
		return $alert;
	}

	function danger($option){
		$msg = [
			'erro' => 'Um erro ocorreu.',
			'update' => 'Dados atualizados'
		];
		$alert = '
		<div data-notify="container" class="alert col-xs-12 col-sm-12 col-md-12 alert alert-danger alert-with-icon animated fadeInDown" role="alert" data-notify-position="top-center">
			<button type="button" aria-hidden="true" class="close" data-dismiss="alert" style="position: absolute; right: 10px; top: 50%; margin-top: -13px; z-index: 1033;">×</button>

			<span data-notify="icon" class="pe-7s-close-circle"></span> 
			<span data-notify="title">Atenção!</span> 
			<span data-notify="message">'.$msg[$option].'</span>
		</div>';
		return $alert;
	}
}