<?php

namespace App\Controllers;

use core\Controller;
use core\ActiveRecord;
use core\Request;
use core\Debug;
use core\SessionManager;
use core\TemplateTags;

class HomeController extends Controller {

	public function index() {
		$this->view('home', [
			'header' => $this->header()
		]);	
	}

	private function header() {
		$html = new TemplateTags();
		$html->header();
			$html->h1();
				$html->b();
					$html->print('P');
				$html->b;
				$html->print('rod');
				$html->b();
					$html->print('í');
				$html->b;
				$html->print('gio ');

				$html->b();
					$html->print('F');
				$html->b;
				$html->print('rame');
				$html->b();
					$html->print('w');
				$html->b;
				$html->print('ork');
				$html->span('class="version"');
					$html->print('V1.2');
				$html->span;
			$html->h1;
			$html->p();
				$html->print('Construa seu próximo projeto com facilidade');
			$html->p;
		$html->header;
	}
}