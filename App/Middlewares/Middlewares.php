<?php

namespace App\Middlewares;

use core\Controller;
use core\ActiveRecord;
use core\Request;
use core\Debug;
use core\SessionManager;
use App\Models\User;

class Middlewares {

	public function hasLogin() {
		if(SessionManager::get('user')) {
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

	public function test1() {
		return true;
	}

	public function test2() {
		return true;
	}
}