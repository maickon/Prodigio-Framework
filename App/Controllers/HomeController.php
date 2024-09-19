<?php

namespace App\Controllers;

use core\Controller;
use core\TemplateTags;
use core\Request;
use core\Router;

class HomeController extends Controller {

	public function index() {
		$this->view('home', [
			'html' => new TemplateTags()
		]);	
	}

	public function docs() {
		$this->view('docs', [
			'html' => new TemplateTags()
		]);	
	}

	public function config() {
		$this->view('home/config');	
	}

	public function saveConfig() {
		$request = new Request();
		if($request->all()) {
			$host = $request->get('host');
			$port = $request->get('port');
			$user = $request->get('user');
			$password = $request->get('password');
			$database = $request->get('database');

			$config = [
				'host' => $host,
				'port' => $port,
				'user' => $user,
				'password' => $password,
				'database' => $database
			];

			$jsonConfig = json_encode($config, JSON_PRETTY_PRINT);
			$configPath = __DIR__ . '/../Temp/files/config.json';

			if (file_put_contents($configPath, $jsonConfig) !== false) {
				Router::redirect('/home/config', ['message' => 'Configuração salva com sucesso!']);
			} else {
				Router::redirect('/home/config', ['error' => 'Erro ao salvar a configuração.']);
			}
		} else {
			Router::redirect('/home/config', ['error' => 'Nenhum dado de configuração recebido.']);
		}
	}
}