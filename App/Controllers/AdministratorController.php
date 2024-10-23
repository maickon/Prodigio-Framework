<?php

namespace App\Controllers;

use core\Controller;
use core\SessionManager;
use core\Request;
use core\Router;
use App\Helpers\Helper;
use App\Models\Administrators;

class AdministratorController extends Controller {

	public function index() {
        $object = new Administrators();
		$this->view('admin', [
            'title' => 'Administradores',
            'subtitle' => 'Listagem dos administradores',
            'data' => $object->findAll(),
            'new' => '/dashboard/administrador/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Administradores' => '/dashboard/administradores'
            ]
        ]);	
	}

    public function create() {
        $this->view('admin/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Registrar novo administrador do sistema',
            'button' => 'Cadastrar',
            'path' => '/dashboard/administrador/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Administradores' => '/dashboard/administradores',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Administrators();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('admin/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados do administrador',
            'button' => 'Atualizar',
            'path' => '/dashboard/administrador/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Administradores' => '/dashboard/administradores',
                'Editar' => '#'
            ]
        ]);
    }

    public function password($request) {
        $object = new Administrators();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);

        $this->view('admin/password', [
            'title' => 'Minha senha',
            'subtitle' => 'Alterar senha do administrador',
            'button' => 'Alterar senha',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Administradores' => '/dashboard/administradores',
                'Senha' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Administrators();
        $validate = $object->validate($requestAll);

        if(isset($requestAll['password'])) {
            $validate = $object->validate($requestAll, 'password');
            $requestAll['password'] = $helper->generateHash(Request::get('password'));
        }

        if ($validate->validate()) {
            unset($requestAll['confirm']);
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/administrador/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/administrador/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/administrador/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Administrators();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if(isset($requestAll['password'])) {
            $validate = $object->validate($requestAll, 'password');
            $requestAll['password'] = $helper->generateHash(Request::get('password'));
            $redirect = 'minha-senha';
        }

        if ($validate->validate()) {
            unset($requestAll['confirm']);
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/administrador/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/administrador/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/administrador/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Administrators();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/administradores', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/administradores', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}