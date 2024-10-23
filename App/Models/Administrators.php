<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Administrators extends ActiveRecord {

    protected $table_name = 'administrators';

    private $attributes = [
        'fullname',
        'email',
        'password',
        'created_at'
    ];


    public function getAttributes() {
        return $this->attributes;
    }

    private function getRules() {
        return [
            'fullname'           => 'required|maxLength:255',
            'email'              => 'required|maxLength:255'
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
            'fullname'           => 'Nome Completo',
            'email'              => 'Email',
            'password'           => 'Senha',
            'confirm'            => 'Confirmar senha'
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