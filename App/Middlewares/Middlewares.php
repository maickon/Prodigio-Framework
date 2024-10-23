<?php

namespace App\Middlewares;

use core\Controller;
use core\ActiveRecord;
use core\Request;
use core\Debug;
use core\SessionManager;
use core\Authorizer;

class Middlewares {

	public function hasLogin() {
		if(Authorizer::auth('user')) {
			return true;
		} else {
			return false;
		}
	}

	public function isAdmin() {
		$session = SessionManager::get('user');
		if($session) {
			if($session['role'] == 'super_admin') {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
}