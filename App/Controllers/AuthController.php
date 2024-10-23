<?php

namespace App\Controllers;

use core\Controller;
use core\Router;
use core\Authorizer;
use App\Models\Administrators;
use core\SessionManager;

class AuthController extends Controller {

	public function auth() {
        $users = new Administrators();
        if(Authorizer::authorize($users->findAll())) {
            Router::redirect('/dashboard');
        } else {
            Router::redirect('/login', [
                'errors' => 'Usuário ou senha incorretos.'
            ]);
        }
	}

    public function logout() {
        SessionManager::destroy();
        Router::redirect('/login', [
            'messages' => 'Você saiu do paindel administradir.'
        ]);
    }
}