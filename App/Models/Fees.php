<?php 

namespace App\Models;

use core\ActiveRecord;
use core\Validator;

Class Fees extends ActiveRecord {

    protected $table_name = 'fees';

    private $attributes = [
        'name',
        'cnpj_fee',
        'icms_fee',
        'advisory_fee',
        'created_at'
    ];


    public function getAttributes() {
        return $this->attributes;
    }

    private function getRules() {
        return [
            'name'          => 'required|maxLength:255',
            'cnpj_fee'      => 'percentage',
            'icms_fee'      => 'percentage',
            'advisory_fee'  => 'percentage',
        ];
    }

    public function getNames() {
        return [
            'name'          => 'Nome',
            'cnpj_fee'      => 'Taxa CNPJ',
            'icms_fee'      => 'Taxa ICMS',
            'advisory_fee'  => 'Taxa de consultoria'
        ];
    }

    public function validate($data) {
        return new Validator($data, $this->getRules(), $this->getNames());
    }
}