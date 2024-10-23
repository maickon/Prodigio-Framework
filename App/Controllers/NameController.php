<?php

namespace App\Controllers;

use core\Router;
use core\Request;
use core\Controller;
use core\SessionManager;
use App\Helpers\Helper;
use App\Models\Names;

class NameController extends Controller {

	public function index() {
        $object = new Names();
        $this->view('name', [
            'title' => 'Nomes',
            'subtitle' => 'Listagem dos nomes de produtos',
            'data' => $object->findAll(),
            'new' => '/dashboard/nome/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Nomes' => '/dashboard/nomes'
            ]
        ]); 
    }

    public function create() {
        $this->view('name/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar novo nome no sistema',
            'button' => 'Cadastrar',
            'path' => '/dashboard/nome/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Nomes' => '/dashboard/nomes',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Names();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('name/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar o nome do produto',
            'button' => 'Atualizar',
            'path' => '/dashboard/nome/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Nomes' => '/dashboard/nomes',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Names();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/nome/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/nome/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/nome/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Names();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/nome/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/nome/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/nome/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Names();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/nomes', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/nomes', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}