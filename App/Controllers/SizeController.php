<?php

namespace App\Controllers;

use core\Request;
use core\Router;
use core\SessionManager;
use core\Controller;
use App\Helpers\Helper;
use App\Models\Sizes;
use App\Models\Categories;

class SizeController extends Controller {

	public function index() {
        $object = new Sizes();
        $this->view('size', [
            'title' => 'Tamanhos',
            'subtitle' => 'Listagem dos tipos de tamanhos',
            'data' => $object->findAll(),
            'new' => '/dashboard/tamanho/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Tamanhos' => '/dashboard/tamanhos'
            ]
        ]); 
    }

    public function create() {
        $categories = new Categories();
        $this->view('size/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar novo tamanho no sistema',
            'button' => 'Cadastrar',
            'categories' => $categories->findAll(),
            'path' => '/dashboard/tamanho/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Tamanhos' => '/dashboard/tamanhos',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $categories = new Categories();
        $object = new Sizes();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('size/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados do tamanho',
            'button' => 'Atualizar',
            'categories' => $categories->findAll(),
            'path' => '/dashboard/tamanho/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Tamanhos' => '/dashboard/tamanhos',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Sizes();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/tamanho/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/tamanho/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/tamanho/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Sizes();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/tamanho/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/tamanho/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/tamanho/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Sizes();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/tamanhos', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/tamanhos', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}