<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Clients extends ActiveRecord {

    protected $table_name = 'clients';

    private $attributes = [
        'name',
        'cpf_cnpj',
        'birth_date',
        'gender',
        'whatsapp',
        'phone',
        'email',
        'password',
        'address',
        'complement',
        'neighborhood',
        'city',
        'state',
        'zip_code',
        'status',
        'created_at'
    ];


    public function getAttributes() {
        return $this->attributes;
    }

    private function getRules() {
        return [
            'name'          => 'required|maxLength:255',
            'cpf_cnpj'      => 'required|maxLength:255|CpfOrCnpj',
            'birth_date'    => 'required|maxLength:100|date',
            'gender'        => 'required|maxLength:10|in:Masculino,Feminino',
            'whatsapp'      => 'required|PhoneNumber',
            'phone'         => 'required|PhoneNumber',
            'email'         => 'required|Email',
            'address'       => 'required|maxLength:255',
            'complement'    => 'required|maxLength:255',
            'neighborhood'  => 'required|maxLength:255',
            'city'          => 'required|maxLength:255',
            'state'         => 'required|maxLength:255',
            'zip_code'      => 'required|maxLength:255'
        ];
    }

    private function getPasswordRules() {
        return [
            'password' => 'required|alphaDash|confirmed:confirm|minLength:3|maxLength:50',
            'confirm' => 'required|alphaDash|confirmed:confirm|minLength:3|maxLength:50'
        ];
    }

    public function getNames() {
        return [
            'name'          => 'Nome Completo',
            'cpf_cnpj'      => 'CPF ou CNPJ',
            'birth_date'    => 'Data de nascimento',
            'gender'        => 'Sexo',
            'whatsapp'      => 'WhatsApp',
            'phone'         => 'Telefone',
            'email'         => 'Email',
            'address'       => 'Endereço',
            'complement'    => 'Complemento',
            'neighborhood'  => 'Bairro',
            'city'          => 'Cidade',
            'state'         => 'Estado',
            'zip_code'      => 'CEP',
            'password'      => 'Senha',
            'confirm'       => 'Confirmar senha',
            'status'        => 'Status'
        ];
    }

    public function validate($data, $mode = 'default') {
        if($mode == 'default') {
            return new Validator($data, $this->getRules(), $this->getNames());
        } else {
            return new Validator($data, $this->getPasswordRules(), $this->getNames());
        }
    }
}