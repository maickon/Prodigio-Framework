<?php

namespace App\Controllers;

use core\Controller;
use core\TemplateTags;

class HomeController extends Controller {

	public function index() {
		$this->view('home', [
			'html' => new TemplateTags()
		]);	
	}

	public function docs() {
		$this->view('docs');	
	}
}