<?php

namespace App\Controllers;

use core\Router;
use core\Request;
use core\SessionManager;
use core\Controller;
use App\Helpers\Helper;
use App\Models\Fees;

class FeeController extends Controller {

	public function index() {
        $object = new Fees();
        $this->view('fee', [
            'title' => 'Taxas',
            'subtitle' => 'Listagem das taxas',
            'data' => $object->findAll(),
            'new' => '/dashboard/taxa/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Taxas' => '/dashboard/taxas'
            ]
        ]); 
    }

    public function create() {
        $this->view('fee/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar nova taxa no sistema',
            'button' => 'Cadastrar',
            'path' => '/dashboard/taxa/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Taxas' => '/dashboard/taxas',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Fees();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('fee/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados da taxa',
            'button' => 'Atualizar',
            'path' => '/dashboard/taxa/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Taxas' => '/dashboard/taxas',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Fees();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/taxa/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/taxa/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/taxa/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Fees();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/taxa/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/taxa/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/taxa/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Fees();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/taxas', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/taxas', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}