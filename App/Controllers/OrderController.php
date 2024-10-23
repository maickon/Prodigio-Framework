<?php

namespace App\Controllers;

use core\Router;
use core\Controller;
use core\SessionManager;
use core\Request;
use App\Helpers\Helper;
use App\Models\Orders;

class OrderController extends Controller {

	public function index() {
        $object = new Orders();
        $this->view('order', [
            'title' => 'Pedidos',
            'subtitle' => 'Listagem dos pedidos',
            'data' => $object->findAll(),
            'new' => '/dashboard/pedido/novo',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Pedidos' => '/dashboard/pedidos'
            ]
        ]); 
    }

    public function create() {
        $this->view('order/new', [
            'title' => 'Cadastro',
            'subtitle' => 'Cadastrar novo tamanho no sistema',
            'button' => 'Cadastrar',
            'path' => '/dashboard/pedido/salvar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Pedidos' => '/dashboard/pedidos',
                'Novo' => '#'
            ]
        ]);
    }

    public function edit($request) {
        $object = new Orders();
        $data = $object->find($request['id']);
        SessionManager::flash('formdata', $data);
        $this->view('order/edit', [
            'title' => 'Editar',
            'subtitle' => 'Alterar dados do pedido',
            'button' => 'Atualizar',
            'path' => '/dashboard/pedido/'.$data->id.'/atualizar',
            'breadcrumb' => [
                'Dashboard' => '/dashboard',
                'Pedidos' => '/dashboard/pedidos',
                'Editar' => '#'
            ]
        ]);
    }

    public function save() {
        $helper = new Helper();
        $requestAll = Request::all();
        $object = new Orders();
        $validate = $object->validate($requestAll);

        if ($validate->validate()) {
            if($object->insert($requestAll)) {
                return Router::redirect('/dashboard/pedido/novo', [
                    'success' => 'Novo registro criado com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/pedido/novo', [
                    'errors' => 'Erro! Dados não foram salvos com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/pedido/novo', $flashMessage, $fixMessage);     
        }
    }

    public function update($request) {
        $helper = new Helper();
        $object = new Orders();
        $data = $object->find($request['id']);
        $requestAll = Request::all();
        $validate = $object->validate($requestAll);
        $redirect = 'editar';

        if ($validate->validate()) {
            if($object->update($data->id, $requestAll)) {
                return Router::redirect('/dashboard/pedido/'.$data->id.'/'.$redirect, [
                    'success' => 'Dados atualizados com sucesso!'
                ]);
            } else {
                return Router::redirect('/dashboard/pedido/'.$data->id.'/'.$redirect, [
                    'errors' => 'Erro! Dados não foram atualizados com sucesso!'
                ]);
            }
        } else {
            $flashMessage = ['errors' => $validate->getErrors()];
            $fixMessage = ['formdata' => $requestAll];
            Router::redirect('/dashboard/pedido/'.$data->id.'/'.$redirect, $flashMessage, $fixMessage);     
        }
    }


    public function delete($request) {
        $object = new Orders();
        $data = $object->find($request['id']);
        if($object->delete($data->id)) {
            return Router::redirect('/dashboard/pedidos', [
                'success' => 'Registro excluído com sucesso!'
            ]);
        } else {
            return Router::redirect('/dashboard/pedidos', [
                'success' => 'Registro não pode ser excluído com sucesso!'
            ]);
        }
    }
}