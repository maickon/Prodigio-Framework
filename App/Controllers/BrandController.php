<?php

namespace App\Controllers;

use core\Request;
use core\Router;
use core\Controller;
use core\SessionManager;
use App\Helpers\Helper;
use App\Models\Brands;
use App\Models\Fees;

class BrandController extends Controller {

	public function index() {
        $object = new Brands();
        $this->view('brand', [
            'title' => 'Marcas',
            'subtitle' => 'Listagem dos tipos de marcas',
            'data' => $object->findAll(),
            'new' => '/dashboard/marca/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Marcas' => '/dashboard/marcas'
            ]
        ]); 
    }

    public function create() {
        $fees = new Fees();
        $this->view('brand/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar nova marca no sistema',
            'button' => 'Cadastrar',
            'fees' => $fees->findAll(),
            'path' => '/dashboard/marca/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Marcas' => '/dashboard/marcas',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $fees = new Fees();
        $object = new Brands();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('brand/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados da marca',
            'button' => 'Atualizar',
            'fees' => $fees->findAll(),
            'path' => '/dashboard/marca/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Marcas' => '/dashboard/marcas',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Brands();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/marca/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/marca/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/marca/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Brands();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/marca/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/marca/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/marca/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Brands();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/marcas', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/marcas', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}