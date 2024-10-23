<?php

namespace App\Controllers;

use core\SessionManager;
use core\Router;
use core\Request;
use core\Controller;
use App\Models\Categories;

class CategoryController extends Controller {

	public function index() {
        $object = new Categories();
        $this->view('category', [
            'title' => 'Categorias',
            'subtitle' => 'Listagem das categorias',
            'data' => $object->findAll(),
            'new' => '/dashboard/categoria/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Categorias' => '/dashboard/categorias'
            ]
        ]); 
    }

    public function create() {
        $this->view('category/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar nova categoria no sistema',
            'button' => 'Cadastrar',
            'path' => '/dashboard/categoria/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Categorias' => '/dashboard/categorias',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Categories();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('category/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados da categoria',
            'button' => 'Atualizar',
            'path' => '/dashboard/categoria/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Categorias' => '/dashboard/categorias',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $requestAll = Request::all();
        $object = new Categories();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/categoria/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/categoria/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/categoria/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $object = new Categories();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/categoria/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/categoria/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/categoria/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Categories();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/categorias', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/categorias', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}