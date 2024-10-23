<?php

namespace App\Controllers;

use core\Controller;
use core\Request;
use core\Router;
use core\SessionManager;
use App\Helpers\Helper;
use App\Models\Clients;

class ClientController extends Controller {

    public function index() {
        $object = new Clients();
        $this->view('client/index', [
            'title' => 'Clientes',
            'subtitle' => 'Listagem dos clientes',
            'data' => $object->findAll(),
            'new' => '/dashboard/cliente/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Clientes' => '/dashboard/clientes'
            ]
        ]); 
    }

    public function create() {
        $helper = new Helper();
        $this->view('client/new', [
            'title' => 'Clientes',
            'subtitle' => 'Cadastro de clientes',
            'button' => 'Cadastrar',
            'path' => '/dashboard/cliente/salvar',
            'backURL' => '/dashboard/clientes',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Clientes' => '/dashboard/clientes',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Clients();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('client/edit', [
            'title' => 'Clientes',
            'subtitle' => 'Editar dados do clientes',
            'button' => 'Atualizar',
            'path' => '/dashboard/cliente/'.$data->id.'/atualizar',
            'backURL' => '/dashboard/clientes',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Clientes' => '/dashboard/clientes',
                'Editar' => '#'
            ]
        ]);
    }

    public function password($request) {
        $object = new Clients();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);

        $this->view('client/password', [
            'title' => 'Minha senha',
            'subtitle' => 'Alterar senha do cliente',
            'button' => 'Alterar senha',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Clientes' => '/dashboard/clientes',
                'Senha' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Clients();
        $validate = $object->validate($requestAll);

        if(isset($requestAll['password'])) {
            $validate = $object->validate($requestAll, 'password');
            $requestAll['password'] = $helper->generateHash(Request::get('password'));
        }

        if ($validate->validate()) {
            unset($requestAll['confirm']);
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/cliente/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/cliente/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/cliente/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Clients();
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
                return Router::redirect('/dashboard/cliente/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/cliente/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/cliente/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }

    public function delete($request) {
        $object = new Clients();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/clientes', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/clientes', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }

    public function show() {
        $this->view('client/show');
    }
}