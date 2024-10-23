<?php

namespace App\Controllers;

use core\SessionManager;
use core\Router;
use core\Request;
use core\Controller;
use App\Helpers\Helper;
use App\Models\Colors;

class ColorController extends Controller {

	public function index() {
        $object = new Colors();
        $this->view('color', [
            'title' => 'Cores',
            'subtitle' => 'Listagem das cores',
            'data' => $object->findAll(),
            'new' => '/dashboard/cor/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Cores' => '/dashboard/cores'
            ]
        ]); 
    }

    public function create() {
        $this->view('color/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar nova cor no sistema',
            'button' => 'Cadastrar',
            'path' => '/dashboard/cor/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Cores' => '/dashboard/cores',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Colors();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('color/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados da cor',
            'button' => 'Atualizar',
            'path' => '/dashboard/cor/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Cores' => '/dashboard/cores',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Colors();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/cor/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/cor/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/cor/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Colors();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/cor/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/cor/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/cor/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Colors();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/cores', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/cores', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}